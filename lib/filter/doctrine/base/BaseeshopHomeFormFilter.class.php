<?php

/**
 * eshopHome filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseeshopHomeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'denominacion'   => new sfWidgetFormFilterInput(),
      'tipo'           => new sfWidgetFormFilterInput(),
      'vigencia_desde' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'vigencia_hasta' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'orden'          => new sfWidgetFormFilterInput(),
      'activo'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'texto'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_eshop'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'denominacion'   => new sfValidatorPass(array('required' => false)),
      'tipo'           => new sfValidatorPass(array('required' => false)),
      'vigencia_desde' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'vigencia_hasta' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'orden'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activo'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'texto'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_home_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopHome';
  }

  public function getFields()
  {
    return array(
      'id_eshop_home'  => 'Number',
      'id_eshop'       => 'ForeignKey',
      'denominacion'   => 'Text',
      'tipo'           => 'Text',
      'vigencia_desde' => 'Date',
      'vigencia_hasta' => 'Date',
      'orden'          => 'Number',
      'activo'         => 'Boolean',
      'texto'          => 'Text',
    );
  }
}
