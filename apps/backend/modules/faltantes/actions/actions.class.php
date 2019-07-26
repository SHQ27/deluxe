<?php

require_once dirname(__FILE__).'/../lib/faltantesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/faltantesGeneratorHelper.class.php';

/**
 * faltantes actions.
 *
 * @package    deluxebuys
 * @subpackage faltantes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faltantesActions extends autoFaltantesActions
{

    public function executeFilter(sfWebRequest $request)
    {
        $this->setPage(1);
    
        if ($request->hasParameter('_reset'))
        {
            $this->setFilters($this->configuration->getFilterDefaults());
    
            $this->redirect('@faltante');
        }
    
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
    
        $params = $request->getParameter($this->filters->getName());
        $params['_csrf_token'] = $this->filters->getCSRFToken();
        
        $this->filters->bind($params);
        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());
    
            $this->redirect('@faltante');
        }
    
        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
    
        $this->setTemplate('index');
    }
    
  public function executeListDevueltoMP(sfWebRequest $request)
  {
    $faltante = $this->getRoute()->getObject();
    $detallado = $faltante->getMontoADevolver(true);
    
    $pedido = $faltante->getPedido();
    
    $montoADevolver = $detallado['MP']['EFECTIVO'] + $detallado['MP']['BONIFICACION'];  
    
    // Si hay monto a bonificar se realiza la bonificacion
    if ( $detallado['MP']['BONIFICACION'] > 0 )
    {
        $bonificacion = new bonificacion();
        $bonificacion->setIdUsuario( $pedido->getIdUsuario() );
        $bonificacion->setIdTipoDescuento( tipoDescuento::MONTOFIJO );
        $bonificacion->setIdTipoBonificacion( tipoBonificacion::REINTEGRO );
        $bonificacion->setValor( $detallado['MP']['BONIFICACION'] );
        $bonificacion->setObservaciones('Creada automaticamente por el faltante #' . $faltante->getIdFaltante() );
        $bonificacion->save();
    }
    
    reporteCronologicoTable::getInstance()->save(reporteCronologico::FALTANTE, array( 'idFaltante' => $faltante->getIdFaltante(), 'bonificacion' => $detallado['MP']['BONIFICACION'], 'efectivo' => $detallado['MP']['EFECTIVO'] ) );
    
    // Actualizo el faltante
    $faltante->setProcesado( true );
    $faltante->setFechaProcesado( new Doctrine_Expression('now()') );
    $faltante->setMontoDevuelto( $montoADevolver );
    $faltante->save();
    
    
    // Si el faltante no es de un pedido de eShop, genero una nota de credito
    if ( !$pedido->getIdEshop() ) {
        ncreditoTable::getInstance()->insert( array( $faltante->getIdPedido() ), $montoADevolver );
    // Si es de eshop, genero un recibo de tipo nota de credito
    } else {
        reciboEshopTable::getInstance()->insert( $pedido->getIdEshop(), array( $faltante->getIdPedido() ), $montoADevolver, reciboEshop::TIPO_NOTA_DE_CREDITO );
    }
    
    $this->redirect('@faltante');
  }
  
  public function executeListGenerarBonificacion(sfWebRequest $request)
  {
      $faltante = $this->getRoute()->getObject();
      faltanteTable::getInstance()->generarBonificacion($faltante);
      $this->redirect('@faltante');
  }
    
  public function executeGenerar(sfWebRequest $request)
  {
    $form = new faltantesForm();  
    $this->form = $form;
  }

  public function executeGenerarResultado(sfWebRequest $request)
  {  
    $idEshop = $request->getParameter('idEshop');
    $idCampana = $request->getParameter('idCampana');
    $idProductoItem = $request->getParameter('idProductoItem');
    
    $pedidos = pedidoTable::getInstance()->searchFaltantes($idEshop, $idCampana, $idProductoItem);
        
    $esOutlet = array();
    foreach ( $pedidos as $pedido )
    {
        $pedidoProductoItem = pedidoProductoItemTable::getInstance()->getByCompoundKey($pedido->getIdPedido(), $idProductoItem);
        $esOutlet[ $pedido->getIdPedido() ] = $pedidoProductoItem->esOutlet(); 
    }
    
    $this->pedidos = $pedidos;
    $this->idProductoItem = $idProductoItem;
    $this->esOutlet = $esOutlet;

    $this->setLayout(false);
  }

  public function executeEnvio(sfWebRequest $request)
  {
    $idPedido = $request->getParameter('idPedido');
    $idProductoItem = $request->getParameter('idProductoItem');
    
    $pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );
    $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );
    $pedidoProductoItem = pedidoProductoItemTable::getInstance()->getByCompoundKey($pedido->getIdPedido(), $productoItem->getIdProductoItem() );
    
    $form = new faltanteEnvioForm( array(), array('cantidad' => $pedidoProductoItem->getCantidad() ) );
    
    if( $request->isMethod('post') )
    {
      $form->bind( $request->getParameter('faltanteEnvio') );
    
      if ( $form->isValid() )
      {
        $this->enviado = $form->send($pedido, $productoItem);
      }
    }
    
    $this->form = $form;
    $this->pedido = $pedido;
    $this->productoItem = $productoItem;    
  }
  
  public function executeListProductos(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $idMarca = $request->getParameter('idMarca');
    $idEshop = $request->getParameter('idEshop', null);
    
    if ( $idCampana == 'STKPER' )
    {
        $productos = productoTable::getInstance()->listVendidosEnStockPermanente($idEshop, $idMarca, false);
    }
    else if ( $idCampana == 'OUTLET' )
    {
        $productos = productoTable::getInstance()->listVendidosEnStockPermanente($idEshop, $idMarca, true);
    }
    else
    {
        $productos = productoTable::getInstance()->listVendidosEnCampana($idEshop, $idMarca, $idCampana);
    }
    
    $choices = array();
    foreach ($productos as $producto)
    {
      $choices[] = array( 'idProducto' => $producto->getIdProducto(), 'denominacion' => $producto->getDenominacion()  );
    }
    
    echo json_encode($choices);
    exit;
  }
  
  public function executeListProductoItems(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $idEshop = $request->getParameter('idEshop', null);
    $idProducto = $request->getParameter('idProducto');
            
    if ( $idCampana == 'STKPER' )
    {
        $productoItems = productoItemTable::getInstance()->listVendidosStockPermanente($idEshop, false, $idProducto);
    }
    else if ( $idCampana == 'OUTLET' )
    {
        $productoItems = productoItemTable::getInstance()->listVendidosStockPermanente($idEshop, true, $idProducto);
    }
    else
    {
        $productoItems = productoItemTable::getInstance()->listVendidosEnCampanaXProducto($idEshop, $idCampana, $idProducto);
    }
  
    $choices = array();
    foreach ($productoItems as $productoItem)
    {     
      $choices[] = array( 'idProductoItem' => $productoItem->getIdProductoItem(), 'denominacion' => 'Talle: ' . $productoItem->getProductoTalle()->getDenominacion() . '  |  Color: ' . $productoItem->getProductoColor()->getDenominacion()  );
    }
  
    echo json_encode($choices);
    exit;
  }
  
  public function executeDescargarExcel(sfWebRequest $request)
  {
      set_time_limit(0);

      $filters = $this->getFilters();
      
      $idPedido = (string) $filters['id_pedido'];
      $desde = (string) $filters['fecha_aviso']['from'];
      $hasta = (string) $filters['fecha_aviso']['to'];
      
      $marca = marcaTable::getInstance()->getOneById($filters['marca']);
      $campana = campanaTable::getInstance()->getById($filters['campana']);
      
      $marcaNombre = ( $marca ) ? $marca->getNombre() : 'Todas';
      $campanaDenominacion = ( $campana ) ? $campana->getDenominacion() : 'Todas';
      
      $faltantes = $this->buildQuery()->execute();
  
      $dateNow = date('Y-m-d H:i:s');
      
      $headerCellStyle = array(
              'font' => array('bold' => true),
              'borders' => array(
                      'allborders' => array(
                              'style' => PHPExcel_Style_Border::BORDER_THIN,
                              'color' => array('argb' => '000000'))));
  
      $phpExcel = new PHPExcel();
  
      $phpExcel->getProperties()->setCreator("DeluxeBuys");
      $activeSheet = $phpExcel->setActiveSheetIndex(0);
  
      $activeSheet->setCellValue('A1', 'Deluxebuys - Faltantes');
      $activeSheet->mergeCells('A1:D1');
      $activeSheet->mergeCells('A2:D2');
  
      $activeSheet->setCellValue('A3', 'Generada: ' . $dateNow);
      $activeSheet->mergeCells('A3:D3');
  
      $idPedido = ($idPedido) ? $idPedido : '-';
      $activeSheet->setCellValue('A4', 'Id Pedido: ' . $idPedido);
      $activeSheet->mergeCells('A4:D4');
        
      $activeSheet->setCellValue('A5', 'Desde: ' . $desde);
      $activeSheet->mergeCells('A5:D5');
        
      $activeSheet->setCellValue('A6', 'Hasta: ' . $hasta);
      $activeSheet->mergeCells('A6:D6');
      
      $activeSheet->setCellValue('A7', 'Marca: ' . $marcaNombre );
      $activeSheet->mergeCells('A7:D7');
      
      $activeSheet->setCellValue('A8', 'Campana: ' . $campanaDenominacion );
      $activeSheet->mergeCells('A8:D8');
  
      $activeSheet->setCellValue('A10', 'Id Faltante');
      $activeSheet->getStyle('A10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('A')->setAutosize(true);
      $activeSheet->getColumnDimension('A')->setWidth(5);
      
      $activeSheet->setCellValue('B10', 'Fecha Aviso');
      $activeSheet->getStyle('B10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('B')->setAutosize(true);
      $activeSheet->getColumnDimension('B')->setWidth(16);

      $activeSheet->setCellValue('C10', 'Marca');
      $activeSheet->getStyle('C10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('C')->setAutosize(true);
      $activeSheet->getColumnDimension('C')->setWidth(35);

      $activeSheet->setCellValue('D10', 'Campana');
      $activeSheet->getStyle('D10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('D')->setAutosize(true);
      $activeSheet->getColumnDimension('D')->setWidth(35);
      
      $activeSheet->setCellValue('E10', 'Denominacion');
      $activeSheet->getStyle('E10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('E')->setAutosize(true);
      $activeSheet->getColumnDimension('E')->setWidth(35);
      
      $activeSheet->setCellValue('F10', 'Talle');
      $activeSheet->getStyle('F10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('F')->setAutosize(true);
      $activeSheet->getColumnDimension('F')->setWidth(10);
      
      $activeSheet->setCellValue('G10', 'Color');
      $activeSheet->getStyle('G10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('G')->setAutosize(true);
      $activeSheet->getColumnDimension('G')->setWidth(10);
      
      $activeSheet->setCellValue('H10', 'Cant.');
      $activeSheet->getStyle('H10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('H')->setAutosize(true);
      $activeSheet->getColumnDimension('H')->setWidth(7);

      $activeSheet->setCellValue('I10', 'Monto Devuelto');
      $activeSheet->getStyle('I10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('I')->setAutosize(true);
      $activeSheet->getColumnDimension('I')->setWidth(15);      
      
      $activeSheet->setCellValue('J10', 'Costo Uni.');
      $activeSheet->getStyle('J10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('J')->setAutosize(true);
      $activeSheet->getColumnDimension('J')->setWidth(10);

      $activeSheet->setCellValue('K10', 'Id pedido');
      $activeSheet->getStyle('K10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('K')->setAutosize(true);
      $activeSheet->getColumnDimension('K')->setWidth(10);
      
      $activeSheet->setCellValue('L10', 'Factura Asoc.');
      $activeSheet->getStyle('L10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('L')->setAutosize(true);
      $activeSheet->getColumnDimension('L')->setWidth(15);
      
      $activeSheet->setCellValue('M10', 'Datos cliente');
      $activeSheet->getStyle('M10')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('M')->setAutosize(true);
      $activeSheet->getColumnDimension('M')->setWidth(25);
      
      $i = 11;
      foreach ($faltantes as $faltante)
      {
          $productoItem = $faltante->getProductoItem();
          $usuario = $faltante->getPedido()->getUsuario();
          
          $producto = $productoItem->getProducto();
          $marca = $producto->getMarca();
          
          $activeSheet->setCellValue('A' . $i, $faltante->getIdFaltante() );
          $activeSheet->setCellValue('B' . $i, $faltante->getDateTimeObject('fecha_aviso')->format("d/m/Y H:i") );
          $activeSheet->setCellValue('C' . $i, $marca->getNombre() );
          $activeSheet->setCellValue('D' . $i, $marca->getNombre() );
          
          
          $activeSheet->setCellValue('E' . $i, $producto->getDenominacion() );
          $activeSheet->setCellValue('F' . $i, $productoItem->getProductoTalle()->getDenominacion() );
          $activeSheet->setCellValue('G' . $i, $productoItem->getProductoColor()->getDenominacion() );

          $activeSheet->setCellValue('H' . $i, $faltante->getCantidad() );
          
          $activeSheet->setCellValue('I' . $i, $faltante->getMontoDevuelto() );
          
          $activeSheet->setCellValue('J' . $i, formatHelper::getInstance()->decimalNumber( $producto->getCosto() ) );
          
          $activeSheet->setCellValue('K' . $i, $faltante->getIdPedido() );
          
          $factura = $faltante->getPedido()->getFactura();
          $comprobante = ( $factura ) ? $factura->getComprobante() : 'No tiene';
          $activeSheet->setCellValue('L' . $i, $comprobante );
          
          $activeSheet->setCellValue('M' . $i, $usuario->getNombre() . "\n" . $usuario->getApellido() . "\n" . $usuario->getEmail() );
          $i++;
      }
  
  
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="faltantes.xls"');
      header('Cache-Control: max-age=0');
  
      $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
      $writer->save('php://output');
  
      exit;
  }
  
  public function executeDelete(sfWebRequest $request)
  {
      $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
  
      if ($this->getRoute()->getObject()->delete())
      {
          $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
      }
  
      $this->redirect('@faltante');
  }
  
  public function executeGeneracionAutomatica(sfWebRequest $request)
  {
    $tipo = $request->getParameter('tipo');
    $this->tipo = $tipo;

    $method = "generacionAutomatica" . $tipo;
    $this->$method( $request );
  }

  protected function generacionAutomaticaCAMPANA(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $idMarca = $request->getParameter('idMarca');
    $faltantes = $request->getParameter('faltantes');
    $confirmar = (bool) $request->getParameter('confirmar', false);

    // Recupero de Entidades de negocio desde la Base de datos
    $campana = campanaTable::getInstance()->getById( $idCampana );
    $marca = marcaTable::getInstance()->getOneById( $idMarca );


    // Generacion de faltantes
    $data = array();
    $faltantes = explode(',', $faltantes);
    foreach ($faltantes as $row) {
      list($idProductoItem, $cantidad) = explode('-', $row);

      $pedidos = pedidoTable::getInstance()->searchFaltantes(null, $idCampana, $idProductoItem);

      if ( !isset($data[$idProductoItem]) ) {

        $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );

        $data[$idProductoItem] = array(
          'row' => array(),
          'productoItem' => $productoItem
          );  
      }
      
      foreach ($pedidos as $pedido) {
        $pedidoProductoItems = $pedido->getPedidoProductoItem();

        foreach ($pedidoProductoItems as $pedidoProductoItem) {
          if ( $pedidoProductoItem->getIdProductoItem() == $idProductoItem ) {

            $cantidadAPasar = ( $cantidad <= $pedidoProductoItem->getCantidad() ) ? $cantidad : $pedidoProductoItem->getCantidad();

            $cantidad = $cantidad - $cantidadAPasar;

            $data[$idProductoItem]['row'][] = array('pedido' => $pedido, 'cantidad' =>  $cantidadAPasar);

            if ( $confirmar ) {
              $this->generarFaltanteAutomaticamente($pedido, $productoItem, $cantidadAPasar);
            }

            if ( $cantidad <= 0 ) {
              continue 3;
            } else {
              continue 2;
            }
          }
        }

      }
    }

    // Armado del link de confirmacion
    $params = array( 'tipo' => 'CAMPANA', 'idCampana' => $idCampana, 'idMarca' => $idMarca, 'faltantes' => implode(',', $faltantes) ); 
    $url = $this->getController()->genUrl( array( 'sf_route' => 'faltantes_generacionAutomatica') );
    $linkConfirmacion =  $url . '?' . http_build_query($params) . '&confirmar=1';

    // Armado del link para el siguiente paso del proceso
    $idsPedido = recepcionMercaderiaCampanaTable::getInstance()->getIdsPedidosEnviables( $idCampana );

    if( count( $idsPedido ) ) {
        $params = array( 'ids' => implode(',', $idsPedido), 'idMarca' => $idMarca ); 
        $url = $this->getController()->genUrl( array( 'sf_route' => 'pedido_preparar_envio') );          
        $linkProximoPaso = $url . '?' . http_build_query($params);
    } else {
      $linkProximoPaso = $this->getController()->genUrl( array( 'sf_route' => 'campanas_recepcionMercaderia_no_envios', 'idCampana' => $idCampana) );
    }

    if ( $confirmar ) {
      $this->redirect( $linkProximoPaso );
    }

    $this->campana = $campana;
    $this->marca = $marca;
    $this->data = $data;
    $this->linkConfirmacion = $linkConfirmacion;
    $this->linkProximoPaso = $linkProximoPaso;
  }

  protected function generacionAutomaticaESHOP(sfWebRequest $request)
  {
    $idEshop = $request->getParameter('idEshop');
    $idsPedido = $request->getParameter('idsPedido');
    $idsPedido = explode(',', $idsPedido);
    $faltantes = $request->getParameter('faltantes');
    $confirmar = (bool) $request->getParameter('confirmar', false);

    // Generacion de faltantes
    $data = array();
    $faltantes = explode(',', $faltantes);
    foreach ($faltantes as $row) {
      list($idProductoItem, $cantidad) = explode('-', $row);

      $pedidos = pedidoTable::getInstance()->searchFaltantes($idEshop, 'STKPER', $idProductoItem);

      if ( !isset($data[$idProductoItem]) ) {

        $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );

        $data[$idProductoItem] = array(
          'row' => array(),
          'productoItem' => $productoItem
          );  
      }
      
      foreach ($pedidos as $pedido) {

        /*
        * Se exluye de la geeneracion de faltantes a los pedidos que no son parte
        * de la recepcion de mercaderia de esSops
        */
        if ( !in_array( $pedido->getIdPedido() , $idsPedido) ) {
          continue;
        }

        $pedidoProductoItems = $pedido->getPedidoProductoItem();

        foreach ($pedidoProductoItems as $pedidoProductoItem) {
          if ( $pedidoProductoItem->getIdProductoItem() == $idProductoItem ) {

            $cantidadAPasar = ( $cantidad <= $pedidoProductoItem->getCantidad() ) ? $cantidad : $pedidoProductoItem->getCantidad();

            $cantidad = $cantidad - $cantidadAPasar;

            $data[$idProductoItem]['row'][] = array('pedido' => $pedido, 'cantidad' =>  $cantidadAPasar);

            if ( $confirmar ) {
              $this->generarFaltanteAutomaticamente($pedido, $productoItem, $cantidadAPasar);
            }

            if ( $cantidad <= 0 ) {
              continue 3;
            } else {
              continue 2;
            }
          }
        }

      }
    }

    // Armado del link de confirmacion
    $params = array( 'tipo' => 'ESHOP', 'idEshop' => $idEshop, 'faltantes' => implode(',', $faltantes), 'idsPedido' => implode(',', $idsPedido) ); 
    $url = $this->getController()->genUrl( array( 'sf_route' => 'faltantes_generacionAutomatica') );
    $linkConfirmacion =  $url . '?' . http_build_query($params) . '&confirmar=1';

    // Armado del link para el siguiente paso del proceso
    $pedidos = pedidoTable::getInstance()->listByIds( $idsPedido );
    $idsPedidoAEnviar = array();
    foreach ($pedidos as $pedido) {
      if ( !$pedido->todosSonFaltantes() ) {
        $idsPedidoAEnviar[] = $pedido->getIdPedido();  
      }
    }

    if( count( $idsPedidoAEnviar ) ) {
        $params = array( 'ids' => implode(',', $idsPedidoAEnviar) ); 
        $url = $this->getController()->genUrl( array( 'sf_route' => 'pedido_preparar_envio') );          
        $linkProximoPaso = $url . '?' . http_build_query($params);
      } else {
        $linkProximoPaso = $this->getController()->genUrl( array( 'sf_route' => 'pedidos_recepcionMercaderia_no_envios') );
      }

    if ( $confirmar ) {
      $this->redirect( $linkProximoPaso );
    }

    $this->data = $data;
    $this->linkConfirmacion = $linkConfirmacion;
    $this->linkProximoPaso = $linkProximoPaso;
  }

  protected function generarFaltanteAutomaticamente($pedido, $productoItem, $cantidadFaltante) {
    $mensaje = 'Debido a un inconveniente de stock';
    faltanteTable::getInstance()->generar($pedido, $productoItem, $cantidadFaltante, $mensaje);
  }
  
}
