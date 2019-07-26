<?php

class comentarioInternoForm extends sfFormSymfony
{
  	public function configure()
  	{  	            
        // Comentario
        $this->setWidget('comentario', new sfWidgetFormTextarea() );
        $this->setValidator('comentario', new sfValidatorString( array('required' => false) ) );
  	    
		$this->getWidgetSchema()->setNameFormat('comentarioInterno[%s]');
  	}

  	
  	public function save($campanaMarca)
  	{
  	    $comentario = $this->getValue('comentario');
  	    $campanaMarca->setComentarioInterno( $comentario );
  	    $campanaMarca->save();
  	    
  	    return $campanaMarca;
  	}
  	
}