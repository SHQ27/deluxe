<?php

class reporteCuponerasForm extends sfFormSymfony
{
  	public function configure()
  	{
  	    $this->setWidget('prefijo', new sfWidgetFormInputText() );
  	    $this->setValidator('prefijo', new sfValidatorString( array('required' => false) ));
  	    
  	    
      	$this->setWidget('vigencia_desde', new pmWidgetFormDate() );
      	$this->setValidator('vigencia_desde', new sfValidatorDate( array('required' => false) ));
      	
      	$this->setWidget('vigencia_hasta', new pmWidgetFormDate() );
      	$this->setValidator('vigencia_hasta', new sfValidatorDate() );
      	
      	$this->setWidget('valor_pagado', new sfWidgetFormInputText() );
      	$this->getWidget('valor_pagado')->setLabel('Valor pagado por el Cupon');
      	$this->setValidator('valor_pagado', new sfValidatorNumber());
      	
      	$choices = array();
      	for($i = 0 ; $i <= 100 ; $i = $i + 1 ) $choices[ sprintf('%.2f', $i/100) ] = "$i%";
      	$this->setWidget( "comision_cuponera", new sfWidgetFormSelect( array( 'choices' => $choices ) ) );
      	$this->setValidator('comision_cuponera', new sfValidatorChoice( array( 'choices' => array_keys($choices) ) ) );
      	
      	$this->getWidgetSchema()->setNameFormat('reporteCuponerasForm[%s]');
  	}
  	
  	public function process()
  	{
  	    return descuentoTable::getInstance()->reporteCuponeras( $this->getValues() );
  	}
  	
}