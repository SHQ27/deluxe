<?php

/**
 * tarjeta form base class.
 *
 * @method tarjeta getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetarjetaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tarjeta'   => new sfWidgetFormInputHidden(),
      'denominacion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_tarjeta'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_tarjeta')), 'empty_value' => $this->getObject()->get('id_tarjeta'), 'required' => false)),
      'denominacion' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tarjeta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tarjeta';
  }

}
