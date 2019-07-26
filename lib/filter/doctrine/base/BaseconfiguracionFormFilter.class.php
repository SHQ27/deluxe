<?php

/**
 * configuracion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseconfiguracionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'     => new sfWidgetFormFilterInput(),
      'valor'            => new sfWidgetFormFilterInput(),
      'tipo'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'     => new sfValidatorPass(array('required' => false)),
      'valor'            => new sfValidatorPass(array('required' => false)),
      'tipo'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('configuracion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'configuracion';
  }

  public function getFields()
  {
    return array(
      'id_configuracion' => 'Text',
      'denominacion'     => 'Text',
      'valor'            => 'Text',
      'tipo'             => 'Text',
    );
  }
}
