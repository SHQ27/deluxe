<?php

/**
 * ajax actions.
 *
 * @package    deluxebuys
 * @subpackage ajax
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajaxActions extends sfActions
{

  public function executeAutocompleteUsuarios(sfWebRequest $request)
  {  	
  	$term = $request->getParameter('term');
  	
  	$usuario = usuarioTable::getInstance()->searchByEmail( $term );
  	
  	$results = array();
  	foreach ($usuario as $usuario)
  	{
  		$row['id'] = $usuario->getEmail();
  		$row['value'] = $usuario->getEmail();
  		$row['label'] = $usuario->getEmail();
  		$results[] = $row;
  	}
  	
  	echo json_encode($results);  	
  	exit;
  }
  
  
  public function executeAllTags(sfWebRequest $request)
  {  	
  	$term = $request->getParameter('term');
  	
  	$tags = tagTable::getInstance()->startWith($term);
  	
  	$results = array();
  	foreach ($tags as $tag)
  	{
  		$row['id'] = $tag->getDenominacion();
  		$row['value'] = $tag->getDenominacion();
  		$row['label'] = $tag->getDenominacion();
  		$results[] = $row;
  	}
  	
  	echo json_encode($results);  	
  	exit;
  }
  
  public function executeGetProductosByFilters(sfWebRequest $request)
  {  	
    set_time_limit(0);

  	$idMarca = $request->getParameter('idMarca');
  	$idCampana = $request->getParameter('idCampana');
  	$activo = $request->getParameter('activo');
  	$idProductoCategoria = $request->getParameter('idProductoCategoria');
    $idEshop = $request->getParameter('idEshop');
  	  	
  	$productos = productoTable::getInstance()->listForProductAssign( $idMarca, $idCampana, $activo, $idProductoCategoria, $idEshop );
  	
  	$results = array();
  	foreach ($productos as $producto)
  	{
  		

  		$row['idProducto'] = $producto->getIdProducto();
      $row['codigos'] = implode('<br />', $producto->getCodigos());
  		$row['denominacion'] = $producto->getDenominacion();
  		$row['marca'] = $producto->getMarca()->getNombre();
      $row['eshop'] = (string) $producto->getEshop();
  		
  		$productoCategoria = $producto->getProductoCategoria();
  		$productoGenero = $producto->getProductoCategoria()->getProductoGenero();
  		
  		$row['categoria'] = $productoGenero->getDenominacion() . ' - ' . $productoCategoria->getDenominacion();
  		
  		$row['diversidad'] = $producto->getDiversidad();
  		$row['activo'] = ( $producto->getActivo() )? '<img src="/backend/sfDoctrinePlugin/images/tick.png" title="Checked" alt="Checked">' : '';
  		
  		$row['stockPermanente'] = $producto->getStockPermanente();
  		$row['stockCampana'] = $producto->getStockCampana();
  		$row['stockOutlet'] = $producto->getStockOutlet();
  		
  		$row['sticker'] = false;
  		if ( $producto->getIdProductoSticker() )
  		{
  			$row['sticker'] = '<img class="sticker" src="' . imageHelper::getInstance()->getUrl('producto_sticker_chico', $producto->getProductoSticker() ) . '"/>';
  		}  		
  		
  		
  		$row['imagen'] = '<img src="' . imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) . '"/>';
  		
  		$row['precio_lista'] = ( $producto->getPrecioLista() )? $producto->getPrecioLista() : 0;
  		$row['precio_deluxe'] = ( $producto->getPrecioDeluxe() )? $producto->getPrecioDeluxe() : 0;
  		$row['costo'] = ( $producto->getCosto() )? $producto->getCosto() : 0;
  		$row['esOutlet'] = ( $producto->getEsOutlet() )? 1 : 0;
  		
  		$row['es_oferta'] = ( $producto->esOferta() )? 1 : 0;
  		
  		$results[] = $row;
  	}
  	
  	echo json_encode($results);
  	exit;
  }
  
  public function executeGetInfoPedido(sfWebRequest $request)
  {
  	$idPedido = $request->getParameter('idPedido');
  	$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  	  	
  	$response = array();
  	
  	if ($pedido)
  	{
	  	foreach($pedido->getPedidoProductoItem() as $pedidoProductoItem) {
	  	  	$producto = $pedidoProductoItem->getProductoItem()->getProducto();
	  	  	
	  	  	$response[] = array (
	  	  		'idProductoItem' => $pedidoProductoItem->getIdProductoItem(),
	  	  		'imagen' => imageHelper::getInstance()->getUrl('producto_lista_chica', $producto),
	  	  		'denominacion' => $producto->getDenominacion(),
	  	  		'marca' => $producto->getMarca()->getNombre(),
	  	  		'talle' => $pedidoProductoItem->getProductoTalle()->getDenominacion(),
	  	  		'color' => $pedidoProductoItem->getProductoColor()->getDenominacion(),
	  	  		'cantidad' => $pedidoProductoItem->getCantidad(),
	  	  		'esOutlet' => $producto->getEsOutlet(),
	  	  		'idProducto' => $producto->getIdProducto(),
	  	  		'activo' => $producto->getActivo()
			);
	  	}
	  	
	  	echo json_encode($response);
  	}
  	exit;
  }
  
  public function executeListTalleGetByMarca(sfWebRequest $request)
  {
      $idMarca = $request->getParameter('idMarca');
      $talleSets = talleSetTable::getInstance()->listByIdMarca($idMarca );
      $choices = array();
      foreach( $talleSets as $talleSet ) $choices[] = array('id' => $talleSet->getIdTalleSet(), 'denominacion' => $talleSet->getDenominacion());
        
      echo json_encode($choices);
      exit;
  }
  
  
  
  public function executeGetProductoItemsByIdMarca(sfWebRequest $request)
  {
      $idMarca = $request->getParameter('idMarca');  
      
      $productoItems = productoItemTable::getInstance()->listByIdMarca( $idMarca );
  
      $results = array();
      foreach ($productoItems as $productoItem)
      {
          $producto = $productoItem->getProducto();
          
          $row['id_producto_item'] = $productoItem->getIdProductoItem();
          $row['imagen_url']       = imageHelper::getInstance()->getUrl('producto_lista_chica', $producto);
          $row['producto']         = $producto->getDenominacion();
          $row['marca']            = $producto->getMarca()->getNombre();
          $row['talle']            = $productoItem->getProductoTalle()->getDenominacion();
          $row['color']            = $productoItem->getProductoColor()->getDenominacion();
          $row['stockCampana']     = $productoItem->getStockCampana();
          $row['stockPermanente']  = $productoItem->getStockPermanente();
          $row['stockOutlet']      = $productoItem->getStockOutlet();          
          $results[] = $row;
      }
  
      echo json_encode($results);
      exit;
  }
  
  
  public function executeListLocalidadesByIdProvincia(sfWebRequest $request)
  {
      $idProvincia = $request->getParameter('idProvincia');

      $localidades = localidadTable::getInstance()->listByIdProvincia($idProvincia);
  
      $results = array();
      foreach( $localidades as $localidad )
      {
          $results[] = array('idLocalidad' => $localidad->getIdLocalidad(), 'denominacion' => $localidad->getDenominacion()) ;
      }
  
      echo json_encode($results);
      exit;
  }
  
    
  public function executeGetCampanasByIdMarca(sfWebRequest $request)
  {
      $idMarca = $request->getParameter('idMarca');
  
      $campanas = campanaTable::getInstance()->getByIdMarca($idMarca);
  
      $results = array();
      foreach ($campanas as $campana)
      {
  		  $desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
  		  $hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
  		  
  		  $row = array();
  		  $row['value'] = $campana->getIdCampana();
  		  $row['denominacion'] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
  		  
          $results[] = $row;  
      }
      echo json_encode($results);
      exit;
  }
  
  
  public function executeGetMarcasByIdCampana(sfWebRequest $request)
  {
      $idCampana = $request->getParameter('idCampana');
  
      if ( $idCampana ) {
        $marcas = marcaTable::getInstance()->listByIdCampana($idCampana);  
      } else {
        $marcas = marcaTable::getInstance()->listAll();
      }
      
  
      $results = array();
      foreach ($marcas as $marca)
      {  
          $row = array();
          $row['id'] = $marca->getIdMarca();
          $row['nombre'] = $marca->getNombre();
          $results[] = $row;
      }
      
      echo json_encode($results);
      exit;
  }
  
  public function executeGetDataOCByIdMarca(sfWebRequest $request)
  {
      $idMarca = $request->getParameter('idMarca');
      $idCampana = $request->getParameter('idCampana');
      
      $emails = false;
      $telefono = false;
      
      if ( $idCampana )
      {
          $campanaMarca = campanaMarcaTable::getInstance()->getByCompoundKey($idCampana, $idMarca);
          
          $emails = ( $campanaMarca ) ? $campanaMarca->getEmailOrdenCompra() : null;
          $telefono = ( $campanaMarca ) ? $campanaMarca->getTelefonoOrdenCompra() : null;
      }
      
      if (!$emails)
      {
          $emails = campanaMarcaTable::getInstance()->getEmailsOC($idMarca);
          $emails = ( $emails ) ? $emails : '';
      }
      
      if (!$telefono)
      {
          $telefono = campanaMarcaTable::getInstance()->getTelefonoOC($idMarca);
          $telefono = ( $telefono ) ? $telefono : '';
      }
      
      echo json_encode( array('emails' => $emails, 'telefono' => $telefono)  );
      exit;
  }
  
  public function executeDeleteImagenBannerPrincipal(sfWebRequest $request)
  {
      $idImagenBannerPrincipal = $request->getParameter('idImagenBannerPrincipal');
      
      $imagen = imagenBannerPrincipalTable::getInstance()->findOneByIdImagenBannerPrincipal( $idImagenBannerPrincipal );
      $imagen->delete();
      
      exit;
  }

  public function executeDeleteEshopHomeMultimedia(sfWebRequest $request)
  {
      $idEshopHomeMultimedia = $request->getParameter('idEshopHomeMultimedia');
      
      $eshopHomeMultimedia = eshopHomeMultimediaTable::getInstance()->findOneByIdEshopHomeMultimedia( $idEshopHomeMultimedia );
      $eshopHomeMultimedia->delete();
      
      exit;
  }
  
  
  public function executeGetCategoriasML(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
            
      $categoriasML = categoriaMlTable::getInstance()->findByIdCategoriaMlPadre( $id );
            
      $data = array();
      
      foreach( $categoriasML as $categoriaML )
      {   
          $row = array();
          $row['data'] = $categoriaML->getDenominacion();
          $row['attr'] = array('id' => $categoriaML->getIdCategoriaMl(), 'rel' => $categoriaML->getIdExterno(), 'tiene_hijos' => $categoriaML->getIdExterno() );
          
          if ( $categoriaML->getTieneHijos() )
          {
              $row['state'] = 'closed';
          }
          
          $data[] = $row;
      }
      
      echo json_encode($data);
      
      exit;
  }
  
  public function executeHasProducsAsignedWith(sfWebRequest $request)
  {
      $idMarca = $request->getParameter('idMarca');
      $idCampana = $request->getParameter('idCampana');
      
      $exists = productoCampanaTable::getInstance()->existByMarca($idCampana, $idMarca);
    
      echo json_encode(array('exists' => $exists));  
      exit;
  }
  
  public function executeListCategoriasByIdCampana(sfWebRequest $request)
  {
      $idsCampana = $request->getParameter('idsCampana');
      $idsCampana = explode(',', $idsCampana);
            
      if ( !in_array( '', $idsCampana) && !in_array( 'STKPER', $idsCampana ) )
      {
          $productoCategorias = productoCategoriaTable::getInstance()->listByIdsCampana( $idsCampana );
      }
      else
      {
          $productoCategorias = productoCategoriaTable::getInstance()->listAll();
      }
      
      $choices = array();
      $choices[] = array('value' => '', 'name' => 'Todas');
      foreach ($productoCategorias as $productoCategoria)
      {
          $nombreCategoriaGenero = $productoCategoria->getProductoGenero()->getDenominacion();
          
          $choices[] = array(
                            'value' => $productoCategoria->getIdProductoCategoria(),
                            'name' => $nombreCategoriaGenero . ' :: ' . $productoCategoria->getDenominacion()
                       );
          
          
      }
      
      echo json_encode($choices);
      exit;
  }
  
  public function executeGetEshopByIdMarca(sfWebRequest $request)
  {
      $idMarca = $request->getParameter('idMarca');
  
      $eshop = eshopTable::getInstance()->getIdMarca( $idMarca );
      
      if ( $eshop ) {
          return $this->renderText( json_encode( array('value' => $eshop->getIdEshop(), 'name' => $eshop->getDenominacion()) ) );
      } else {
          return $this->renderText( 'false' );
      }
      
  }
  
  public function executeUpdateProductoItem(sfWebRequest $request)
  {
      $results = array('show' => false);
      
      $idProductoItem = $request->getParameter('idProductoItem');
      $idProductoTalle = $request->getParameter('idProductoTalle', false);
      $idProductoColor = $request->getParameter('idProductoColor', false);
       
      $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );

      $doSave = false;
      if ( $idProductoTalle ) {
          $productoItem->setIdProductoTalle( $idProductoTalle );
          $doSave = true;
      }
      
      if ( $idProductoColor ) {
          $productoItem->setIdProductoColor( $idProductoColor );
          $doSave = true;
      }      
      
      if ( $doSave ) {
          $productoItem->save();
          $results['show'] = true;
      }
       
      return $this->renderText( json_encode($results) );
  }
  
  public function executeDeleteProductoItem(sfWebRequest $request)
  {
      $results = array('ok' => true);
  
      $idProductoItem = $request->getParameter('idProductoItem');

      $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );
      $productoItem->delete();
      
      return $this->renderText( json_encode($results) );
  }
  

  public function executeGetDataProductoItem(sfWebRequest $request)
  {
      $idProducto = $request->getParameter('idProducto');
  
      $items = array();
      $productoItems = productoItemTable::getInstance()->listByIdProductoOrdenado( $idProducto );
  
      foreach($productoItems as $productoItem)
      {
          $talle = $productoItem->getProductoTalle();
          $color = $productoItem->getProductoColor();

          $items[$talle->getIdProductoTalle()]['idProductoTalle'] = $talle->getIdProductoTalle();
          $items[$talle->getIdProductoTalle()]['denominacion']    = $talle->getDenominacion();
          $items[$talle->getIdProductoTalle()]['childs'][$color->getIdProductoColor()]['idProductoColor'] = $color->getIdProductoColor();
          $items[$talle->getIdProductoTalle()]['childs'][$color->getIdProductoColor()]['denominacion']    = $color->getDenominacion();
      }
  
      return $this->renderText( json_encode($items) );      
  }
  
  
}
