<?php

class falladosFiltroForm extends sfFormSymfony
{
  	public function configure()
  	{  		
  	    // Widget para Marcas
  	    $choices = array();
  	    $marcas = marcaTable::getInstance()->listWithFallados();
  	    $choicesMarcas['TODAS'] = 'Todas';
  	    foreach ($marcas as $marca)
  	    {
  	        $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
  	    }
  	    $this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
  	    $this->getWidget( 'id_marca' )->setLabel('Marca');
  	    $this->setValidator( 'id_marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ) );
  	    
  	    $filters = sfContext::getInstance()->getUser()->getAttribute('fallados_filters');
  	    
  	    if ( isset( $filters['id_marca'] ) ) {
  	        $this->setDefault('id_marca', $filters['id_marca']);
  	    }
  	    
  	    // Widget de Fecha
  	    $this->setWidget('fecha',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	    $this->setValidator('fecha', new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))));
  	    
  	    if ( isset( $filters['fecha'] ) ) {
  	        $this->setDefault('fecha', $filters['fecha']);
  	    }
  	    
  	    // Widget para eShops
  	    $choices = array();
  	    $eshops = eshopTable::getInstance()->listAll();
  	    $choices['TODOS'] = 'Todos';
  	    $choices[ eshop::ESHOP_DELUXE ] = 'Deluxe Buys';
  	    foreach ($eshops as $eshop)
  	    {
  	        $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
  	    }
  	    $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
  	    $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
  	    
  	    if ( isset( $filters['id_eshop'] ) ) {
  	        $this->setDefault('id_eshop', $filters['id_eshop']);
  	    }
  	    
      	$this->getWidgetSchema()->setNameFormat('falladosFiltroForm[%s]');
  	}

  	
  	public function getIdMarca()
  	{
  	    return $this->getValue('id_marca');
  	}
  	
  	public function getFecha()
  	{
  	    return $this->getValue('fecha');
  	}
  	
  	public function getIdEshop()
  	{
  	    return $this->getValue('id_eshop');
  	}
  	
}