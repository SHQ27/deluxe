<?php

/**
 * cupon form base class.
 *
 * @method cupon getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecuponForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_cupon'    => new sfWidgetFormInputHidden(),
      'fecha_desde' => new sfWidgetFormDate(),
      'fecha_hasta' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id_cupon'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_cupon')), 'empty_value' => $this->getObject()->get('id_cupon'), 'required' => false)),
      'fecha_desde' => new sfValidatorDate(array('required' => false)),
      'fecha_hasta' => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cupon[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'cupon';
  }

}
