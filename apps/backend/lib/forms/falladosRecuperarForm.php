<?php

class falladosRecuperarForm extends sfFormSymfony
{
  	public function configure()
  	{
  	    $this->setWidget( 'confirmado', new sfWidgetFormInputCheckbox() );
  	    $this->setValidator( 'confirmado', new sfValidatorPass() );

  	    $this->getWidgetSchema()->setNameFormat('falladosRecuperarForm[%s]');
  	}

  	
  	public function process()
  	{  	    
  	    $confirmados = $this->getValue('confirmado');
  	    
  	    if ( count( $confirmados ) ) 
  	    {
  	       falladoTable::getInstance()->marcarRecuperados( $confirmados );
  	    }
  	      	    
  	    return count( $confirmados );
  	}
  	
}