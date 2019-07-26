<?php

/**
 * cuota form base class.
 *
 * @method cuota getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecuotaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_cuota'      => new sfWidgetFormInputHidden(),
      'id_banco'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('banco'), 'add_empty' => false)),
      'id_tarjeta'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tarjeta'), 'add_empty' => false)),
      'cuotas'        => new sfWidgetFormInputText(),
      'multiplicador' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_cuota'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_cuota')), 'empty_value' => $this->getObject()->get('id_cuota'), 'required' => false)),
      'id_banco'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('banco'))),
      'id_tarjeta'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('tarjeta'))),
      'cuotas'        => new sfValidatorInteger(array('required' => false)),
      'multiplicador' => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cuota[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'cuota';
  }

}
