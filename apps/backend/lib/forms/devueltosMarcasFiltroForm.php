<?php

class devueltosMarcasFiltroForm extends sfFormSymfony
{
  	public function configure()
  	{  		
  	    // Widget para Marcas
  	    $choices = array();
  	    $marcas = marcaTable::getInstance()->listWithDevueltosMarcas();
  	    $choicesMarcas['TODAS'] = 'Todas';
  	    foreach ($marcas as $marca)
  	    {
  	        $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
  	    }
  	    $this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
  	    $this->getWidget( 'id_marca' )->setLabel('Marca');
  	    $this->setValidator( 'id_marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => false ) ) );
  	    
  	    $filters = sfContext::getInstance()->getUser()->getAttribute('devueltosMarcas_filters');
  	    
  	    if ( isset( $filters['id_marca'] ) ) {
  	        $this->setDefault('id_marca', $filters['id_marca']);
  	    }
  	    
  	    // Widget de Fecha
  	    $this->setWidget('fecha',  new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false)));
  	    $this->setValidator('fecha', new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))));
  	          	
      	// Widget de Devuelto
      	$this->setWidget('devuelto',  new sfWidgetFormChoice(array('choices' => array(0 => 'No devueltos', 1 => 'Devueltos') ) ) );
      	$this->getWidget('devuelto')->setLabel('Mostrar');
      	$this->setValidator('devuelto', new sfValidatorChoice(array('required' => false, 'choices' => array(0, 1) ) ) );
      	
      	$this->getWidgetSchema()->setNameFormat('devueltosMarcasFiltroForm[%s]');
  	}

  	
  	public function getIdMarca()
  	{
  	    return $this->getValue('id_marca');
  	}
  	
  	public function getFecha()
  	{
  	    return $this->getValue('fecha');
  	}
  	
  	public function getDevuelto()
  	{
  	    return $this->getValue('devuelto');
  	}
  	
}