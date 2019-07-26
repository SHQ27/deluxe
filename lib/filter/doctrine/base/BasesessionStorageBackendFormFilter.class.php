<?php

/**
 * sessionStorageBackend filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesessionStorageBackendFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'session_data' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'session_time' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'session_data' => new sfValidatorPass(array('required' => false)),
      'session_time' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('session_storage_backend_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sessionStorageBackend';
  }

  public function getFields()
  {
    return array(
      'id_session'   => 'Text',
      'session_data' => 'Text',
      'session_time' => 'Number',
    );
  }
}
