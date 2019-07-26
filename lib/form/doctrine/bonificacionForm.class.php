<?php

/**
 * bonificacion form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bonificacionForm extends BasebonificacionForm
{
  public function configure()
  {
    unset($this->widgetSchema['id_usuario']);
    unset($this->validatorSchema['id_usuario']);

    $bonificacion = $this->getObject();
    
  	$this->setWidget('email_usuario',  new sfWidgetFormInputText());
  	$this->setValidator('email_usuario', new sfValidatorString() );
  	
  	if (!$this->isNew())
  	{
  	    $this->setDefault('email_usuario', $bonificacion->getUsuario()->getEmail() );
  	}
  	
  	$this->setWidget('vencimiento', new pmWidgetFormDate() );
  	
  	$this->setWidget('fue_utilizada', new sfWidgetFormInputHidden() );
  	
  	$this->setWidget('es_interna', new sfWidgetFormInputHidden() );
  	$this->getWidget('es_interna')->setDefault(false);
  	
  	$this->setWidget('fecha_alta', new sfWidgetFormInputHidden() );
  	$this->setValidator('fecha_alta', new sfValidatorPass() );
  }
  
  
  protected function doSave($con = null)
  {  	
  	$dataDevolucion = $this->getValue('devolucion');
  	$emailUsuario = $this->getValue('email_usuario');
  	
  	$usuario = usuarioTable::getInstance()->getByEmail( $emailUsuario, null );
  	  	  	
  	// Guardo la bonificacion
  	unset($this->values['devolucion']);
  	
  	$this->updateObject();
  	
  	$bonificacion = $this->getObject();
  	$bonificacion->setIdUsuario( $usuario->getIdUsuario() );
  	
  	$bonificacion->save($con);
  }
  
}
