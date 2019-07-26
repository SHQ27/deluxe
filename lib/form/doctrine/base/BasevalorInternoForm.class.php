<?php

/**
 * valorInterno form base class.
 *
 * @method valorInterno getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasevalorInternoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_valor_interno' => new sfWidgetFormInputHidden(),
      'denominacion'     => new sfWidgetFormTextarea(),
      'valor'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_valor_interno' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_valor_interno')), 'empty_value' => $this->getObject()->get('id_valor_interno'), 'required' => false)),
      'denominacion'     => new sfValidatorString(array('required' => false)),
      'valor'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('valor_interno[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'valorInterno';
  }

}
