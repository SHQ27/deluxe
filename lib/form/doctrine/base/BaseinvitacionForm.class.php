<?php

/**
 * invitacion form base class.
 *
 * @method invitacion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseinvitacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_invitacion'       => new sfWidgetFormInputHidden(),
      'id_usuario'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario_invitados'), 'add_empty' => false)),
      'email_invitado'      => new sfWidgetFormInputText(),
      'hash'                => new sfWidgetFormInputText(),
      'fue_enviada'         => new sfWidgetFormInputText(),
      'fecha'               => new sfWidgetFormDateTime(),
      'id_usuario_invitado' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'id_pedido_realizado' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'bonificacion'        => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_invitacion'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_invitacion')), 'empty_value' => $this->getObject()->get('id_invitacion'), 'required' => false)),
      'id_usuario'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario_invitados'))),
      'email_invitado'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'hash'                => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'fue_enviada'         => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'fecha'               => new sfValidatorDateTime(),
      'id_usuario_invitado' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'required' => false)),
      'id_pedido_realizado' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'required' => false)),
      'bonificacion'        => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invitacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'invitacion';
  }

}
