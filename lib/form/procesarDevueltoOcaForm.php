<?php

class procesarDevueltosOcaForm extends sfFormSymfony
{		
  	public function configure()
  	{  		  		
	  	$this->setWidget( 'id_pedido', new sfWidgetFormInputCheckbox() );
	  	$this->setValidator('id_pedido', new sfValidatorPass() );
	  	
		$this->getWidgetSchema()->setNameFormat('procesarDevueltosOca[%s]');
  	}
	
}