<?php

class faltanteEnvioForm extends sfFormSymfony
{		
  	public function configure()
  	{  		  		
  		
	  	// Widget para Campañas
		$this->setWidget( "mensaje", new sfWidgetFormTextarea());
	  	
	  	// Widget para Productos
	  	$choices = array();
	  	for( $i=1 ; $i <= $this->getOption('cantidad') ; $i++ ) $choices[$i] = $i;
	  	$this->setWidget( 'cantidad', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	
	  	$this->getWidgetSchema()->setNameFormat('faltanteEnvio[%s]');
	  	
	    $this->setValidators
	    (
	    	array
	    	(
			    'mensaje'	=> new sfValidatorString( array( 'required' => true ) ),
	    		'cantidad'	=> new sfValidatorString( array( 'required' => true ) )
	    	)
	    );
  	}

	public function send($pedido, $productoItem)
	{	
		$cantidadFaltante = $this->getValue('cantidad');
		$mensaje = $this->getValue('mensaje');

		faltanteTable::getInstance()->generar($pedido, $productoItem, $cantidadFaltante, $mensaje);
		
		return true;
	}
	
}