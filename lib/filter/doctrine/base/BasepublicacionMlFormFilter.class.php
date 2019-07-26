<?php

/**
 * publicacionMl filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepublicacionMlFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha_inicio'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_fin'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'item_id'            => new sfWidgetFormFilterInput(),
      'data_mercado_libre' => new sfWidgetFormFilterInput(),
      'status_ml'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha_inicio'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_fin'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'item_id'            => new sfValidatorPass(array('required' => false)),
      'data_mercado_libre' => new sfValidatorPass(array('required' => false)),
      'status_ml'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('publicacion_ml_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'publicacionMl';
  }

  public function getFields()
  {
    return array(
      'id_producto'        => 'Number',
      'fecha_inicio'       => 'Date',
      'fecha_fin'          => 'Date',
      'item_id'            => 'Text',
      'data_mercado_libre' => 'Text',
      'status_ml'          => 'Text',
    );
  }
}
