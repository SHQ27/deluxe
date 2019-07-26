<?php

/**
 * sourceInversion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesourceInversionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_source'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('source'), 'add_empty' => true)),
      'valor'               => new sfWidgetFormFilterInput(),
      'fecha'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'id_eshop'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_source'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('source'), 'column' => 'id_source')),
      'valor'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'fecha'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'id_eshop'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('source_inversion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sourceInversion';
  }

  public function getFields()
  {
    return array(
      'id_source_inversion' => 'Number',
      'id_source'           => 'ForeignKey',
      'valor'               => 'Number',
      'fecha'               => 'Date',
      'id_eshop'            => 'ForeignKey',
    );
  }
}
