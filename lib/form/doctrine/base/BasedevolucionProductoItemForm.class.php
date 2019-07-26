<?php

/**
 * devolucionProductoItem form base class.
 *
 * @method devolucionProductoItem getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedevolucionProductoItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_devolucion_producto_item' => new sfWidgetFormInputHidden(),
      'id_devolucion'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('devolucion'), 'add_empty' => false)),
      'id_pedido_producto_item'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => false)),
      'id_producto_item'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'cantidad'                    => new sfWidgetFormInputText(),
      'cantidad_stock'              => new sfWidgetFormInputText(),
      'cantidad_fallados'           => new sfWidgetFormInputText(),
      'cantidad_devueltos_marcas'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_devolucion_producto_item' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_devolucion_producto_item')), 'empty_value' => $this->getObject()->get('id_devolucion_producto_item'), 'required' => false)),
      'id_devolucion'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('devolucion'))),
      'id_pedido_producto_item'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'))),
      'id_producto_item'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'required' => false)),
      'cantidad'                    => new sfValidatorInteger(array('required' => false)),
      'cantidad_stock'              => new sfValidatorInteger(array('required' => false)),
      'cantidad_fallados'           => new sfValidatorInteger(array('required' => false)),
      'cantidad_devueltos_marcas'   => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('devolucion_producto_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devolucionProductoItem';
  }

}
