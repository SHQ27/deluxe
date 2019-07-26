<?php

/**
 * promoPago form base class.
 *
 * @method promoPago getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepromoPagoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_promo_pago'  => new sfWidgetFormInputHidden(),
      'denominacion'   => new sfWidgetFormInputText(),
      'proveedor'      => new sfWidgetFormInputText(),
      'id_forma_pago'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => false)),
      'vigencia_desde' => new sfWidgetFormDateTime(),
      'vigencia_hasta' => new sfWidgetFormDateTime(),
      'dias_semana'    => new sfWidgetFormInputText(),
      'cuotas'         => new sfWidgetFormInputText(),
      'params'         => new sfWidgetFormTextarea(),
      'id_descuento'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => true)),
      'orden'          => new sfWidgetFormInputText(),
      'activo'         => new sfWidgetFormInputCheckbox(),
      'id_eshop'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_promo_pago'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_promo_pago')), 'empty_value' => $this->getObject()->get('id_promo_pago'), 'required' => false)),
      'denominacion'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'proveedor'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_forma_pago'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'))),
      'vigencia_desde' => new sfValidatorDateTime(array('required' => false)),
      'vigencia_hasta' => new sfValidatorDateTime(array('required' => false)),
      'dias_semana'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cuotas'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'params'         => new sfValidatorString(array('required' => false)),
      'id_descuento'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'required' => false)),
      'orden'          => new sfValidatorInteger(array('required' => false)),
      'activo'         => new sfValidatorBoolean(array('required' => false)),
      'id_eshop'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('promo_pago[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'promoPago';
  }

}
