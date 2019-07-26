<?php

/**
 * comercial form base class.
 *
 * @method comercial getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecomercialForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_comercial' => new sfWidgetFormInputHidden(),
      'nombre'       => new sfWidgetFormInputText(),
      'apellido'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_comercial' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_comercial')), 'empty_value' => $this->getObject()->get('id_comercial'), 'required' => false)),
      'nombre'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'apellido'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('comercial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'comercial';
  }

}
