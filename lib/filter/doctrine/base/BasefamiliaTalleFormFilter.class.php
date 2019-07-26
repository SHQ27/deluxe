<?php

/**
 * familiaTalle filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefamiliaTalleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'denominacion'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('familia_talle_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'familiaTalle';
  }

  public function getFields()
  {
    return array(
      'id_familia_talle' => 'Number',
      'denominacion'     => 'Text',
    );
  }
}
