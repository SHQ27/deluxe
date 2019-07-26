<?php

class ingresarFechaEntregaCampanaForm extends sfFormSymfony
{
  	public function configure()
  	{  	    
  	    // Fechas
        $this->setWidget('fecha_entrega', new pmWidgetFormDate());        
        $this->setValidator('fecha_entrega', new sfValidatorDate(
                array('required' => true),
                array('invalid' => 'Fecha inválida.')));
        
        // Comentario
        $this->setWidget('comentario', new sfWidgetFormTextarea() );
        $this->setValidator('comentario', new sfValidatorString( array('required' => false) ) );
  	    
		$this->getWidgetSchema()->setNameFormat('ingresarFechaEntregaCampana[%s]');
  	}

  	
  	public function save($campanaMarca)
  	{
  	    $fechaEntrega = $this->getValue('fecha_entrega');
  	    $comentario = $this->getValue('comentario');
  	    
  	    $campanaMarca->setFechaEstimadaEntrega( $fechaEntrega );
  	    $campanaMarca->setComentarioMarca( $comentario );
  	    $campanaMarca->save();
  	    
  	    return $fechaEntrega;
  	}
  	
}