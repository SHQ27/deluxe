<?php

class editStockForm extends sfFormSymfony
{		
    protected $itemsDefaults = array();
    
  	public function configure()
  	{  	    
  		$productos = $this->getOption('productos');
  		  		
  		foreach ($productos as $producto)
  		{
	  		// Se agrega la logica para items de producto
	  		$this->setWidget( 'stock_' . $producto->getIdProducto(), new pmWidgetProductoItem( array('batch_edit' => true)) );
	  		$this->setValidator( 'stock_' . $producto->getIdProducto(), new pmValidatorProductoItem() );
  		}
  		
  		$this->setDefaults( $this->getItemsDefaults() );
  		
  		$this->getWidgetSchema()->setNameFormat('editStock[%s]');
  		
	}

	public function save()
	{
		$values = $this->getValues();
		
		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
		$idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
		
		$task = new Net_Gearman_Task ('EditStockWorker', array ('values' => $values, 'idUsuario' => $idUsuario) );
		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
		
		$set = new Net_Gearman_Set();
		$set->addTask ($task);
		
		$client->runSet ($set);
	}
	
	protected function getItemsDefaults()
	{
	    if ( !count($this->itemsDefaults) )
	    {	    
      		$productos = $this->getOption('productos');
      		
      		$productosDefault = array();
      		foreach ($productos as $producto)
      		{
    	  		$existProductoItems = productoItemTable::getInstance()->listByIdProducto( $producto->getIdProducto() );
    	  		
    	  		$producto = productoTable::getInstance()->getById( $producto->getIdProducto() );
    	  		
    	  		$productoItemsDefault = array();
    	  		$i = 0;
    	  		foreach( $existProductoItems as $item)
    	  		{
              $productoItemsDefault['codigo'][$i] = $item->getCodigo();
    	  			$productoItemsDefault['talle'][$i]['id'] = $item->getIdProductoTalle();
    	  			$productoItemsDefault['talle'][$i]['denominacion'] = $item->getProductoTalle()->getDenominacion();
    	  			$productoItemsDefault['color'][$i]['id'] = $item->getIdProductoColor();
    	  			$productoItemsDefault['color'][$i]['denominacion'] = $item->getProductoColor()->getDenominacion();
    	  		
    	  			$productoItemsDefault['stk_carrito'][$i] = carritoProductoItemTable::getInstance()->getCantidadByIdProductoItem( $item->getIdProductoItem() );
    	  			$productoItemsDefault['stk_venta'][$i] = $item->getStock();
    	  			$productoItemsDefault['stk_no_pagado'][$i] = pedidoProductoItemTable::getInstance()->getCantidadNoPagadosByIdProductoItem( $item->getIdProductoItem() );
    	  			$productoItemsDefault['stk_pagado'][$i] = pedidoProductoItemTable::getInstance()->getCantidadPagadosByIdProductoItem( $item->getIdProductoItem() );
    	  			$productoItemsDefault['stk_entregado'][$i] = pedidoProductoItemTable::getInstance()->getCantidadEntregadosByIdProductoItem( $item->getIdProductoItem() );
    
    	  			$productoItemsDefault['id_producto_item'][$i] = $item->getIdProductoItem();
    	  			
    	  			$productoItemsDefault['stk_permanente'][$i] = $item->getStockPermanente();
    	  			$productoItemsDefault['stk_campana'][$i]    = $item->getStockCampana();
              $productoItemsDefault['stk_refuerzo'][$i]   = $item->getStockRefuerzo();
    	  			
    	  			$productoItemsDefault['imagen_grande'][$i] = imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto);
    	  			$productoItemsDefault['imagen_chica'][$i] = imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto);
    	  		
    	  		
    	  			$tieneReferenciaPedido = pedidoProductoItemTable::getInstance()->exist( $item->getIdProductoItem() );
    	  			$tieneReferenciaCarrito = carritoProductoItemTable::getInstance()->exist( $item->getIdProductoItem() );
    	  		
    	  			$productoItemsDefault['editable'][$i] = (!$tieneReferenciaPedido &&  !$tieneReferenciaCarrito );
    	  			$i++;
    	  		}
    	  		
    	  		$productosDefault['stock_' . $producto->getIdProducto()] = $productoItemsDefault;
      		}
      		
      		$this->itemsDefaults = $productosDefault;
	   }
  		
  		return $this->itemsDefaults;
	}
	
	public function mergeDefaults($params)
	{
	    $itemsDefaults = $this->getItemsDefaults();
	    
	    foreach( $itemsDefaults as $widget => $default )
	    {
	        $itemsDefaults[$widget]['cantidad_permanente'] = $params[$widget]['cantidad_permanente'];
	        $itemsDefaults[$widget]['cantidad_campana'] = $params[$widget]['cantidad_campana'];
          $itemsDefaults[$widget]['cantidad_refuerzo'] = $params[$widget]['cantidad_refuerzo'];
	    }
	    
	    return $itemsDefaults;
	}
	
}