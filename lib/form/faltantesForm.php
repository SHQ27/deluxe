<?php

class faltantesForm extends sfFormSymfony
{		
  	public function configure()
  	{ 		  		
	    // Widget para eShops
	    $choices = array();
	    $eshops = eshopTable::getInstance()->listAll();
	    $choices[''] = 'Deluxe Buys';
	    foreach ($eshops as $eshop)
	    {
	        $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
	    }
	    $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	    $this->getWidget( 'id_eshop' )->setLabel('eShop');
	    $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );

	  	// Widget para Campañas
	  	$choices = array();
	  	$choices[''] = 'Seleccionar';
	  	$choices['STKPER'] = 'Stock Permanente';
	  	$choices['OUTLET'] = 'Stock Permanente en Outlet';
	  	$campanas = campanaTable::getInstance()->listAll();
	  	foreach ($campanas as $campana)
	  	{
	  		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
	  		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
	  		$choices[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
	  	}

	  	$this->setWidget('campana', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->getWidget('campana')->setLabel('Campaña / Stock Permanente');
	  	$this->setValidator( 'campana', new sfValidatorString( array( 'required' => false ) ) );

	  	// Widget para Marcas
	  	$choices = array();
	  	$this->setWidget('id_marca', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->getWidget('id_marca')->setLabel('Marca');
	  	$this->setValidator( 'id_marca', new sfValidatorString( array( 'required' => false ) ) );
	  	
	  	// Widget para Productos
	  	$choices = array();	  	
	  	$this->setWidget( 'producto', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->setValidator( 'producto', new sfValidatorString( array( 'required' => false ) ) );

	  	$this->setWidget( 'productoItem', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->setValidator( 'productoItem', new sfValidatorString( array( 'required' => false ) ) );
	    
		$this->getWidgetSchema()->setNameFormat('faltantes[%s]');	    
  	}
	
}