<?php

/**
 * productoLog filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoLogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => true)),
      'observacion'     => new sfWidgetFormFilterInput(),
      'fecha'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_producto'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('producto'), 'column' => 'id_producto')),
      'observacion'     => new sfValidatorPass(array('required' => false)),
      'fecha'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('producto_log_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoLog';
  }

  public function getFields()
  {
    return array(
      'id_producto_log' => 'Number',
      'id_producto'     => 'ForeignKey',
      'observacion'     => 'Text',
      'fecha'           => 'Date',
    );
  }
}
