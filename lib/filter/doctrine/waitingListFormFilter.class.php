<?php

/**
 * waitingList filter form.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class waitingListFormFilter extends BasewaitingListFormFilter
{
  public function configure()
  { 	
	    $this->setWidgets(array());
	    $this->setValidators(array());
  	
	    $this->widgetSchema->setNameFormat('waiting_list_filters[%s]');
	    
	  	// Widget para Campañas
	  	$choices = array();
	  	$campanas = campanaTable::getInstance()->listAll();
	  	$choices[''] = '';
	  	$choices['STKPER'] = 'Stock Permanente';
	  	foreach ($campanas as $campana)
	  	{
	  		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
	  		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
	  		$choices[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
	  	}
	  	
	  	$this->setWidget( 'stock_campana', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->getWidget('stock_campana')->setLabel('Stk. Perm. / Campaña');
	  	$this->setValidator('stock_campana', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ));
	  	
	  	// Widget para Marcas
	  	$choices = array();
	  	$marcas = marcaTable::getInstance()->listAll();
	  	$choicesMarcas[''] = 'Todas';
	  	foreach ($marcas as $marca)
	  	{ 
	  		$choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
	  	}
	  	$this->setWidget( 'marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
	    
	    $this->setValidator('marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ) );
	  	
	  	// Solo Productos Activo
	  	$this->setWidget( 'productos_activos', new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))));
	  	$this->setValidator('productos_activos', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))));	  	  	
  }
}
