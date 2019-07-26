<?php

/**
 * devueltosMarcas actions.
 *
 * @package    deluxebuys
 * @subpackage pedido
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devueltosMarcasActions extends sfActions
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
      $devuelto = false;
      $fecha = null;
      $form = new devueltosMarcasFiltroForm();
            
      if( $request->isMethod('post') )
      {
          $params = $request->getParameter('devueltosMarcasFiltroForm');
          $params['_csrf_token'] = $form->getCSRFToken();
          $form->bind( $params );
          
          if ( $form->isValid() )
          {              
              $this->getList($page, $form->getIdMarca(), $form->getFecha(), $form->getDevuelto());
              $idMarca = $form->getIdMarca();
              $fecha = $form->getFecha();
              $devuelto = $form->getDevuelto();              
          }
      }
      else
      {
          $this->getList($page);
      }
      
      $this->form = $form;
      $this->idMarca = $idMarca;
      $this->fecha = $fecha;
      $this->devuelto = $devuelto;      
  }
  
 /**
  * Executes new action
  *
  * @param sfRequest $request A request object
  */
  public function executeNew(sfWebRequest $request)
  {
    $idPedido = $request->getParameter('idPedido');

    if ( $idPedido ) {
      $pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );  
      $pedidoProductoItems = $pedido->getPedidoProductoItem();

      $form = new devueltosMarcasNewForm( array(), array('pedidoProductoItems' => $pedidoProductoItems ) );
            
      if( $request->isMethod('post') )
      {
          $params = $request->getParameter('devueltosMarcasNewForm');
          $params['_csrf_token'] = $form->getCSRFToken();
          
          $form->bind( $params );
          
          if ( $form->isValid() ) {
              $form->process();
              $this->getUser()->setFlash('notice', 'Las Devoluciones Pendientes a Marcas se generaron correctamente');
              $this->redirect('@devueltosMarcas');
          }
      }

      $this->form = $form;
      $this->pedido = $pedido;
      $this->pedidoProductoItems = $pedidoProductoItems;
    } else {
      $this->form = null;
      $this->pedido = null;
      $this->pedidoProductoItems = null;
    }
  }

  protected function getList($page, $idMarca = null, $fechas = null, $devuelto = false )
  {
      $filters = sfContext::getInstance()->getUser()->getAttribute('devueltosMarcas_filters');
      
      if ( !isset($filters['page']) ) {
          $filters['page'] = 1;
      }
      
      if ( !isset($filters['id_marca']) )  {
          $filters['id_marca'] = null;
      }
      
      if ( $page || $idMarca )
      {
          
          if ( $page ) {
              $filters['page'] = $page;
          }
          
          if ( $idMarca ) {
              $filters['id_marca'] = $idMarca;
          }
          
          sfContext::getInstance()->getUser()->setAttribute('devueltosMarcas_filters', $filters );
      }
      
      $page = $filters['page'];
      $idMarca = $filters['id_marca'];
      
      $rpp = 30;
      
      $idMarca = ( $idMarca == 'TODAS' ) ? null : $idMarca;      
      
      $devueltosMarcas =  devueltoMarcaTable::getInstance()->queryDevueltosMarcas( $idMarca, $fechas['from'], $fechas['to'], $devuelto );
      
      $pager = new Doctrine_Pager
      (
              $devueltosMarcas,
              $page,
              $rpp
      );
      
      $pagerRange = new Doctrine_Pager_Range_Sliding( array( 'chunk' => 5 ), $pager );
      
      $this->pager = $pager;
      $this->pagerRange = $pagerRange;
      $this->devueltosMarcas = $pager->execute( array(), Doctrine::HYDRATE_ARRAY );
  }
  
  /**
   * Executes devolver action
   *
   * @param sfRequest $request A request object
   */
  public function executeDevolver(sfWebRequest $request)
  {
      $ids = $request->getParameter('ids');
      $ids = explode(',', $ids);
      
      $devueltos = false;
      $devueltosMarcas = devueltoMarcaTable::getInstance()->listXDevolver( $ids );
      
      $form = new devueltosMarcasDevolverForm();
            
      if( $request->isMethod('post') )
      {
          $params = $request->getParameter('devueltosMarcasDevolverForm');
          $params['_csrf_token'] = $form->getCSRFToken();
          
          $form->bind( $params );
                    
          if ( $form->isValid() )
          {
              $devueltos = $form->process();
          }
      }
      
      $this->form = $form;
      $this->devueltosMarcas = $devueltosMarcas;
      $this->devueltos = $devueltos;
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
          
      $devuelto = $request->getParameter('devuelto', false);
      
      $devueltosMarcas =  devueltoMarcaTable::getInstance()->queryDevueltosMarcas( $idMarca, $fechas['from'], $fechas['to'], $devuelto )->fetchArray();
  
      $dateNow = date('Y-m-d H:i:s');
  
      $phpExcel = new PHPExcel();
  
      $phpExcel->getProperties()->setCreator("DeluxeBuys");
      $activeSheet = $phpExcel->setActiveSheetIndex(0);
  
      $activeSheet->setCellValue('A1', 'Deluxebuys - Devoluciones Pendientes a Marcas');
      $activeSheet->mergeCells('A1:D1');
      $activeSheet->mergeCells('A2:D2');
  
      $activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
      $activeSheet->mergeCells('A3:D3');
  
      $activeSheet->setCellValue('A4', 'Marca: ' . $marca );
      $activeSheet->mergeCells('A4:D4');
      
      $fecha = '';
      if ( $fechas['from'] ) $fecha .= 'Desde ' . $fechas['from'] . ' ';
      if ( $fechas['to'] )   $fecha .= 'Hasta ' . $fechas['to'];
      if ( $fechas['from'] || $fechas['to'] ) $activeSheet->setCellValue('A5', 'Fecha: ' . $fecha );
      $activeSheet->mergeCells('A5:D5');
  
      $activeSheet->setCellValue('A7', 'Id de Devuelto');
      $activeSheet->setCellValue('B7', 'Codigo');
      $activeSheet->setCellValue('C7', 'Denominación');
      $activeSheet->setCellValue('D7', 'Talle');
      $activeSheet->setCellValue('E7', 'Color');
      $activeSheet->setCellValue('F7', 'Marca');
      $activeSheet->setCellValue('G7', 'Costo');
      $activeSheet->setCellValue('H7', 'Cantidad');
      
      
      $i = 8;
      foreach ($devueltosMarcas as $devueltoMarca)
      {   
          $activeSheet->setCellValue('A' . $i, $devueltoMarca['id_devuelto_marca']);       
          $activeSheet->setCellValue('B' . $i, $devueltoMarca['codigo']);
          $activeSheet->setCellValue('C' . $i, $devueltoMarca['denominacion']);
          $activeSheet->setCellValue('D' . $i, $devueltoMarca['talle']);
          $activeSheet->setCellValue('E' . $i, $devueltoMarca['color']);
          $activeSheet->setCellValue('F' . $i, $devueltoMarca['marca']);
          $activeSheet->setCellValue('G' . $i, $devueltoMarca['costo']);
          $activeSheet->setCellValue('H' . $i, $devueltoMarca['cantidad']);
  
          $i++;
      }
  
  
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="reporte_devoluciones_pendientes_a_marcas.xls"');
      header('Cache-Control: max-age=0');
  
      $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
      $writer->save('php://output');
  
      exit;
  }
  
  
}