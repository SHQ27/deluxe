<?php

/**
 * formaPago form base class.
 *
 * @method formaPago getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseformaPagoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_forma_pago' => new sfWidgetFormInputHidden(),
      'denominacion'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_forma_pago' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_forma_pago')), 'empty_value' => $this->getObject()->get('id_forma_pago'), 'required' => false)),
      'denominacion'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('forma_pago[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'formaPago';
  }

}
