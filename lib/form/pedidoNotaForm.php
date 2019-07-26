<?php

class pedidoNotaForm extends sfFormSymfony
{
  	public function configure()
  	{
  		$pedido = $this->getOption('pedido');
  		  		
	    $this->setWidgets(
	    	array
	    	(
				'nota' => new sfWidgetFormTextarea()
	    	)
	    );

	    $this->getWidget('nota')->setDefault( $pedido->getNota() );
	    
	    $this->setValidators
	    (
	    	array
	    	(
				'nota' => new sfValidatorString(array('required' => false)),
	    	)
	    );
	    	    
		$this->getWidgetSchema()->setNameFormat('nota[%s]');
  	}

	public function save()
	{	
		$pedido = $this->getOption('pedido');
		
		$nota = $this->getValue('nota');		  	
		
		$pedido->setNota( $nota );
		$pedido->save();
	}
}