<?php

class recomendarPostForm extends sfForm
{    
  	public function configure()
  	{  		
	    $this->setWidget('email', new sfWidgetFormInputText());
	    $this->setWidget('id_post', new sfWidgetFormInputHidden());
        $this->getWidgetSchema()->setNameFormat('recomendar_post[%s]');
        
	    $this->setValidator('email', new sfValidatorEmail(array('required' => true)));
		$this->setValidator('id_post', new sfValidatorPass());
  	}

}