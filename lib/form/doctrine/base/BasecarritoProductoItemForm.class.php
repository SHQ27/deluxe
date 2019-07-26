<?php

/**
 * carritoProductoItem form base class.
 *
 * @method carritoProductoItem getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecarritoProductoItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_carrito_producto_item' => new sfWidgetFormInputHidden(),
      'id_producto_item'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'id_session'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => false)),
      'cantidad'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_carrito_producto_item' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_carrito_producto_item')), 'empty_value' => $this->getObject()->get('id_carrito_producto_item'), 'required' => false)),
      'id_producto_item'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'id_session'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('session'))),
      'cantidad'                 => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('carrito_producto_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoProductoItem';
  }

}
