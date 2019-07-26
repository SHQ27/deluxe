<?php

/**
 * fallados actions.
 *
 * @package    deluxebuys
 * @subpackage pedido
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class falladosActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {      
      $page = $request->getParameter('page', null);
      $idMarca = null;
      $fecha = null;
      $idEshop = null;
      
      $form = new falladosFiltroForm();
            
      if( $request->isMethod('post') )
      {
          $params = $request->getParameter('falladosFiltroForm');
          $params['_csrf_token'] = $form->getCSRFToken();
          $form->bind( $params );
          
          if ( $form->isValid() )
          {              
              $this->getList($page, $form->getIdMarca(), $form->getFecha(), $form->getIdEshop());
              $idMarca = $form->getIdMarca();
              $fecha = $form->getFecha();
              $idEshop = $form->getIdEshop();
          }
      }
      else
      {
          $this->getList($page);
      }
      
      $this->form = $form;
      $this->idMarca = $idMarca;
      $this->fecha = $fecha;
      $this->idEshop = $idEshop;
      
  }
  
  protected function getList($page, $idMarca = null, $fechas = null, $idEshop = null )
  {
      $filters = sfContext::getInstance()->getUser()->getAttribute('fallados_filters');
      
      if ( !isset($filters['page']) ) {
          $filters['page'] = 1;
      }
      
      if ( !isset($filters['id_marca']) )  {
          $filters['id_marca'] = null;
      }

      if ( !isset($filters['fechas']) )  {
          $filters['fecha'] = null;
      }
      
      if ( !isset($filters['id_eshop']) )  {
          $filters['id_eshop'] = null;
      }
      
      if ( $page || $idMarca || $fechas || $idEshop )
      {
          
          if ( $page ) {
              $filters['page'] = $page;
          }
          
          if ( $idMarca ) {
              $filters['id_marca'] = $idMarca;
          }
          
          if ( $fechas ) {
              $filters['fecha'] = $fechas;
          }

          if ( $idEshop ) {
              $filters['id_eshop'] = $idEshop;
          }
          
          sfContext::getInstance()->getUser()->setAttribute('fallados_filters', $filters );
      }
      
      $page = $filters['page'];
      $idMarca = $filters['id_marca'];
      $fechas = $filters['fecha'];
      $idEshop = $filters['id_eshop'];
      
      $rpp = 30;
      
      $idMarca = ( $idMarca == 'TODAS' ) ? null : $idMarca;
      $idEshop = ( $idEshop == 'TODOS' ) ? null : $idEshop;
            
      $fallados = falladoTable::getInstance()->queryFallados( $idMarca, $idEshop, $fechas['from'], $fechas['to'] );
           
      $pager = new Doctrine_Pager
      (
              $fallados,
              $page,
              $rpp
      );
      
      $pagerRange = new Doctrine_Pager_Range_Sliding( array( 'chunk' => 5 ), $pager );
      
      $this->pager = $pager;
      $this->pagerRange = $pagerRange;
      $this->fallados = $pager->execute( array(), Doctrine::HYDRATE_ARRAY );
  }
  
  /**
   * Executes recuperar action
   *
   * @param sfRequest $request A request object
   */
  public function executeRecuperar(sfWebRequest $request)
  {
      $ids = $request->getParameter('ids');
      $ids = explode(',', $ids);
      
      $recuperados = false;
      $fallados = falladoTable::getInstance()->listXRecuperar( $ids );
      
      $form = new falladosRecuperarForm();
            
      if( $request->isMethod('post') )
      {
          $params = $request->getParameter('falladosRecuperarForm');
          $params['_csrf_token'] = $form->getCSRFToken();
          
          $form->bind( $params );
          
          echo $form->getErrorSchema();
          
          if ( $form->isValid() )
          {
              $recuperados = $form->process();
          }
      }
      
      $this->form = $form;
      $this->fallados = $fallados;
      $this->recuperados = $recuperados;
  }
  
  
  public function executeDescargarExcel(sfWebRequest $request)
  {
      set_time_limit(0);
       
      $idMarca = $request->getParameter('id_marca');
      $marca = marcaTable::getInstance()->getOneById($idMarca);
      
      if ( $marca ) {
          $marca = $marca->getNombre();
      } else {
          $marca = 'Todas';
          $idMarca = null;
      }

      $fechas = array();
      $fechas['from'] = ( $request->getParameter('fecha_from') ) ? $request->getParameter('fecha_from') : null;
      $fechas['to'] = ( $request->getParameter('fecha_to') ) ? $request->getParameter('fecha_to') : null;
      
      $idEshop = $request->getParameter('id_eshop');
      $eshop = eshopTable::getInstance()->getById( $idEshop );
      
      if ( $eshop ) {
          $eshop = $eshop->getDenominacion();
      } else {
          $eshop = 'Todos';
          $idEshop = null;
      }
          
      $fallados = falladoTable::getInstance()->listForExcel( $idMarca, $idEshop, $fechas['from'], $fechas['to'] );
  
      $dateNow = date('Y-m-d H:i:s');
  
      $phpExcel = new PHPExcel();
  
      $phpExcel->getProperties()->setCreator("DeluxeBuys");
      $activeSheet = $phpExcel->setActiveSheetIndex(0);
  
      $activeSheet->setCellValue('A1', 'Deluxebuys - Fallados');
      $activeSheet->mergeCells('A1:D1');
      $activeSheet->mergeCells('A2:D2');
  
      $activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
      $activeSheet->mergeCells('A3:D3');
  
      $activeSheet->setCellValue('A4', 'Marca: ' . $marca );
      $activeSheet->mergeCells('A4:D4');
      
      $activeSheet->setCellValue('A5', 'eShop: ' . $eshop );
      $activeSheet->mergeCells('A5:D5');
      
      $fecha = '';
      if ( $fechas['from'] ) $fecha .= 'Desde ' . $fechas['from'] . ' ';
      if ( $fechas['to'] )   $fecha .= 'Hasta ' . $fechas['to'];
      if ( $fechas['from'] || $fechas['to'] ) $activeSheet->setCellValue('A5', 'Fecha: ' . $fecha );
      $activeSheet->mergeCells('A6:D6');
  
      $activeSheet->setCellValue('A8', 'Id de Fallado');
      $activeSheet->setCellValue('B8', 'Codigo');
      $activeSheet->setCellValue('C8', 'eShop');
      $activeSheet->setCellValue('D8', 'Denominación');
      $activeSheet->setCellValue('E8', 'Talle');
      $activeSheet->setCellValue('F8', 'Color');
      $activeSheet->setCellValue('G8', 'Marca');
      $activeSheet->setCellValue('H8', 'Costo');
      $activeSheet->setCellValue('I8', 'Descripcion');
      
      
      $i = 9;
      foreach ($fallados as $fallado)
      {   
          $activeSheet->setCellValue('A' . $i, $fallado['id_fallado']);       
          $activeSheet->setCellValue('B' . $i, $fallado['codigo']);
          $activeSheet->setCellValue('C' . $i, $fallado['eshop']);
          $activeSheet->setCellValue('D' . $i, $fallado['denominacion']);
          $activeSheet->setCellValue('E' . $i, $fallado['talle']);
          $activeSheet->setCellValue('F' . $i, $fallado['color']);
          $activeSheet->setCellValue('G' . $i, $fallado['marca']);
          $activeSheet->setCellValue('H' . $i, $fallado['costo']);
          $activeSheet->setCellValue('I' . $i, $fallado['descripcion']);
  
          $i++;
      }
  
  
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte_fallados.xls"');
      header('Cache-Control: max-age=0');
  
      $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
      $writer->save('php://output');
  
      exit;
  }
  
  
}