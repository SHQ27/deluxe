<?php

/**
 * session form base class.
 *
 * @method session getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesessionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_session'          => new sfWidgetFormInputHidden(),
      'fecha_ultima_accion' => new sfWidgetFormDateTime(),
      'id_usuario'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_session'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_session')), 'empty_value' => $this->getObject()->get('id_session'), 'required' => false)),
      'fecha_ultima_accion' => new sfValidatorDateTime(),
      'id_usuario'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'session';
  }

}
