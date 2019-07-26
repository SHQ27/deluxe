<?php

/**
 * producto form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoForm extends BaseproductoForm
{
  protected $message;
  protected $itemsDefaults = array();  
	
  public function getJavaScripts()
  {
  	return array( 'preventDoubleSubmit.js', 'formProducto.js' );
  }	
	
  public function configure()
  {
  	$producto = $this->getObject();
  	
  	// Marca
  	$this->setWidget( 'id_marca', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'order_by' => array('nombre', 'asc'), 'add_empty' => false) ) );
  	
  	// Categoria ML
  	$this->setWidget( 'id_categoria_ml', new sfWidgetFormInputHidden());
  	
	// Imagenes
    $this->setWidget( 'imagenes', new sfWidgetFormInputFile( array(), array( 'multiple' => 'multiple', 'name' => 'imagenes[]' ) ) );
    $this->setValidator( 'imagenes', new sfValidatorPass() );
  	
    // Se cambian los campos de descripcion por texto enriquecido
    $this->setWidget( "descripcion", new sfWidgetFormTextareaTinyMCE(array( 'width'   => 800, 'height'  => 300 )));
    $this->setWidget( "info_adicional", new sfWidgetFormTextareaTinyMCE(array( 'width'   => 800, 'height'  => 300 )));
    
  	// Se oculta la fecha de modificacion
  	$this->setWidget('fecha_modificacion', new sfWidgetFormInputHidden());
  	
  	// Se modifica el widget para la eleccion de la categoria del producto
  	$choices = array();
  	$categorias = productoCategoriaTable::getInstance()->listAll();
  	foreach ($categorias as $categoria)
  	{
  		$nombreCategoriaGenero = $categoria->getProductoGenero()->getDenominacion();
  		$idProductoCategoria = $categoria->getIdProductoCategoria(); 
  		$choices[$nombreCategoriaGenero][$idProductoCategoria] = $categoria->getDenominacion();
  	}
  	
  	$this->setWidget( 'id_producto_categoria', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );

  	// Se agrega la logica para items de producto
  	$this->setWidget( 'stock', new pmWidgetProductoItem() );  		
  	$this->setValidator( 'stock', new pmValidatorProductoItem() );
  	$this->getWidget('stock')->setDefault( $this->getItemsDefaults() );
  	
  	// Se agrega la logica de tags
    $this->setWidget( 'tags', new sfWidgetFormInputText() );
    $this->setValidator( 'tags', new sfValidatorString(array('max_length' => 100, 'required' => false)) );
    
    $tags = productoTagTable::getInstance()->tagsByIdProducto( $producto->getIdProducto() );
    $tags = tagTable::getInstance()->toString( $tags );
    $this->getWidget('tags')->setDefault( $tags );
    
    // Se agrega la logica de destacado
    $this->setWidget('destacar', new sfWidgetFormSelect( array('choices' => array(0 => 'Sin Destacar', 4 => 'Home de eShop', 3 => 'Ubicar arriba', 2 => 'Ubicar al medio', 1 => 'Ubicar abajo') ) ));
    
    // Se cargan los campos por default para cuando es un producto nuevo
    if ( $this->isNew() )
    {
    	
    	$lastId = productoTable::getInstance()->nextId();
    	    	
    	$this->getWidget( 'denominacion')->setDefault( 'Articulo ' . $lastId );
    	$this->getWidget( 'descripcion')->setDefault
    	(
    		'
					<ul>
						<li><strong>Los cambios se realizan dentro de los 5 días de recibido el producto por intermedio de Deluxe Buys.</strong></li>
						<li>Producto</li>
						<li>Color</li>
						<li>Composición:</li>
						<li>Mangas</li>
						<li>Cuello</li>
						<li>Bolsillos</li>
						<li>Detalle</li>
						<li>La modelo lleva</li>
					</ul>
					<p>
						<strong>Sobre la marca: </strong>
					</p>
					<p>
						Texto aquí
					</p>
			'
    	);
    	
    	$this->getWidget( 'info_adicional')->setDefault( $producto->getDefaultInfoAdicional() );
    		
    	$this->getWidget('precio_lista')->setDefault('1000');
    	$this->getWidget('precio_deluxe')->setDefault('1000');
    	$this->getWidget('peso')->setDefault(0.5);
    	$this->getWidget('activo')->setDefault(false);
    }
    
    // Se agrega la logica de TalleSet
    $talleSets = talleSetTable::getInstance()->listByIdMarca($producto->getIdMarca() );
    $choices = array(''=>'');
    foreach( $talleSets as $talleSet ) $choices[$talleSet->getIdTalleSet()] = $talleSet->getDenominacion(); 
    $this->setWidget( 'id_talle_set', new sfWidgetFormSelect( array('choices' => $choices) ) );
    $this->setValidator( 'id_talle_set', new sfValidatorPass() );

    // Widget para eshop
    $this->setWidget( 'id_eshop', new sfWidgetFormInput() );
    
    // Post Validator
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback( array( 'callback' => array($this, 'postValidator')) )
    );
        
}
    
public function postValidator($sfValidatorCallback, $values, $arguments)
{        
    if ( $values['es_outlet'] && $values['precio_outlet'] <= 0 )
	{    		
		throw new sfValidatorError($this->getValidator('precio_outlet'), 'Si se habilita el outlet el precio de outlet no puede ser menor o igual a cero.');
	}
	
	if ( !$values['es_outlet'] && $values['precio_normal'] <= 0 )
	{
	    throw new sfValidatorError($this->getValidator('precio_normal'), 'Si el producto no esta en outlet el precio normal no puede ser menor o igual a cero.');
	}
	
	return $values;
}
  
  protected function doSave($con = null)
  {	  	
    $clone = $this->getOption('clone');
          
    // Obtengo la fecha actual
  	$now = new DateTime();
  	$now = $now->format(DATE_ISO8601);
    
  	// Guardo el producto
  	$this->updateObject();
  	
    $producto = $this->getObject();
    
    if ( $clone )
    {
        $idProductoOriginal = $producto->getIdProducto();
        
        $data = $producto->getData();
        unset($data['id_producto']);
        $producto = new producto();
        $producto->setArray($data);
    }
    
    $producto->setFechaModificacion( $now );
    $producto->setEsOutlet( $this->getValue('es_outlet') );

    if ( !$producto->getIdTalleSet() ) {
      $producto->setIdTalleSet(null);
    }

    $producto->save($con);

    $this->updateObject( $producto->getData() );
    
  	// Guardo las imagenes
    if ($clone)
    {
        $productoImagenes = productoImagenTable::getInstance()->listByIdProducto( $idProductoOriginal );
        foreach ($productoImagenes as $productoImagenOriginal)
        {
            $productoImagen = new productoImagen();
            $productoImagen->setIdProducto( $producto->getIdProducto() );
            
            $ultimoOrden = productoImagenTable::getInstance()->getLast( $producto->getIdProducto() );
            $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() : 0;
            
            $productoImagen->setOrden( $ultimoOrden );
            $productoImagen->save();
            
            imageHelper::getInstance()->copy('producto_lista_chica', $productoImagenOriginal, $productoImagen);
            imageHelper::getInstance()->copy('producto_lista_grande', $productoImagenOriginal, $productoImagen);
            imageHelper::getInstance()->copy('producto_detalle_chica', $productoImagenOriginal, $productoImagen);
            imageHelper::getInstance()->copy('producto_detalle_mediana', $productoImagenOriginal, $productoImagen);
            imageHelper::getInstance()->copy('producto_detalle_grande', $productoImagenOriginal, $productoImagen);        
            imageHelper::getInstance()->copy('producto_thumb', $productoImagenOriginal, $productoImagen);        
        }
        
    }
    else
    {
    	$imagenes = $_FILES['imagenes'];
    	$cantidadImagenes = ( isset($imagenes['tmp_name']) && $imagenes['tmp_name'][0] )? count($imagenes['tmp_name']) : 0;
    	
    	$ultimoOrden = productoImagenTable::getInstance()->getLast( $producto->getIdProducto() );
    	$ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() : 0;
    	  	
    	for ( $i = 0 ; $i < $cantidadImagenes ; $i++ )
    	{
    		$tmpName = $imagenes['tmp_name'][$i];
    	  		
    	  	$productoImagen = new productoImagen();
    	  	$productoImagen->setIdProducto( $producto->getIdProducto() );
    	  		
    	  	$productoImagen->setOrden( $ultimoOrden + $i + 1 );
    	  	$productoImagen->save();
    	  
    		imageHelper::getInstance()->processSaveFile('producto_lista_chica', $productoImagen, $tmpName );
    	  imageHelper::getInstance()->processSaveFile('producto_lista_grande', $productoImagen, $tmpName );
    	  imageHelper::getInstance()->processSaveFile('producto_detalle_chica', $productoImagen, $tmpName );
    		imageHelper::getInstance()->processSaveFile('producto_detalle_mediana', $productoImagen, $tmpName );
    		imageHelper::getInstance()->processSaveFile('producto_detalle_grande', $productoImagen, $tmpName );
        imageHelper::getInstance()->processSaveFile('producto_thumb', $productoImagen, $tmpName );
    	  	
    	}
    }
    
  	// Guardo los productoItems
  	$itemsExist = array();
  	
  	if (!$clone)
  	{
  	    $existProductoItems = productoItemTable::getInstance()->listByIdProducto( $producto->getIdProducto() );
      	foreach($existProductoItems as $item)
      	{
      		$itemsExist[$item->getIdProductoTalle() . '-' . $item->getIdProductoColor()] = $item;
      	}
  	}
  	
  	$items = $this->getValue('stock');
  	  	
  	$c = count($items['talle']);
  	
  	for( $i = 0 ; $i < $c ; $i++ )
  	{
      $codigo = $items['codigo'][$i];
  		$talle = $items['talle'][$i]['id'];
  		$color = $items['color'][$i]['id'];
  		  		
  		$accion = $items['accion'][$i];
  		$cantidad = $items['cantidad'][$i];
  		$observacion = $items['observacion'][$i];
  		$stockTipo = $items['stock_tipo'][$i];  		
  		
  		$origen = $items['origen'][$i];
  		
  		// Si no tiene talle y color no puedo continuar el ciclo
  		if (!$talle || !$color ) continue;

  		  		
  		// Si ya existia el item lo utilizo
  		if ( isset( $itemsExist[$talle . '-' . $color] ) )
  		{
  			$productoItem = $itemsExist[$talle . '-' . $color];
  			unset( $itemsExist[$talle . '-' . $color] );
  		}
  		// Sino lo creo
  		else
  		{
  			$productoItem = new productoItem();
  			$productoItem->setIdProducto( $producto->getIdProducto() );
  				
  		}
  		  		
      $productoItem->setCodigo( $codigo  );
  		$productoItem->setIdProductoTalle( $talle );
  		$productoItem->setIdProductoColor( $color );
  		$productoItem->save();

  		  		
  		// Si no tiene cantidad no puedo continuar el ciclo
  		if (!$cantidad ) continue;
  		
  		if ($accion == 'SUMAR')
  		{
  			$productoItem->sumaStock($cantidad, $origen, $stockTipo, null, $observacion);
  		}
  		else 
  		{
  			$productoItem->restaStock($cantidad, $origen, $stockTipo, null, $observacion);
  		}
  	}
  	
  	foreach($itemsExist as $item) $item->delete();
  	
    // Guardo los Tags
  	productoTagTable::getInstance()->deleteByIdProducto( $producto->getIdProducto() );
  	productoTagTable::getInstance()->addTagsByIdProducto( $producto->getIdProducto(), $this->getValue('tags') );
  	
  	// Borra caches de producto
  	cacheHelper::getInstance()->deleteByPrefix('productoSticker_listVigentes');
  	cacheHelper::getInstance()->deleteByPrefix('productoCategoria_listByIdProductoGenero');  	
  }
  
  public function setMessage($message)
  {
	$this->message = $message;
  }
  
  public function getMessage()
  {
  	return $this->message;
  }
  
  protected function getItemsDefaults()
  {
      if ( !count($this->itemsDefaults) )
      {
          $producto = $this->getObject();
          $existProductoItems = productoItemTable::getInstance()->listByIdProducto( $producto->getIdProducto() );
           
          $itemsDefault = array();
          $i = 0;
          foreach( $existProductoItems as $item)
          {
            $itemsDefault['codigo'][$i] = $item->getCodigo();
        		$itemsDefault['talle'][$i]['id'] = $item->getIdProductoTalle();
        		$itemsDefault['talle'][$i]['denominacion'] = $item->getProductoTalle()->getDenominacion();
        		$itemsDefault['color'][$i]['id'] = $item->getIdProductoColor();
        		$itemsDefault['color'][$i]['denominacion'] = $item->getProductoColor()->getDenominacion();
      
        		$itemsDefault['stk_carrito'][$i] = carritoProductoItemTable::getInstance()->getCantidadByIdProductoItem( $item->getIdProductoItem() );
        		$itemsDefault['stk_venta'][$i] = $item->getStock();
        		$itemsDefault['stk_no_pagado'][$i] = pedidoProductoItemTable::getInstance()->getCantidadNoPagadosByIdProductoItem( $item->getIdProductoItem() );
        		$itemsDefault['stk_pagado'][$i] = pedidoProductoItemTable::getInstance()->getCantidadPagadosByIdProductoItem( $item->getIdProductoItem() );
        		$itemsDefault['stk_entregado'][$i] = pedidoProductoItemTable::getInstance()->getCantidadEntregadosByIdProductoItem( $item->getIdProductoItem() );
        		$itemsDefault['id_producto_item'][$i] = $item->getIdProductoItem();
        		$itemsDefault['stk_permanente'][$i] = $item->getStockPermanente();
        		$itemsDefault['stk_campana'][$i] = $item->getStockCampana();
        		$itemsDefault['stk_outlet'][$i] = $item->getStockOutlet();
            $itemsDefault['stk_refuerzo'][$i] = $item->getStockRefuerzo();
      
        		$tieneReferenciaPedido = pedidoProductoItemTable::getInstance()->exist( $item->getIdProductoItem() );
        		$tieneReferenciaCarrito = carritoProductoItemTable::getInstance()->exist( $item->getIdProductoItem() );
      
        		$itemsDefault['editable'][$i] = (!$tieneReferenciaPedido &&  !$tieneReferenciaCarrito);
        		$i++;
          }
                    
          $this->itemsDefaults = $itemsDefault;
      }
      
      return $this->itemsDefaults;
  }
  
  public function mergeDefaults($params)
  {
      $itemsDefaults = $this->getItemsDefaults();
      
      $itemsDefaults['codigo'] = $params['codigo'];
      $itemsDefaults['accion'] = $params['accion'];
      $itemsDefaults['origen'] = $params['origen'];
      $itemsDefaults['cantidad'] = $params['cantidad'];
      $itemsDefaults['stock_tipo'] = $params['stock_tipo'];
      $itemsDefaults['observacion'] = $params['observacion'];
      
      $to = count($params['talle']);
      for ( $i = count($itemsDefaults['talle']) ; $i < $to ; $i++ )
      {
          $itemsDefaults['talle'][$i] = array('id' => $params['talle'][$i], 'denominacion' => '');
          $itemsDefaults['color'][$i] = array('id' => $params['color'][$i], 'denominacion' => '');
      }
       
      return $itemsDefaults;
  }
  
}

