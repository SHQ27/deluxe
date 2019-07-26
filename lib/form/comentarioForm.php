<?php

class comentarioForm extends sfFormSymfony
{
  	public function configure()
  	{  		
	    $this->setWidgets(
	    	array
	    	(
				'nombre' => new sfWidgetFormInput(),
				'email' => new sfWidgetFormInput(),
				'texto' => new sfWidgetFormTextarea()
	    	)
	    );
	    
		$this->getWidgetSchema()->setNameFormat('comentario[%s]');
	
	    $this->setValidators
	    (
	    	array
	    	(
		    	'nombre' => new sfValidatorString(array('required' => true)),		    	
		    	'email' => new sfValidatorEmail(array('required' => true)),
				'texto' => new sfValidatorString(array('required' => true)),
	    	)
	    );
  	}

	public function enviar($idPost)
	{	
		$nombre = $this->getValue('nombre');
		$email = $this->getValue('email');
  		$texto = $this->getValue('texto');		  	
  		
		$comentario = new postComentario();
		$comentario->setIdPost($idPost);
		$comentario->setNombre($nombre);
		$comentario->setEmail($email);
		$comentario->setComentario($texto);
		$comentario->save();

	}
}