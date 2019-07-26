<?php

class pmWidgetProductoItem extends sfWidgetForm
{
  public function __construct($options = array(), $attributes = array())
  {
	$this->addOption('batch_edit', false);
	parent::__construct($options, $attributes);
  }

  protected function configure($options = array(), $attributes = array())
  {  	
    parent::configure($options,$attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {  		
  		$batchEdit = $this->getOption('batch_edit');
  	
  	
		// Definicion de los campos que componen al widget
		
  		$idProductoItemHidden = new sfWidgetFormInputHidden();
		$talleHidden = new sfWidgetFormInputHidden();
		$colorHidden = new sfWidgetFormInputHidden();		
  	
		$productoTalles = productoTalleTable::getInstance()->listAll();
		$choices = array();
		
		foreach ($productoTalles as $productoTalle) {
		    $choices[ $productoTalle->getIdProductoTalle() ] = $productoTalle->getFamiliaTalle()->getDenominacion() . ' :: ' . $productoTalle->getDenominacion();
		}
		
		$codigo = new sfWidgetFormInputText();
		$talle = new sfWidgetFormChoice( array('choices' => $choices ) );		
		$color = new sfWidgetFormDoctrineChoice(array('model' => 'productoColor', 'add_empty' => true));
		
		$accion = new sfWidgetFormSelect(array('choices' => array( 'SUMAR' => 'Sumar', 'RESTAR' => 'Restar' ) ));
		
		$origen = new sfWidgetFormSelect(array('choices' => array(
			producto::ORIGEN_OFERTA 		  => 'Campaña',
            producto::ORIGEN_OUTLET 		  => 'Outlet',
            producto::ORIGEN_STOCK_PERMANENTE => 'Permanente',
            producto::ORIGEN_REFUERZO		  => 'Refuerzo'
        )));
		
		
		$cantidad = new sfWidgetFormInputText();
		$observacion = new sfWidgetFormTextArea();
		
		$choices = stockTipoTable::getInstance()->getManualOptions();		
		$stockTipos = new sfWidgetFormSelect(array('choices' => $choices ));
						
		// Definicion del template
		$template  = '';
				
		if (!$batchEdit)
		{
			$template .= $codigo->render($name.'[codigo][]');
			$template .= $talle->render($name.'[talle][]');
			$template .= $color->render($name.'[color][]');
			$template .= $accion->render($name.'[accion][]');
			$template .= $origen->render($name.'[origen][]');			
			$template .= $cantidad->render($name.'[cantidad][]');
			$template .= $observacion->render($name.'[observacion][]');
			$template .= $stockTipos->render($name.'[stock_tipo][]');
		}
		
		$template .= '<table id="' . $this->generateId($name) . '_table">';
		
		if (isset($value['talle']))
		{
			$c = count($value['talle']);
			$c = ($c > 1)? $c : 1;
		}
		else
		{
			$c = 1;
		}
	
		$template .= '<tr>';
		
		if ($batchEdit)
		{
			$template .= '	<td class="editCol">Imagen</td>';
		}
		
		$template .= '	<td class="editCol">ID</td>';
		$template .= '	<td class="editCol">Código</td>';
		$template .= '	<td class="editCol">Talle</td>';
		$template .= '	<td class="editCol">Color</td>';
		$template .= '	<td class="center"><span title="Stock en Carrito" alt="Stock en Carrito">En<br/>Car.</span></td>';
		$template .= '	<td class="center darkGrey"><span title="Stock en Venta" alt="Stock en Venta">En<br/>Vta.</span></td>';
		$template .= '	<td class="center darkGrey"><span title="Stock de pedidos todavía no pagados" alt="Stock de pedidos todavía no pagados">No<br/>Pag.</span></td>';
		$template .= '	<td class="center darkGrey"><span title="Stock de pedidos pagados, no entregados" alt="Stock de pedidos pagados, no entregados">Pag.</span></td>';
		$template .= '	<td class="center"><span title="Stock de pedidos entregados" alt="Stock de pedidos entregados">Ent.</span></td>';
		
		
		$template .= '	<td class="center"><span title="Stock de Permanente" alt="Stock de Permanente">STK<br/>Per.</span></td>';
		$template .= '	<td class="center"><span title="Stock de Campañas" alt="Stock de Campañas">STK<br/>Cam.</span></td>';
		$template .= '	<td class="center"><span title="Stock de Outlet" alt="Stock de Outlet">STK<br/>Out.</span></td>';
		$template .= '	<td class="center"><span title="Stock de Refuerzo" alt="Stock de Refuerzo">STK<br/>Ref.</span></td>';
		
		
		if (!$batchEdit)
		{
			$template .= '	<td class="center editCol">Accion</td>';
			$template .= '	<td class="center editCol">Aplicar en <br/>stock de</td>';
			$template .= '	<td class="center editCol">Cant.</td>';
			$template .= '	<td class="center editCol">Tipo</td>';
			$template .= '	<td class="center editCol">Observacion</td>';
		}
		else
		{
			$template .= '	<td class="editCol"><span>Nuevo<br/>STK Per.</span></td>';
			$template .= '	<td class="editCol"><span>Nuevo<br/>STK Cam.</span></td>';
			$template .= '	<td class="editCol"><span>Nuevo<br/>STK Ref.</span></td>';
		}
		
		$template .= '</tr>';
		
		for($i=0;$i<$c;$i++)
		{
			$valueCodigo = isset($value['codigo'][$i]) ? $value['codigo'][$i] : '';
			$valueTalle = isset($value['talle'][$i]['id']) ? $value['talle'][$i]['id'] : '';
			$denominacionTalle = isset($value['talle'][$i]['denominacion']) ? $value['talle'][$i]['denominacion'] : '';
			$valueColor = isset($value['color'][$i]['id']) ? $value['color'][$i]['id'] : '';
			$denominacionColor = isset($value['color'][$i]['denominacion']) ? $value['color'][$i]['denominacion'] : '';
			
			$valueStkCarrito = isset($value['stk_carrito'][$i]) ? $value['stk_carrito'][$i] : 0;
			$valueStkVenta = isset($value['stk_venta'][$i]) ? $value['stk_venta'][$i] : 0;
			$valueStkNoPagado = isset($value['stk_no_pagado'][$i]) ? $value['stk_no_pagado'][$i] : 0;
			$valueStkPagado = isset($value['stk_pagado'][$i]) ? $value['stk_pagado'][$i] : 0;
			$valueStkEntregado = isset($value['stk_entregado'][$i]) ? $value['stk_entregado'][$i] : 0;
			$valueStkPermanente = isset($value['stk_permanente'][$i]) ? $value['stk_permanente'][$i] : 0;
			$valueStkCampana = isset($value['stk_campana'][$i]) ? $value['stk_campana'][$i] : 0;
			$valueStkOutlet = isset($value['stk_outlet'][$i]) ? $value['stk_outlet'][$i] : 0;
			$valueStkRefuerzo = isset($value['stk_refuerzo'][$i]) ? $value['stk_refuerzo'][$i] : 0;			
			
			$valueCantidadPermanente = isset($value['cantidad_permanente'][$i]) ? $value['cantidad_permanente'][$i] : $valueStkPermanente;
			$valueCantidadCampana = isset($value['cantidad_campana'][$i]) ? $value['cantidad_campana'][$i] : $valueStkCampana;
			$valueCantidadRefuerzo = isset($value['cantidad_refuerzo'][$i]) ? $value['cantidad_refuerzo'][$i] : $valueStkRefuerzo;
			
			$valueAccion = isset($value['accion'][$i]) ? $value['accion'][$i] : 'SUMAR';
			$valueOrigen = isset($value['origen'][$i]) ? $value['origen'][$i] :  producto::ORIGEN_OFERTA;
			$valueCantidad = isset($value['cantidad'][$i]) ? $value['cantidad'][$i] : 0;
			$valueStockTipo = isset($value['stock_tipo'][$i]) ? $value['stock_tipo'][$i] : stockTipo::MANUAL_OTRO;
			$valueObservacion = isset($value['observacion'][$i]) ? $value['observacion'][$i] : '';
			
			$idProductoItem = isset($value['id_producto_item'][$i]) ? $value['id_producto_item'][$i] : 0;
			
			
			$valueEditable = isset($value['editable'][$i]) ? $value['editable'][$i] : true;
			
			$talleHidden->setAttribute('rel', $denominacionTalle);
			$colorHidden->setAttribute('rel', $denominacionColor);
						
			$template .= '<tr rel="' . $idProductoItem . '">';
			
			
			
			if ($batchEdit && $i == 0)
			{
				$template .= '<td rowspan="' . $c . '" class="editCol"><a class="enlargeImage" href="' . $value['imagen_grande'][$i] . '"><img src="' . $value['imagen_chica'][$i] . '"/></a></td>';				
			}
			
			
			if ($valueEditable && !$batchEdit)
			{
			    $template .= '	<td class="center editCol">' . $idProductoItem . '</td>';
			    $template .= '	<td class="editCol codigo">' . $codigo->render($name.'[codigo][]', $valueCodigo) . '</td>';
				$template .= '	<td class="editCol talle">' . $talle->render($name.'[talle][]', $valueTalle) . '</td>';
				$template .= '	<td class="editCol color">' . $color->render($name.'[color][]', $valueColor) . '</td>';
			}
			else 
			{
			    $template .= '	<td class="center editCol">' . $idProductoItem . $idProductoItemHidden->render($name.'[idProductoItem][]', $idProductoItem) . '</td>';
			    $template .= '	<td class="editCol">' . $valueCodigo . '</td>';
				$template .= '	<td class="editCol">' . $denominacionTalle . $talleHidden->render($name.'[talle][]', $valueTalle) . '</td>';
				$template .= '	<td class="editCol">' . $denominacionColor. $colorHidden->render($name.'[color][]', $valueColor) . '</td>';
			}
			
			$template .= '	<td class="center">' . $valueStkCarrito . '</td>';
			$template .= '	<td class="center darkGrey">' . $valueStkVenta . '</td>';
			$template .= '	<td class="center darkGrey">' . $valueStkNoPagado . '</td>';
			$template .= '	<td class="center darkGrey">' . $valueStkPagado . '</td>';
			$template .= '	<td class="center">' . $valueStkEntregado . '</td>';
			$template .= '	<td class="center stockPermanente">' . $valueStkPermanente . '</td>';
			$template .= '	<td class="center stockCampana">' . $valueStkCampana . '</td>';
			$template .= '	<td class="center stockOutlet">' . $valueStkOutlet . '</td>';
			$template .= '	<td class="center stockRefuerzo">' . $valueStkRefuerzo . '</td>';
			
			if (!$batchEdit)
			{
				$template .= '	<td class="editCol">' . $accion->render($name.'[accion][]', $valueAccion) . '</td>';
				$template .= '	<td class="editCol center">' . $origen->render($name.'[origen][]', $valueOrigen) . '</td>';
			}			
			
			if (!$batchEdit)
			{
			    $template .= '	<td class="editCol cantidad">' . $cantidad->render($name.'[cantidad][]', $valueCantidad) . '&nbsp;&nbsp;u.</td>';
			    $template .= '	<td class="editCol">' . $stockTipos->render($name.'[stock_tipo][]', $valueStockTipo) . '</td>';
				$template .= '	<td class="editCol">' . $observacion->render($name.'[observacion][]', $valueObservacion) . '</td>';
			}		
			else
			{
			    $template .= '	<td class="editCol">' . $cantidad->render($name.'[cantidad_permanente][]', $valueCantidadPermanente) . '&nbsp;&nbsp;u.</td>';
			    $template .= '	<td class="editCol">' . $cantidad->render($name.'[cantidad_campana][]', $valueCantidadCampana) . '&nbsp;&nbsp;u.</td>';
			    $template .= '	<td class="editCol">' . $cantidad->render($name.'[cantidad_refuerzo][]', $valueCantidadRefuerzo) . '&nbsp;&nbsp;u.</td>';
			}				
			
			if (!$batchEdit)
			{
				if ($valueEditable)
				{
					$template .= '	<td class="remove editCol"><a></a></td>';
				}
				else 
				{
					$template .= '	<td class="remove editCol">&nbsp;</td>';
				}
			}
			
			$template .= '	<td class="ver editCol"><a></a></td>';
			
			$template .= '</tr>';
		}

		
		$template .= '</table>';
		
		if (!$batchEdit)
		{
			$template .= '<a id="' . $this->generateId($name) . '_addItem">Agregar item</a>';
			$template .= '<div id="' . $this->generateId($name) . '_info"></div>';
		}
		else
		{
			$template .= '<div id="batchEdit_info"></div>';
		}
		

		
		return $template;
  	
  }
}
?>