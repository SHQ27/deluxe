<?php

/**
 * provincia filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseprovinciaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'           => new sfWidgetFormFilterInput(),
      'id_mercado_libre' => new sfWidgetFormFilterInput(),
      'iso'              => new sfWidgetFormFilterInput(),
      'activa'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'nombre'           => new sfValidatorPass(array('required' => false)),
      'id_mercado_libre' => new sfValidatorPass(array('required' => false)),
      'iso'              => new sfValidatorPass(array('required' => false)),
      'activa'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('provincia_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'provincia';
  }

  public function getFields()
  {
    return array(
      'id_provincia'     => 'Number',
      'nombre'           => 'Text',
      'id_mercado_libre' => 'Text',
      'iso'              => 'Text',
      'activa'           => 'Boolean',
    );
  }
}
