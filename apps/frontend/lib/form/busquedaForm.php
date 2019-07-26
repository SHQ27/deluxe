<?php

class busquedaForm extends sfFormSymfony
{
  	public function configure()
  	{  		
	    $this->setWidget('buscar', new sfWidgetFormInput());
	    
		//$this->getWidgetSchema()->setNameFormat('contacto[%s]');
	
	    $this->setValidators
	    (
	    	array
	    	(
		    	'buscar' => new sfValidatorString(array()),
	    	)
	    );
  	}
  	
	public function buscar()
	{		
	  	$busqueda = $this->getValue('busqueda');
	  	var_dump($busqueda); die;
	}
}