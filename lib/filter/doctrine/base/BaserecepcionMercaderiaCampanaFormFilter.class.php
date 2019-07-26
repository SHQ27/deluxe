<?php

/**
 * recepcionMercaderiaCampana filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaserecepcionMercaderiaCampanaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_campana'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => true)),
      'id_producto_item'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'fecha'                           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'cantidad'                        => new sfWidgetFormFilterInput(),
      'observacion'                     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_campana'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('campana'), 'column' => 'id_campana')),
      'id_producto_item'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoItem'), 'column' => 'id_producto_item')),
      'fecha'                           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'cantidad'                        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'observacion'                     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recepcion_mercaderia_campana_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'recepcionMercaderiaCampana';
  }

  public function getFields()
  {
    return array(
      'id_recepcion_mercaderia_campana' => 'Number',
      'id_campana'                      => 'ForeignKey',
      'id_producto_item'                => 'ForeignKey',
      'fecha'                           => 'Date',
      'cantidad'                        => 'Number',
      'observacion'                     => 'Text',
    );
  }
}
