<?php

/**
 * cuponProducto form base class.
 *
 * @method cuponProducto getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecuponProductoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_cupon'    => new sfWidgetFormInputHidden(),
      'id_producto' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_cupon'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_cupon')), 'empty_value' => $this->getObject()->get('id_cupon'), 'required' => false)),
      'id_producto' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto')), 'empty_value' => $this->getObject()->get('id_producto'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cupon_producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'cuponProducto';
  }

}
