<?php

/**
 * ncredito form base class.
 *
 * @method ncredito getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasencreditoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_ncredito'     => new sfWidgetFormInputHidden(),
      'procesada'       => new sfWidgetFormInputCheckbox(),
      'CAE'             => new sfWidgetFormInputText(),
      'CAE_vencimiento' => new sfWidgetFormInputText(),
      'comprobante'     => new sfWidgetFormInputText(),
      'resultado'       => new sfWidgetFormInputText(),
      'entorno'         => new sfWidgetFormInputText(),
      'importe'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_ncredito'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_ncredito')), 'empty_value' => $this->getObject()->get('id_ncredito'), 'required' => false)),
      'procesada'       => new sfValidatorBoolean(array('required' => false)),
      'CAE'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CAE_vencimiento' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'comprobante'     => new sfValidatorInteger(array('required' => false)),
      'resultado'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'entorno'         => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'importe'         => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ncredito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ncredito';
  }

}
