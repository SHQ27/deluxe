<?php

/**
 * stock form base class.
 *
 * @method stock getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasestockForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_stock'                => new sfWidgetFormInputHidden(),
      'fecha'                   => new sfWidgetFormDateTime(),
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'id_stock_tipo'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('stockTipo'), 'add_empty' => true)),
      'cantidad'                => new sfWidgetFormInputText(),
      'origen'                  => new sfWidgetFormInputText(),
      'id_pedido_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => true)),
      'observacion'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_stock'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_stock')), 'empty_value' => $this->getObject()->get('id_stock'), 'required' => false)),
      'fecha'                   => new sfValidatorDateTime(),
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'id_stock_tipo'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('stockTipo'), 'required' => false)),
      'cantidad'                => new sfValidatorInteger(array('required' => false)),
      'origen'                  => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'id_pedido_producto_item' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'required' => false)),
      'observacion'             => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('stock[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stock';
  }

}
