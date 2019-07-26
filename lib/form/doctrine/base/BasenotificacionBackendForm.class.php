<?php

/**
 * notificacionBackend form base class.
 *
 * @method notificacionBackend getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasenotificacionBackendForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_notificacion_backend' => new sfWidgetFormInputHidden(),
      'tipo'                    => new sfWidgetFormInputText(),
      'response'                => new sfWidgetFormTextarea(),
      'visto'                   => new sfWidgetFormInputCheckbox(),
      'fecha_alta'              => new sfWidgetFormDateTime(),
      'id_usuario'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_notificacion_backend' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_notificacion_backend')), 'empty_value' => $this->getObject()->get('id_notificacion_backend'), 'required' => false)),
      'tipo'                    => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'response'                => new sfValidatorString(array('required' => false)),
      'visto'                   => new sfValidatorBoolean(array('required' => false)),
      'fecha_alta'              => new sfValidatorDateTime(),
      'id_usuario'              => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('notificacion_backend[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'notificacionBackend';
  }

}
