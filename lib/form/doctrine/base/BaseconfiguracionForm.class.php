<?php

/**
 * configuracion form base class.
 *
 * @method configuracion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseconfiguracionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_configuracion' => new sfWidgetFormInputHidden(),
      'denominacion'     => new sfWidgetFormInputText(),
      'valor'            => new sfWidgetFormTextarea(),
      'tipo'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_configuracion' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_configuracion')), 'empty_value' => $this->getObject()->get('id_configuracion'), 'required' => false)),
      'denominacion'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'valor'            => new sfValidatorString(array('required' => false)),
      'tipo'             => new sfValidatorString(array('max_length' => 5, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('configuracion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'configuracion';
  }

}
