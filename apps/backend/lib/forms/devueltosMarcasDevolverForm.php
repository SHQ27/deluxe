<?php

class devueltosMarcasDevolverForm extends sfFormSymfony
{
  	public function configure()
  	{
  	    $this->setWidget( 'confirmado', new sfWidgetFormInputCheckbox() );
  	    $this->setValidator( 'confirmado', new sfValidatorPass() );

  	    $this->getWidgetSchema()->setNameFormat('devueltosMarcasDevolverForm[%s]');
  	}

  	
  	public function process()
  	{  	    
  	    $confirmados = $this->getValue('confirmado');
  	    
  	    if ( count( $confirmados ) ) 
  	    {
  	       devueltoMarcaTable::getInstance()->marcarDevueltos( $confirmados );
  	    }
  	      	    
  	    return count( $confirmados );
  	}
  	
}