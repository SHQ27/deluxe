<?php

class devueltosOcaForm extends sfFormSymfony
{		
  	public function configure()
  	{  		  		
	  	$this->setWidget( 'guias_envio', new sfWidgetFormTextarea() );
	  	$this->setValidator('guias_envio', new sfValidatorPass() );
	  	
		$this->getWidgetSchema()->setNameFormat('devueltosOca[%s]');
  	}

	public function prepare()
	{
		$guiasEnvio = $this->getValue('guias_envio');
		$guiasEnvio = explode(',', $guiasEnvio);
		
		function trimValue(&$value) { $value = trim($value); }		
		array_walk($guiasEnvio, 'trimValue');
		
		return implode(',', $guiasEnvio);
	}
	
}