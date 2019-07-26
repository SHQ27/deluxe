<?php

require_once dirname(__FILE__).'/../lib/eshopsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eshopsGeneratorHelper.class.php';

/**
 * eshops actions.
 *
 * @package    deluxebuys
 * @subpackage eshops
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopsActions extends autoEshopsActions
{
  public function executeOrdenarProductos(sfWebRequest $request)
  {
      // Recepcion de parametros
      $idEshop = $request->getParameter('idEshop');
      $eshop = eshopTable::getInstance()->getById( $idEshop );

      // Form
      $form = new ordenarProductosEshopsForm();
    
      if( $request->isMethod('post') )
      {
        $form->bind( $request->getParameter('ordenarProductosEshops') );
    
        if ( $form->isValid() ) 
        {
          $form->save();

          cacheHelper::getInstance()->clearListados() ;
          $this->getUser()->setFlash('notice', 'Se actualizaron los ordenes correctamente.');

              $this->redirect( $this->getController()->genUrl(
                array(
                  'sf_route' => 'eshop_ordenar_productos',
                  'idEshop' => $idEshop
                )
            ));
        }
      }

      // Listado de productos
      $filtros = array( 'idEshop' => $eshop->getIdEshop() );

      $queryProductos = productoTable::getInstance()->queryFilterBy( $filtros, 'all', false );
      $productos = $queryProductos->execute();

      // Variables de template
      $this->eshop = $eshop;
      $this->productos = $productos;
      $this->form = $form;
  }

  public function executeOrdenarCategorias(sfWebRequest $request)
  {
      // Recepcion de parametros
      $idEshop = $request->getParameter('idEshop');
      $eshop = eshopTable::getInstance()->getById( $idEshop );

      // Form
      $form = new ordenarCategoriasEshopsForm( array(), array('idEshop' => $idEshop ) );
    
      if( $request->isMethod('post') )
      {
        $form->bind( $request->getParameter('ordenarCategoriasEshops') );
    
        if ( $form->isValid() ) 
        {
          $form->save();

          cacheHelper::getInstance()->clearListados() ;
          $this->getUser()->setFlash('notice', 'Se actualizaron los ordenes correctamente.');

              $this->redirect( $this->getController()->genUrl(
                array(
                  'sf_route' => 'eshop_ordenar_categorias',
                  'idEshop' => $idEshop
                )
            ));
        }
      }

      // Listado de categorias
      $filtros = array( 'idEshop' => $eshop->getIdEshop() );

      $categoriasPrendas = productoCategoriaTable::getInstance()->listByIdProductoGeneroEshops(
        $eshop->getIdProductoGenero(),
        $eshop->getIdEshop(),
        productoCategoriaEshop::TIPO_PRENDA_PRENDA
      );
      
      $categoriasAccesorios = productoCategoriaTable::getInstance()->listByIdProductoGeneroEshops(
        $eshop->getIdProductoGenero(),
        $eshop->getIdEshop(),
        productoCategoriaEshop::TIPO_PRENDA_ACCESORIO
      );

      // Variables de template
      $this->eshop = $eshop;
      $this->categoriasPrendas = $categoriasPrendas;
      $this->categoriasAccesorios = $categoriasAccesorios;
      $this->form = $form;
  }

  public function executeModificarImagenCategoria(sfWebRequest $request)
  {
      // Recepcion de parametros
      $idEshop = $request->getParameter('idEshop');
      $eshop = eshopTable::getInstance()->getById( $idEshop );

      $idProductoCategoria = $request->getParameter('idProductoCategoria');
      $productoCategoria = productoCategoriaTable::getInstance()->getById($idProductoCategoria);

      // Form
      $form = new modificarImagenCategoriaEshopForm(
        array(),
        array(
          'idEshop' => $idEshop,
          'idProductoCategoria' => $idProductoCategoria
        )
      );
    
      if( $request->isMethod('post') )
      {
        $form->bind(
          $request->getParameter('modificarImagenCategoriaEshop'),
          $request->getFiles('modificarImagenCategoriaEshop')
        );
    
        if ( $form->isValid() ) 
        {
          $form->save();

          $this->getUser()->setFlash('notice', 'La imagen de la categoria "' .  $productoCategoria->getDenominacion() . '" se actualizó correctamente.');

              $this->redirect( $this->getController()->genUrl(
                array(
                  'sf_route' => 'eshop_ordenar_categorias',
                  'idEshop' => $idEshop
                )
            ));
        }
      }


      // Variables de template
      $this->eshop = $eshop;
      $this->productoCategoria = $productoCategoria;
      $this->form = $form;
  }

  public function executeDescargarResumenPedidos(sfWebRequest $request)
  {
    $hash = $request->getParameter('hash');

    $params = base64_decode($hash);
    $params = json_decode($params, true);

    $idEshop = $params['idEshop'];
    $fecha   = $params['fecha'];
    $hash    = $params['hash'];

    $eshop      = eshopTable::getInstance()->getById( $idEshop );
    $hashValido = $eshop->getHashResumenPedidos( $fecha );

    if ( $hash === $hashValido ) {
      $this->descargarResumenPedidos( $eshop, $fecha );
      exit;
    }

    $this->setTemplate('hashInexistente');
  }

  protected function descargarResumenPedidos( $eshop, $fecha )
  {
    set_time_limit(0);
    
    // Armo el xls
    $dateNow = date('Y-m-d H:i:s');
      
    $phpExcel = new PHPExcel();
    
    $phpExcel->getProperties()->setCreator("DeluxeBuys");
    $activeSheet = $phpExcel->setActiveSheetIndex(0);    

    $headerCellStyle = array(
        'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FFFFFF')),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '333333')
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'))));
    
    $boldCellStyle = array(
        'font' => array('bold' => true, 'size' => "10"),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'))));
    
    $dataCellStyle = array(
        'font' => array('size' => "10"),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'))));

      
    $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
     
    $fechaLegible = date('d-m-Y', strtotime($fecha) );
    $activeSheet->setCellValue('A1', $eshop->getDenominacion() . ' - Planilla de pedidos del dia ' . $fechaLegible);
    $activeSheet->mergeCells('A1:D1');
    $activeSheet->mergeCells('A2:D2');
          
  
    $pedidos = pedidoTable::getInstance()->listPagadosIn( $fecha, $eshop->getIdEshop() );


    $activeSheet->setCellValue('A3', 'CodPedido');
    $activeSheet->setCellValue('B3', 'Cod prod');
    $activeSheet->setCellValue('C3', 'Producto');
    $activeSheet->setCellValue('D3', 'Color');
    $activeSheet->setCellValue('E3', 'Talle');
    $activeSheet->setCellValue('F3', 'Precio lista');
    $activeSheet->setCellValue('G3', 'Precio DB');
    $activeSheet->setCellValue('H3', 'Precio DB (Sin IVA)');
    $activeSheet->setCellValue('I3', 'Cnt');
    $activeSheet->setCellValue('J3', 'Desc');
    $activeSheet->setCellValue('K3', 'Envío');
    $activeSheet->setCellValue('L3', 'Total');
    $activeSheet->setCellValue('M3', 'Facturación');
    $activeSheet->setCellValue('N3', 'Cliente');
    $activeSheet->setCellValue('O3', 'Teléfono');
    $activeSheet->setCellValue('P3', 'Pagado?');
    $activeSheet->setCellValue('Q3', 'Forma pago');
    $activeSheet->setCellValue('R3', 'Fecha');
    $activeSheet->setCellValue('S3', 'Dirección');
    $activeSheet->setCellValue('T3', 'Código Postal');
    $activeSheet->setCellValue('U3', 'Localidad');
    $activeSheet->setCellValue('V3', 'Provincia');
    $activeSheet->setCellValue('W3', 'Email');
    $activeSheet->setCellValue('X3', 'DNI');
    
    $activeSheet->getStyle('A3:X3')->applyFromArray($headerCellStyle);
    
    $i = 4;
    foreach ($pedidos as $pedido)
    {
      $activeSheet->getStyle('A' . $i)->applyFromArray( $boldCellStyle );

      $pedidoProductoItems = $pedido->getPedidoProductoItem();
      $usuario = $pedido->getUsuario();

      $activeSheet->setCellValue('J' . $i, $pedido->getMontoDescuento() );
      $activeSheet->setCellValue('K' . $i, $pedido->getMontoEnvio() );
      $activeSheet->setCellValue('L' . $i, $pedido->getMontoTotal());
      
      $facturacion = $pedido->getFacturacion();
      $activeSheet->setCellValue('M' . $i, $facturacion);     
     
      $activeSheet->setCellValue('W' . $i, $usuario->getEmail() );

      if ( $usuario->getDocumento() ) {
        $activeSheet->setCellValue('X' . $i, $usuario->getTipoDocumento() . ' ' . $usuario->getDocumento() );  
      }
      
      
      foreach ($pedidoProductoItems as $pedidoProductoItem)
      {
        $productoItem = $pedidoProductoItem->getProductoItem();
        $producto = $productoItem->getProducto();
              
        $marca = $producto->getMarca();
        
        
        $activeSheet->setCellValue('A' . $i, $pedido->getIdPedido() );
        $activeSheet->setCellValue('B' . $i, $productoItem->getCodigo() );
        $activeSheet->setCellValue('C' . $i, $producto->getDenominacion() );
        $activeSheet->setCellValue('D' . $i, $pedidoProductoItem->getProductoColor()->getDenominacion() );
        $activeSheet->setCellValue('E' . $i, $pedidoProductoItem->getProductoTalle()->getDenominacion() );
        $activeSheet->setCellValue('F' . $i, $pedidoProductoItem->getPrecioLista() );
        
        $activeSheet->setCellValue('G' . $i, $pedidoProductoItem->getPrecioDeluxe() );
        $activeSheet->setCellValue('H' . $i, $pedidoProductoItem->getPrecioDeluxeSinIva() );

        
        
        $activeSheet->setCellValue('I' . $i, $pedidoProductoItem->getCantidad());
        
        $activeSheet->setCellValue('N' . $i, $usuario->getNombre() . ' ' . $usuario->getApellido() );
        $activeSheet->setCellValue('O' . $i, $usuario->getTelefono() );
        
        $fuePagado = ($pedido->getFechaPago())? 'Si' : 'No';      
        $activeSheet->setCellValue('P' . $i, $fuePagado);
        
        $activeSheet->setCellValue('Q' . $i, $pedido->getDescripcionFormaPago(' - ') );
        
        $activeSheet->setCellValue('R' . $i, $pedido->getDateTimeObject('fecha_alta')->format("y-m-d") );
        

        $envioDetalle = $pedido->getArrayEnvioDetalle();


        if ( $envioDetalle['tipo'] == CarritoEnvio::SUCURSAL) {
          $activeSheet->setCellValue('S' . $i, 'SUCURSAL: ' . $envioDetalle['sucursal'] . ' - ' . $envioDetalle['direccion'] );
          $activeSheet->setCellValue('T' . $i, $envioDetalle['codigo_postal'] );
        } else {
          $activeSheet->setCellValue('S' . $i, $envioDetalle['direccion'] );
          $activeSheet->setCellValue('T' . $i, $envioDetalle['codigo_postal'] );
        } 
        
        $activeSheet->setCellValue('U' . $i, $envioDetalle['localidad'] );
        $activeSheet->setCellValue('V' . $i, $envioDetalle['provincia'] );
        
        $activeSheet->getStyle('A' . $i . ':X' . $i )->applyFromArray($dataCellStyle);

        $i++;
      }
    }
    
    $eshopSlug = StringHelper::getInstance()->slug( $eshop->getDenominacion() );
         
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="resumen_pedidos_' . $eshopSlug . '_' . $fechaLegible . '.xls"');
    header('Cache-Control: max-age=0');
    
    $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
    $writer->save('php://output');
    
    exit;

  }


  protected function buildQuery()
  {         
      $q = parent::buildQuery();
      $rootAlias = $q->getRootAlias();
      $q->addWhere( $rootAlias . '.activo = true');
      $q->orderBy( $rootAlias . '.id_eshop ASC');
  
      return $q;
  }
}
