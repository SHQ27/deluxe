<?php

require_once dirname(__FILE__).'/../lib/campanasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/campanasGeneratorHelper.class.php';

/**
 * campanas actions.
 *
 * @package    deluxebuys
 * @subpackage campanas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class campanasActions extends autoCampanasActions
{	
	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $campana = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $campana)));

      if ($request->hasParameter('_save_and_go_to_list'))
      {
        $this->redirect('@campana');
      }
      elseif ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@campana_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'campana_edit', 'sf_subject' => $campana));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
	
  public function executeAsignacionProductos(sfWebRequest $request)
  {
    set_time_limit(0);

    $idCampana = $request->getParameter('idCampana');
    $campana = campanaTable::getInstance()->getById( $idCampana );
      

    $marcas = array();
    $campanaMarcas = $campana->getCampanaMarca();
    foreach($campanaMarcas as $campanaMarca) {
        $marcas[] = $campanaMarca->getMarca();
    }
    $this->marcas = $marcas;
      
    $this->productosAsignados = productoTable::getInstance()->listByIdCampana($campana->getIdCampana(), false);   

    $this->campana = $campana;
  }

  public function executeAgregarProductos(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $campana = campanaTable::getInstance()->getById( $idCampana );

    $idsProductos = $request->getParameter('idsProductos');
    
    if ( $idsProductos ) {
      $idsProductos = explode(',', $idsProductos);  
    } else {
      $idsProductos = array();
    }    

    foreach ($idsProductos as $idProducto)
    {     
      $productoCampana = new productoCampana();
      $productoCampana->setIdCampana($campana->getIdCampana());
      $productoCampana->setIdProducto($idProducto);
      $productoCampana->save();
      
      productoLogTable::getInstance()->generate($idProducto, 'Se asigna a la Campaña #' . $campana->getIdCampana() . ' manualmente desde la edicion de la campaña.');
    }

    $campana->actualizarTextoPromocion();

    return $this->renderText('OK');
  }

  public function executeEliminarProductos(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $campana = campanaTable::getInstance()->getById( $idCampana );

    $desactivarProductos = $request->getParameter('desactivarProductos');

    $idsProductos = $request->getParameter('idsProductos');
    
    if ( $idsProductos ) {
      $idsProductos = explode(',', $idsProductos);  
    } else {
      $idsProductos = array();
    }

    if ( count( $idsProductos ) ) 
    {
        $productoCampana = productoCampanaTable::getInstance()->delete($campana->getIdCampana(), $idsProductos);
    }

    foreach ($idsProductos as $idProducto)
      {       
        productoLogTable::getInstance()->generate($idProducto, 'Se quita de la Campaña #' . $campana->getIdCampana() . ' manualmente desde la edicion de la campaña.');

        /*
         * Se guarda el pedido nuevamente para ejecutar el trigger postSave, que actualiza el precio_deluxe, segun
         * el origen del producto (Oferta, Stock Permanente o Outlet)
         * */
        $producto = productoTable::getInstance()->getById($idProducto);
        
        if ( $desactivarProductos ) $producto->setActivo(false);
        
        $producto->doNotPostActions( array(
            producto::POST_ACTION_CERRAR_PUBLICACION_ML
        ));
        
        $producto->save();
      }

    $campana->actualizarTextoPromocion();

    return $this->renderText('OK');
  }
  
  /**
  * Executes productsForCampaings action
  *
  * @param sfRequest $request A request object
  */
  public function executeProductsForCampaign(sfWebRequest $request)
  {
  	
  	$term = $request->getParameter('term');
  	
  	$idmarca = $request->getParameter('idmarca');

  	$productos = productoTable::getInstance()->buscarProductosDeMarca( $term, $idmarca );
  	
  	$results = array();
  	
  	foreach ($productos as $producto)
  	{	
		$results[] = array
			('id'=> $producto->getIdProducto(),
				'label'=> $producto->getDenominacion(),
				'value'=> $producto->getDenominacion()
			);
  	}  	
	
  	echo json_encode($results);
  	
 	return sfView::NONE;
  }	
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $campana = $this->getRoute()->getObject();
    
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $campana)));

    
    
    $estaAsociadaPedido = pedidoProductoItemCampanaTable::getInstance()->exists($campana->getIdCampana());

	if ( $estaAsociadaPedido )
    {
      $this->getUser()->setFlash('error', 'La campaña no se puede eliminar porque esta asociada a un pedido');
    }
    else if ($campana->delete())
    {
      $this->getUser()->setFlash('notice', 'La campaña fue eliminada correctamente');
    }

    $this->redirect('@campana');
  }
  
  public function executeResetearStock(sfWebRequest $request)
  {
  	$campana = $this->getRoute()->getObject();
  	
  	if ( $campana->resetearStock() )
  	{
        throw new Exception("Se ha producido un error, por favor contactarse con el administrador del sitio.");
  	}
  	else
  	{
        $this->redirect('/backend/campanas?resetear_stock=1');
  	}
  	
  	exit;
  }
  
  public function executeReenviarDatosAcceso(sfWebRequest $request)
  {
  	$email   = $request->getParameter('email');
  	$idCampana = $request->getParameter('idCampana');
  	
  	$campana = campanaTable::getInstance()->getById($idCampana);
  	$campanaUsuario = campanaUsuarioTable::getInstance()->getByCompoundKey($idCampana, $email);
  	
  	$usuario = $campana->getSlug() . '.' . $email;
  	
  	$password = campanaUsuarioTable::getInstance()->generateRandomPassword();
  	
  	$sfGuardUser = sfGuardUserTable::getInstance()->findOneById( $campanaUsuario->getIdSfGuardUser() );
  	$sfGuardUser->setPassword($password);
  	$sfGuardUser->save();
  	
  	campanaUsuarioTable::getInstance()->sendMailAccessData($campana, $usuario, $email, $password);
  	
  	exit;
  }
  
  public function executeUsuariosQueCompraron(sfWebRequest $request)
  {
    // Get campaign id
    $idCampana = $request->getParameter('idCampana');
    
    // Get the current campaign
    $campana = campanaTable::getInstance()->getById( $idCampana );
    
    $filepath = usuarioTable::getInstance()->compraronEnCampana( $idCampana  );
    
    $data = file_get_contents( $filepath);
    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=usuarios_compraron_" . $campana->getSlug() . ".csv");
    echo "Nombre,Apellido,Email,Sexo\n" . utf8_decode($data);
    
    unlink($filepath);
    exit;
  }
  
  public function executeDescargarOrdenCompra(sfWebRequest $request)
  {
    $hash = $request->getParameter('hash');
    
    $campanaMarca = campanaMarcaTable::getInstance()->findOneByHash( $hash );
    
    if ( $campanaMarca )
    {     
      $campana = $campanaMarca->getCampana();
      ordenCompraHelper::getInstance()->makeOrdenCompra(null, null, null, $campanaMarca->getIdMarca(), true, $campana->getIdCampana());
      exit;
    }
    
    $this->setTemplate('hashInexistente');
  }
  
  public function executeIngresarFechaEntrega(sfWebRequest $request)
  {
    $hash = $request->getParameter('hash');
        
    $campanaMarca = campanaMarcaTable::getInstance()->findOneByHash( $hash );
    
    // Si el hash es invalido muestra cartel de seguridad
    if ( !$campanaMarca )
    {
      $this->setTemplate('hashInexistente');
      return;
    }

    $fechaEntrega = false;
    $form = new ingresarFechaEntregaCampanaForm();
    
    if( $request->isMethod('post') )
    {
    	$form->bind( $request->getParameter( $form->getName() ) );
    	  		
    	if ( $form->isValid() )
    	{
    		$fechaEntrega = $form->save($campanaMarca);
    	}
    }
    
    $this->form = $form;
    $this->campanaMarca = $campanaMarca;
    $this->marca = $campanaMarca->getMarca();
    $this->campana = $campanaMarca->getCampana();
    $this->ok = (bool) $fechaEntrega;    
    $this->fechaEntrega = $fechaEntrega;
    $this->hash = $hash;
  }
  
  public function executeRecordatorio(sfWebRequest $request)
  {
      $idCampana = $request->getParameter('idCampana');
      $idMarca = $request->getParameter('idMarca');
      $activar = $request->getParameter('activar');
      
      $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($idCampana, $idMarca);
      
      $campanaMarca->setEnviarAvisoOrdenCompra( $activar );
      $campanaMarca->save();
      
      $this->redirect('campanas_logistica');
  }
  
  public function executeMarcarPagada(sfWebRequest $request)
  {
      $idCampana = $request->getParameter('idCampana');
      $idMarca = $request->getParameter('idMarca');
  
      $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($idCampana, $idMarca);
  
      $campanaMarca->setPagada(true);
      $campanaMarca->save();
  
      $this->redirect('campanas_logistica');
  }
  
  public function executeMarcarNoPagada(sfWebRequest $request)
  {
      $idCampana = $request->getParameter('idCampana');
      $idMarca = $request->getParameter('idMarca');
  
      $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($idCampana, $idMarca);
  
      $campanaMarca->setPagada(false);
      $campanaMarca->save();
  
      $this->redirect('campanas_logistica');
  }
  
  public function executeComentarios(sfWebRequest $request)
  {
      $idCampana = $request->getParameter('idCampana');
      $idMarca = $request->getParameter('idMarca');
      $activar = $request->getParameter('activar');
  
      $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($idCampana, $idMarca);
      
      $form = new comentarioInternoForm();
      $form->setDefault('comentario', $campanaMarca->getComentarioInterno() );
      
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter( $form->getName() ) );
      
          if ( $form->isValid() )
          {
              $campanaMarca = $form->save($campanaMarca);
              $this->redirect('campanas_logistica');
          }
      }

      $this->form = $form;
      $this->campanaMarca = $campanaMarca;
  }
  
  public function executeLogistica(sfWebRequest $request)
  {
      $filters = $this->getFilters();
      
      if ( !isset( $filters['estado'] ) || !$filters['estado'] ) {
        $filters['estado'] = 'FINALIZADA';
        $this->setFilters( $filters );
      }     


      // sorting
      if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
      {
          $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
      }
  
      // pager
      if ($request->getParameter('page'))
      {
          $this->setPage($request->getParameter('page'));
      }
  
      $this->pager = $this->getPager();
      $this->sort = $this->getSort();
  }
  
  public function executeFilter(sfWebRequest $request)
  {
      $this->setPage(1);
  
      $logistica = $request->hasParameter('logistica', false);
      $redirect = ( $logistica ) ? '@campanas_logistica' : '@campana'; 
      
      if ($request->hasParameter('_reset'))
      {
          $this->setFilters($this->configuration->getFilterDefaults());
  
          $this->redirect($redirect);
      }
  
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
  
      $this->filters->bind($request->getParameter($this->filters->getName()));
      if ($this->filters->isValid())
      {
          $this->setFilters($this->filters->getValues());
  
          $this->redirect($redirect);
      }
  
      $this->pager = $this->getPager();
      $this->sort = $this->getSort();
  
      $this->setTemplate('index');
  }

  protected function executeBatchTieneEnvioGratis(sfWebRequest $request)
  {
  	$ids = $request->getParameter('ids');
  	foreach ($ids as $idCampana)
  	{
  		$campana = campanaTable::getInstance()->getById($idCampana);
  		$campana->setTieneEnvioGratis(true);
  		$campana->save();
  	}
  	
  	$this->getUser()->setFlash('notice', 'Se seteo el envío gratis en las campañas seleccionadas');
  	
  }
  
  protected function executeBatchNoTieneEnvioGratis(sfWebRequest $request)
  {
  	$ids = $request->getParameter('ids');
  	foreach ($ids as $idCampana)
  	{
  		$campana = campanaTable::getInstance()->getById($idCampana);
  		$campana->setTieneEnvioGratis(false);
  		$campana->save();
  	}
  	
  	$this->getUser()->setFlash('notice', 'Se quito el envío gratis en las campañas seleccionadas');
  }
  
  public function executeAsignacionCSV(sfWebRequest $request)
  {
      $idCampana = $request->getParameter('idCampana');
      $campana = campanaTable::getInstance()->getById( $idCampana );
      
      $form = new campanaAsignacionCSVForm();
      
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter('campanaAsignacionCSV'), $request->getFiles('campanaAsignacionCSV') );
      
          if ( $form->isValid() )
          {
              $ok = $form->process($idCampana);
              
              if ( $ok ) {
                  $this->redirect('notificacion_backend_start');
              }
          }
      }
      
      $this->form = $form;
      $this->campana = $campana;
  }
  
  public function executeLogisticaDescargarExcel(sfWebRequest $request)
  {
      set_time_limit(0);
            
      $filters = $this->getFilters();
      
      $filtroPagada = $filters['pagada'];
      
      $campanas = $this->buildQuery()->execute();
        
      $headerCellStyle = array(
              'font' => array('bold' => true),
              'borders' => array(
                      'allborders' => array(
                              'style' => PHPExcel_Style_Border::BORDER_THIN,
                              'color' => array('argb' => '000000'))));
  
      $phpExcel = new PHPExcel();
  
      $phpExcel->getProperties()->setCreator("DeluxeBuys");
      $activeSheet = $phpExcel->setActiveSheetIndex(0);
  
      $activeSheet->setCellValue('A1', 'Deluxebuys - Logística');
      $activeSheet->mergeCells('A1:D1');
      $activeSheet->mergeCells('A2:D2');
        
      $activeSheet->setCellValue('A3', 'Id');
      $activeSheet->getStyle('A3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('A')->setAutosize(true);
      $activeSheet->getColumnDimension('A')->setWidth(7);
      
      $activeSheet->setCellValue('B3', 'Campaña');
      $activeSheet->getStyle('B3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('B')->setAutosize(true);
      $activeSheet->getColumnDimension('B')->setWidth(40);

      $activeSheet->setCellValue('C3', 'Fch. Inicio');
      $activeSheet->getStyle('C3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('C')->setAutosize(true);
      $activeSheet->getColumnDimension('C')->setWidth(12);

      $activeSheet->setCellValue('D3', 'Fch. Fin');
      $activeSheet->getStyle('D3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('D')->setAutosize(true);
      $activeSheet->getColumnDimension('D')->setWidth(12);
            
      $activeSheet->setCellValue('E3', 'Dias desde fin');
      $activeSheet->getStyle('E3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('E')->setAutosize(true);
      $activeSheet->getColumnDimension('E')->setWidth(15);
      
      $activeSheet->setCellValue('F3', 'Marca');
      $activeSheet->getStyle('F3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('F')->setAutosize(true);
      $activeSheet->getColumnDimension('F')->setWidth(20);
      
      $activeSheet->setCellValue('G3', 'E-Mail');
      $activeSheet->getStyle('G3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('G')->setAutosize(true);
      $activeSheet->getColumnDimension('G')->setWidth(30);

      $activeSheet->setCellValue('H3', 'Teléfono');
      $activeSheet->getStyle('H3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('H')->setAutosize(true);
      $activeSheet->getColumnDimension('H')->setWidth(15);      
      
      $activeSheet->setCellValue('I3', 'Uni. Ven.');
      $activeSheet->getStyle('I3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('I')->setAutosize(true);
      $activeSheet->getColumnDimension('I')->setWidth(10);

      $activeSheet->setCellValue('J3', 'Mon. Fin. c/IVA');
      $activeSheet->getStyle('J3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('J')->setAutosize(true);
      $activeSheet->getColumnDimension('J')->setWidth(15);
      
      $activeSheet->setCellValue('K3', 'Cant. Ped.');
      $activeSheet->getStyle('K3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('K')->setAutosize(true);
      $activeSheet->getColumnDimension('K')->setWidth(10);
      
      $activeSheet->setCellValue('L3', 'Mail Env.');
      $activeSheet->getStyle('L3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('L')->setAutosize(true);
      $activeSheet->getColumnDimension('L')->setWidth(15);
      
      $activeSheet->setCellValue('M3', 'Fch. Est. Ent.');
      $activeSheet->getStyle('M3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('M')->setAutosize(true);
      $activeSheet->getColumnDimension('M')->setWidth(20);
      
      $activeSheet->setCellValue('N3', 'Pagada');
      $activeSheet->getStyle('N3')->applyFromArray($headerCellStyle);
      $activeSheet->getColumnDimensionByColumn('N')->setAutosize(true);
      $activeSheet->getColumnDimension('N')->setWidth(10);
      
      $i = 4;
      foreach ($campanas as $campana)
      {
          $campanaMarcas = $campana->getCampanaMarca();
          
          foreach( $campanaMarcas as $campanaMarca ) 
          {              
              if ( $filtroPagada !== null && $campanaMarca->getPagada() != $filtroPagada ) { continue; }       
          
              $dataCantidades = $campanaMarca->getCantidades();
              $diasFin = (int) ( ( time() - strtotime( $campana->getFechaFin() ) ) / 86400  );
              $marca = $campanaMarca->getMarca();
                          
              
              $activeSheet->setCellValue('A' . $i, $campana->getIdCampana() );
              $activeSheet->setCellValue('B' . $i, $campana->getDenominacion() );
              $activeSheet->setCellValue('C' . $i, date('d/m/Y', strtotime($campana->getFechaInicio())) );
              $activeSheet->setCellValue('D' . $i, date('d/m/Y', strtotime($campana->getFechaFin())) );
              $activeSheet->setCellValue('E' . $i, $diasFin );
              $activeSheet->setCellValue('F' . $i, $marca->getNombre() );
              $activeSheet->setCellValue('G' . $i, $campanaMarca->getEmailOrdenCompra() );
              $activeSheet->setCellValue('H' . $i, ( $campanaMarca->getTelefonoOrdenCompra() ) ? $campanaMarca->getTelefonoOrdenCompra() : '-' );
              $activeSheet->setCellValue('I' . $i, $dataCantidades['unidades'] );              
              $activeSheet->setCellValue('J' . $i, formatHelper::getInstance()->decimalNumber( $dataCantidades['costo_total'] ) );
              $activeSheet->setCellValue('K' . $i, $dataCantidades['cantidad_pedidos'] );
              $activeSheet->setCellValue('L' . $i, ( $campanaMarca->getUltimoEnvio() ) ? 'Si' : 'No' );
              
              if ( $campanaMarca->getFechaEstimadaEntrega() ) {
                  $activeSheet->setCellValue('M' . $i, date('d/m/Y', strtotime($campanaMarca->getFechaEstimadaEntrega())) );
              } else {
                  $activeSheet->setCellValue('M' . $i, '-' );
              }
                            
              $activeSheet->setCellValue('N' . $i, ( $campanaMarca->getPagada() ) ? 'Si' : 'No' );
              $i++;
          }
      }
  
  
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="logistica.xls"');
      header('Cache-Control: max-age=0');
  
      $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
      $writer->save('php://output');
  
      exit;
       
  }

  public function executeRecepcionMercaderia(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $idMarca = $request->getParameter('idMarca');

    $campana = campanaTable::getInstance()->getById( $idCampana );
    $marca = marcaTable::getInstance()->getOneById( $idMarca );

    $usaStockRefuerzo = campanaTable::getInstance()->vendioStockRefuerzo( $idCampana, $idMarca );

    $productos = ordenCompraHelper::getInstance()->makeOrdenCompra($campana->getFechaInicio(), $campana->getFechaFin(), null, $idMarca, false, $idCampana);
    $faltantes = productoItemTable::getInstance()->getCantidadFaltantesByIdCampana($idCampana, $idMarca);



    $aux = $productos;
    $productos = array();
    foreach ($aux as $producto) {

      if ( !isset( $productos[ $producto['id_producto_item'] ] ) ) {
        $productos[ $producto['id_producto_item'] ] = $producto;
      } else {
        $productos[ $producto['id_producto_item'] ]['cantidad']    += $producto['cantidad'];
        $productos[ $producto['id_producto_item'] ]['costo']       .= ' / ' . $producto['costo'];
        $productos[ $producto['id_producto_item'] ]['costoSinIva'] .= ' / ' . $producto['costoSinIva'];
      }
    }


    $idsProductoItem = array();
    foreach ($productos as $producto) {
      $idsProductoItem[] = $producto['id_producto_item'];
    }

    $recepcion = recepcionMercaderiaCampanaTable::getInstance()->getResumen($idCampana, $idsProductoItem);

    $form = new recepcionMercaderiaForm(
                    array(),
                    array(
                      'campana' => $campana,
                      'marca' => $marca,
                      'productos' => $productos,
                      'recepcion' => $recepcion,
                      'faltantes' => $faltantes,
                      
                    ) );

    if( $request->isMethod('post') )
    {
      $form->bind( $request->getParameter('recepcionMercaderia') );
      
      if ( $form->isValid() )
      {
        $faltantes = $form->execute();

        $idsPedido = recepcionMercaderiaCampanaTable::getInstance()->getIdsPedidosEnviables( $idCampana );

        if ( count( $faltantes ) ) {
          $params = array( 'tipo' => 'CAMPANA', 'idCampana' => $idCampana, 'idMarca' => $idMarca, 'faltantes' => implode(',', $faltantes) ); 
          $url = $this->getController()->genUrl( array( 'sf_route' => 'faltantes_generacionAutomatica') );          
          $this->redirect( $url . '?' . http_build_query($params) );
        } else if( count( $idsPedido ) ) {
          $params = array( 'ids' => implode(',', $idsPedido), 'idMarca' => $idMarca ); 
          $url = $this->getController()->genUrl( array( 'sf_route' => 'pedido_preparar_envio') );          
          $this->redirect( $url . '?' . http_build_query($params) );
        } else {
          $this->redirect( 'campanas_recepcionMercaderia_no_envios', array( 'idCampana' => $idCampana ) );
        }
      }
    }

    $this->campana = $campana;
    $this->faltantes = $faltantes;
    $this->marca = $marca;
    $this->productos = $productos;
    $this->recepcion = $recepcion;
    $this->usaStockRefuerzo = $usaStockRefuerzo;
    $this->form = $form;
  }

  public function executeNoHayEnviosDisponibles(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $this->campana = campanaTable::getInstance()->getById( $idCampana );
  }

  public function executePrepararHojaDeRuta(sfWebRequest $request)
  {
    set_time_limit(0);

    $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();

    $client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );

    $task = new Net_Gearman_Task ('HojaDeRutaWorker', array ('idUsuario' => $idUsuario) );
    $task->type = Net_Gearman_Task::JOB_BACKGROUND;

    $set = new Net_Gearman_Set();
    $set->addTask ($task);

    $client->runSet ($set);

    $this->redirect('notificacion_backend_start');
    exit;
  }

  public function executePedidosNoEnviados(sfWebRequest $request)
  {
    $idCampana = $request->getParameter('idCampana');
    $campana = campanaTable::getInstance()->getById( $idCampana );

    $idMarca = $request->getParameter('idMarca');
    $marca = marcaTable::getInstance()->getOneById( $idMarca );

    $pedidos = pedidoTable::getInstance()->listPendientesEnvio( $idCampana, $idMarca );

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=pedidos_no_enviados_" . $campana->getSlug() .  "_" . $marca->getSlug() . ".csv");

    foreach ($pedidos as $pedido) {

      $output = fopen('php://output', 'w');
      $row = array("Id Pedido", "Nombre", "Apellido", "Email");
      foreach ($pedidos as $pedido)
      {     
        $usuario = $pedido->getUsuario();
        $row = array($pedido->getIdPedido(), $usuario->getNombre(), $usuario->getApellido(), $usuario->getEmail() );
        fputcsv($output, $row);
      }
    }

    return sfView::NONE;
  }
  
}
