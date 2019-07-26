<?php

/**
 * provincia form base class.
 *
 * @method provincia getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseprovinciaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_provincia'     => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInputText(),
      'id_mercado_libre' => new sfWidgetFormInputText(),
      'iso'              => new sfWidgetFormInputText(),
      'activa'           => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_provincia'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_provincia')), 'empty_value' => $this->getObject()->get('id_provincia'), 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_mercado_libre' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'iso'              => new sfValidatorPass(array('required' => false)),
      'activa'           => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('provincia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'provincia';
  }

}
