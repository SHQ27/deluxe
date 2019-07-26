<?php

class productosEditarEshopForm extends sfFormSymfony
{
  	public function configure()
  	{  		  		
  	    $this->setWidget('ids', new sfWidgetFormInputHidden());
  	    $this->setValidator( 'ids', new sfValidatorPass());
  	    
  		$choices = array();
    	$eshops = eshopTable::getInstance()->listAll();
    	$choices[''] = 'Deluxe Buys';
    	foreach ($eshops as $eshop)
    	{
    	    $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
    	}
		$this->setWidget('eshop', new sfWidgetFormChoice( array('choices'  => $choices ) ) );
		$this->setValidator( 'eshop', new sfValidatorChoice(array('choices' => array_keys($choices), 'required' => false) ) );
		
  		$this->getWidgetSchema()->setNameFormat('productosEditarEshop[%s]');
  	}

	public function save()
	{
		$values = $this->getValues();
		
		$ids = $values['ids'];
		$idEshop = $values['eshop'];
		
		$productos = productoTable::getInstance()->listByIdProductos( $ids );
		
		foreach ($productos as $producto)
		{
      $producto->setIdEshop( $idEshop );
      
      $producto->doNotPostActions( array(
  		  producto::POST_ACTION_UPDATE_PRECIO,
  		  producto::POST_ACTION_UPDATE_STOCK,
        producto::POST_ACTION_UPDATE_ML,
  		  producto::POST_ACTION_CERRAR_PUBLICACION_ML
	    ) );

		  $producto->save();
		}
	}
}