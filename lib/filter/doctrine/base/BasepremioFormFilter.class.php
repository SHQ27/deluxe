<?php

/**
 * premio filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepremioFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'monto_minimo'     => new sfWidgetFormFilterInput(),
      'valor'            => new sfWidgetFormFilterInput(),
      'dias_vencimiento' => new sfWidgetFormFilterInput(),
      'fecha_desde'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_hasta'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'tipo_premio'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'monto_minimo'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'valor'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dias_vencimiento' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_desde'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'fecha_hasta'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'tipo_premio'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('premio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'premio';
  }

  public function getFields()
  {
    return array(
      'id_premio'        => 'Number',
      'monto_minimo'     => 'Number',
      'valor'            => 'Number',
      'dias_vencimiento' => 'Number',
      'fecha_desde'      => 'Date',
      'fecha_hasta'      => 'Date',
      'tipo_premio'      => 'Text',
    );
  }
}
