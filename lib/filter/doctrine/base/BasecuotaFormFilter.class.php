<?php

/**
 * cuota filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecuotaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_banco'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('banco'), 'add_empty' => true)),
      'id_tarjeta'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tarjeta'), 'add_empty' => true)),
      'cuotas'        => new sfWidgetFormFilterInput(),
      'multiplicador' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_banco'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('banco'), 'column' => 'id_banco')),
      'id_tarjeta'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('tarjeta'), 'column' => 'id_tarjeta')),
      'cuotas'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'multiplicador' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cuota_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'cuota';
  }

  public function getFields()
  {
    return array(
      'id_cuota'      => 'Number',
      'id_banco'      => 'ForeignKey',
      'id_tarjeta'    => 'ForeignKey',
      'cuotas'        => 'Number',
      'multiplicador' => 'Number',
    );
  }
}
