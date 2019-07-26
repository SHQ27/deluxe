<?php

/**
 * stockTipo filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasestockTipoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'  => new sfWidgetFormFilterInput(),
      'es_de_sistema' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'denominacion'  => new sfValidatorPass(array('required' => false)),
      'es_de_sistema' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('stock_tipo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stockTipo';
  }

  public function getFields()
  {
    return array(
      'id_stock_tipo' => 'Number',
      'denominacion'  => 'Text',
      'es_de_sistema' => 'Boolean',
    );
  }
}
