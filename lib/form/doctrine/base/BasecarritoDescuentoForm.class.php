<?php

/**
 * carritoDescuento form base class.
 *
 * @method carritoDescuento getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecarritoDescuentoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_carrito_descuento' => new sfWidgetFormInputHidden(),
      'id_descuento'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => false)),
      'id_session'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => false)),
      'info_adicional'       => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_carrito_descuento' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_carrito_descuento')), 'empty_value' => $this->getObject()->get('id_carrito_descuento'), 'required' => false)),
      'id_descuento'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'))),
      'id_session'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('session'))),
      'info_adicional'       => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('carrito_descuento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoDescuento';
  }

}
