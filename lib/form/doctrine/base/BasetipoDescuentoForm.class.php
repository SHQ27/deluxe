<?php

/**
 * tipoDescuento form base class.
 *
 * @method tipoDescuento getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetipoDescuentoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tipo_descuento' => new sfWidgetFormInputHidden(),
      'denominacion'      => new sfWidgetFormInputText(),
      'formato'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_tipo_descuento' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_tipo_descuento')), 'empty_value' => $this->getObject()->get('id_tipo_descuento'), 'required' => false)),
      'denominacion'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'formato'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipo_descuento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tipoDescuento';
  }

}
