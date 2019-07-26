<?php

class addProductoForm extends sfFormSymfony
{
  	public function configure()
  	{  	
  		
  		$emptyLabelTalle = deviceHelper::getInstance()->isMobile() ? 'Talle' : 'Seleccionar';
  		$emptyLabelColor = deviceHelper::getInstance()->isMobile() ? 'Color' : 'Seleccionar';
  		$emptyLabelCantidad = deviceHelper::getInstance()->isMobile() ? 'Cantidad' : '0';

	    $this->setWidgets(
	    	array
	    	(
	    		'id_producto' => new sfWidgetFormInputHidden(),
				'talle'		 => new sfWidgetFormSelect(array('choices' => array('' => $emptyLabelTalle )), array('title' => $emptyLabelTalle)),
				'color'		 => new sfWidgetFormSelect(array('choices' => array('' => $emptyLabelColor )), array('title' => $emptyLabelColor)),
				'cantidad'	 => new sfWidgetFormSelect(array('choices' => array('0' => $emptyLabelCantidad )), array('title' => $emptyLabelCantidad))
	    	)
	    );
	    
	    $this->getWidget('id_producto')->setAttribute('id', 'id_producto');
	    $this->getWidget('talle')->setAttribute('id', 'talle');
	    $this->getWidget('color')->setAttribute('id', 'color');
	    $this->getWidget('cantidad')->setAttribute('id', 'cantidad');
	    
	    
		$this->getWidgetSchema()->setNameFormat('addProducto[%s]');
	
	    $this->setValidators
	    (
	    	array
	    	(
	    		'id_producto' => new sfValidatorNumber(array('required' => true)),
		    	'talle' => new sfValidatorString(array('required' => true)),
		    	'color' => new sfValidatorString(array('required' => true)),
		    	'cantidad' => new sfValidatorNumber(array('required' => true))
	    	)
	    );
  	}
  	
}