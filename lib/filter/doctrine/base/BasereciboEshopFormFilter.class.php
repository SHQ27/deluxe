<?php

/**
 * reciboEshop filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasereciboEshopFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tipo'            => new sfWidgetFormFilterInput(),
      'importe'         => new sfWidgetFormFilterInput(),
      'id_eshop'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'importe'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'id_eshop'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('recibo_eshop_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reciboEshop';
  }

  public function getFields()
  {
    return array(
      'id_recibo_eshop' => 'Number',
      'fecha'           => 'Date',
      'tipo'            => 'Text',
      'importe'         => 'Number',
      'id_eshop'        => 'ForeignKey',
    );
  }
}
