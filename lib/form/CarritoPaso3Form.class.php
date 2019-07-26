<?php

class CarritoPaso3Form extends sfFormSymfony
{
    public function configure()
    {        
    	
    	$choices = array('DNI'=>'DNI', 'LC'=>'LC', 'LE'=>'LE');
    	
        $this->setWidgets(array(
            'tipoDocumento'  => new sfWidgetFormSelect(array('choices' => $choices)),
	        'documento'    	 => new sfWidgetFormInput(),
        	'montoTotal'   	 => new sfWidgetFormInputHidden(),
            'tipoPago'   	 => new sfWidgetFormInputHidden(),
            'cuotas'   	     => new sfWidgetFormInputHidden()
        ));
     
        $this->setValidators(array(
            'tipoDocumento' => new sfValidatorChoice(array('required' => false, 'choices'=>array_keys($choices))),
            'documento'     => new pmValidatorDocumento(array('required' => false)),
        	'montoTotal'    => new sfValidatorPass(),
            'tipoPago'      => new sfValidatorPass(),
            'cuotas'      => new sfValidatorPass()
        ));
        
        $this->widgetSchema->setNameFormat('paso3[%s]');
        
	    $this->validatorSchema->setPostValidator(
	      new sfValidatorCallback( array( 'callback' => array($this, 'validarMontoDocumento')) )
	    );
        
    }
    
    public function validarMontoDocumento($sfValidatorCallback, $values, $arguments)
    {        
    	if ( $values['montoTotal'] >= 1000 && !trim($values['documento']) )
    	{    		
    		throw new sfValidatorError($this->getValidator('documento'), 'required');
    	}
    	
    	return $values;
    }
    
    public function save()
    {    	
    	$usuario = sfContext::getInstance()->getUser()->getCurrentUser();
    	$usuario->setTipoDocumento( $this->getValue('tipoDocumento') );
    	$usuario->setDocumento( $this->getValue('documento') );
    	$usuario->save();
    }
}