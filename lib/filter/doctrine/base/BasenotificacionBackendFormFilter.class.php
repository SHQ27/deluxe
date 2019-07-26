<?php

/**
 * notificacionBackend filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasenotificacionBackendFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'tipo'                    => new sfWidgetFormFilterInput(),
      'response'                => new sfWidgetFormFilterInput(),
      'visto'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha_alta'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'id_usuario'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'tipo'                    => new sfValidatorPass(array('required' => false)),
      'response'                => new sfValidatorPass(array('required' => false)),
      'visto'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha_alta'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_usuario'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('notificacion_backend_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'notificacionBackend';
  }

  public function getFields()
  {
    return array(
      'id_notificacion_backend' => 'Number',
      'tipo'                    => 'Text',
      'response'                => 'Text',
      'visto'                   => 'Boolean',
      'fecha_alta'              => 'Date',
      'id_usuario'              => 'Number',
    );
  }
}
