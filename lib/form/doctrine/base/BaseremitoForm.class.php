<?php

/**
 * remito form base class.
 *
 * @method remito getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseremitoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_remito' => new sfWidgetFormInputHidden(),
      'id_envio'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_remito' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_remito')), 'empty_value' => $this->getObject()->get('id_remito'), 'required' => false)),
      'id_envio'  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('remito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'remito';
  }

}
