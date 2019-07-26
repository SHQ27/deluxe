<?php

/**
 * pedidoProductoItem form base class.
 *
 * @method pedidoProductoItem getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepedidoProductoItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido_producto_item' => new sfWidgetFormInputHidden(),
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'id_pedido'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'id_producto_talle'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'), 'add_empty' => false)),
      'id_producto_color'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoColor'), 'add_empty' => false)),
      'cantidad'                => new sfWidgetFormInputText(),
      'precio_lista'            => new sfWidgetFormInputText(),
      'precio_deluxe'           => new sfWidgetFormInputText(),
      'costo'                   => new sfWidgetFormInputText(),
      'origen'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_pedido_producto_item' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pedido_producto_item')), 'empty_value' => $this->getObject()->get('id_pedido_producto_item'), 'required' => false)),
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'id_pedido'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'id_producto_talle'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'))),
      'id_producto_color'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoColor'))),
      'cantidad'                => new sfValidatorInteger(array('required' => false)),
      'precio_lista'            => new sfValidatorNumber(array('required' => false)),
      'precio_deluxe'           => new sfValidatorNumber(array('required' => false)),
      'costo'                   => new sfValidatorNumber(array('required' => false)),
      'origen'                  => new sfValidatorString(array('max_length' => 6, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido_producto_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedidoProductoItem';
  }

}
