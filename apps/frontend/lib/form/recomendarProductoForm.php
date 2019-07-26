<?php

class recomendarProductoForm extends sfForm
{    
  	public function configure()
  	{  		
	    $this->setWidget('email', new sfWidgetFormInputText());
	    $this->setWidget('id_producto', new sfWidgetFormInputHidden());
        $this->getWidgetSchema()->setNameFormat('recomendar_producto[%s]');
        
	    $this->setValidator('email', new sfValidatorEmail(array('required' => true)));
		$this->setValidator('id_producto', new sfValidatorPass());
  	}

}