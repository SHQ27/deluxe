<?php

/**
 * sessionStorageBackend form base class.
 *
 * @method sessionStorageBackend getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesessionStorageBackendForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_session'   => new sfWidgetFormInputHidden(),
      'session_data' => new sfWidgetFormTextarea(),
      'session_time' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_session'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_session')), 'empty_value' => $this->getObject()->get('id_session'), 'required' => false)),
      'session_data' => new sfValidatorString(),
      'session_time' => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('session_storage_backend[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sessionStorageBackend';
  }

}
