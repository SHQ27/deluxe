<?php

class pmWidgetDevolucion extends sfWidgetForm
{
	
  public function getJavaScripts()
  {
	return array('pmWidgetDevolucion.js');
  }
		
  protected function configure($options = array(), $attributes = array())
  {
  	$this->addOption('devolucion');
    parent::configure($options,$attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {  		
  		$identifier = $this->generateId($name);
  		
  		$devolucion = $this->getOption('devolucion');
  		$devolucionProductoItems = $devolucion->getDevolucionProductoItem();

		$productoHidden = new sfWidgetFormInputHidden();  		 		
  		$talleHidden = new sfWidgetFormInputHidden();
  		$colorHidden = new sfWidgetFormInputHidden();
  		  		  		  							
		// Definicion del template
		$template  = '';
						
		$template .= '<table>';
		$template .= '	<tr>';
		$template .= '		<th>Id Pedido</th>';
		$template .= '		<th>Imagen</th>';
		$template .= '		<th>Producto</th>';
		$template .= '		<th>Marca</th>';
		$template .= '		<th>Talle</th>';
		$template .= '		<th>Color</th>';
		$template .= '		<th>Cantidad</th>';
		
		if ( !$devolucion->getIdEshop() ) {
		  $template .= '		<th>Devolvibles<br />a la marca</th>';
		}
		
		$template .= '		<th>Fallados</th>';
		$template .= '		<th>Detalle de Fallados</th>';
		$template .= '	</tr>';
		
		
		$productosDefault = array();
		$i = 0;
		foreach($devolucionProductoItems as $devolucionProductoItem)
		{		    
			$pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem();

			$productoItem = $pedidoProductoItem->getProductoItem();
			$producto = $productoItem->getProducto();

			$productosDefault[ $devolucionProductoItem->getIdDevolucionProductoItem() ] = array(
				'idProducto' 	  => $producto->getIdProducto(),
				'idProductoTalle' => $productoItem->getIdProductoTalle(),
				'idProductoColor' => $productoItem->getIdProductoColor()
			);
			
			$valueCantidad = $devolucionProductoItem->getCantidad();
			
			$productoItems = $producto->getProductoItem();

			$pedidosProductoItemCampana = $pedidoProductoItem->getPedidoProductoItemCampana();
			$idCampana = ( count( $pedidosProductoItemCampana ) ) ? $pedidosProductoItemCampana->getFirst()->getIdCampana() : null;

			if ( $idCampana ) {
				$productos = productoTable::getInstance()->listPertenecieronCampana( $idCampana, $producto->getIdMarca() );
				if ( !count( $productos ) ) { $productos = array( $producto ); }

			} else {
				$productos = productoTable::getInstance()->listByIdMarca($producto->getIdMarca(), true );
			}
					


			$choicesProducto = array();
			foreach( $productos as $p )
			{			    			    
			    $choicesProducto[ $p->getIdProducto() ] = $p->getDenominacion();
			}
									
			$productoSelect = new sfWidgetFormSelect( array('choices' => $choicesProducto) );
			$talleSelect 	= new sfWidgetFormSelect( array('choices' => array() ) );
			$colorSelect 	= new sfWidgetFormSelect( array('choices' => array() ) );
			
			$choiceCantidad = array();
			for ($i = 0 ; $i <= $valueCantidad ; $i++ ) $choiceCantidad[$i] = $i;
			$cantidad = new sfWidgetFormSelect( array('choices' => $choiceCantidad ) );
			
			
			if ( !$devolucion->getIdEshop() ) {
			    $choiceCantidad = array();
			    for ($i = 0 ; $i <= $valueCantidad ; $i++ ) $choiceCantidad[$i] = $i;
			    $cantidadDevueltos = new sfWidgetFormSelect( array('choices' => $choiceCantidad ) );			    
			} else {
			    $cantidadDevueltos = new sfWidgetFormInputHidden();
			}
			
			$choiceCantidad = array();
			for ($i = 0 ; $i <= $valueCantidad ; $i++ ) $choiceCantidad[$i] = $i;
			$cantidadFallados = new sfWidgetFormSelect( array('choices' => $choiceCantidad ) );
			
			$template .= '<tr class="row" rel="' . $devolucionProductoItem->getIdDevolucionProductoItem() . '">';
						
			$template .= '<td><a href="/backend/pedidos/' . $pedidoProductoItem->getIdPedido() . '/ListView">' . $pedidoProductoItem->getIdPedido() . '</a></td>';
			$template .= '<td><a href="/backend/productos/' . $producto->getIdProducto() . '/edit">' . '<img src="' . imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) . '" width="100px">' . '</a></td>';
			$template .= '<td class="producto">' . $productoHidden->render($name.'[producto_hidden][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']') . $productoSelect->render($name.'[producto][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']') . '</td>';
			$template .= '<td>' . $producto->getMarca()->getNombre() . '</td>';
			$template .= '<td class="talle">' . $talleHidden->render($name.'[talle_hidden][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']') . $talleSelect->render($name.'[talle][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']') . '</td>';
			$template .= '<td class="color">' . $colorHidden->render($name.'[color_hidden][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']') . $colorSelect->render($name.'[color][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']') . '</td>';
			$template .= '<td>' . $cantidad->render($name.'[cantidad][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']', $valueCantidad ) . '</td>';
			
			if ( !$devolucion->getIdEshop() ) {
			    $template .= '<td>' . $cantidadDevueltos->render($name.'[cantidad_devueltos][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']', 0 ) . '</td>';
			} else {
			    $template .= $cantidadDevueltos->render($name.'[cantidad_devueltos][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']', 0 );
			}
			
			$template .= '<td>' . $cantidadFallados->render($name.'[cantidad_fallados][' . $devolucionProductoItem->getIdDevolucionProductoItem() . ']', 0 ) . '</td>';
			$template .= '<td class="detalleFallados">No hay fallados</td>';
			$template .= '</tr>';
			$i++;
		}
		$template .= '</table>';
				
		$template .= '<script>defaults = ' . json_encode($productosDefault) . '</script>';
		
				
		return $template;  	
  }
}
?>