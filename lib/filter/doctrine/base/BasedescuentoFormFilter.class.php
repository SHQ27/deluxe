<?php

/**
 * descuento filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasedescuentoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo'            => new sfWidgetFormFilterInput(),
      'id_tipo_descuento' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'), 'add_empty' => true)),
      'valor'             => new sfWidgetFormFilterInput(),
      'vigencia_desde'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'vigencia_hasta'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'total'             => new sfWidgetFormFilterInput(),
      'utilizados'        => new sfWidgetFormFilterInput(),
      'es_interno'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'id_eshop'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'recibe_premio'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'codigo'            => new sfValidatorPass(array('required' => false)),
      'id_tipo_descuento' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('tipoDescuento'), 'column' => 'id_tipo_descuento')),
      'valor'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'vigencia_desde'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'vigencia_hasta'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'total'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'utilizados'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'es_interno'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'id_eshop'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'recibe_premio'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('descuento_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'descuento';
  }

  public function getFields()
  {
    return array(
      'id_descuento'      => 'Number',
      'codigo'            => 'Text',
      'id_tipo_descuento' => 'ForeignKey',
      'valor'             => 'Number',
      'vigencia_desde'    => 'Date',
      'vigencia_hasta'    => 'Date',
      'total'             => 'Number',
      'utilizados'        => 'Number',
      'es_interno'        => 'Boolean',
      'id_eshop'          => 'ForeignKey',
      'recibe_premio'     => 'Boolean',
    );
  }
}
