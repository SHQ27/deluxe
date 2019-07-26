<?php

/**
 * pedidoProductoItemCampana form base class.
 *
 * @method pedidoProductoItemCampana getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepedidoProductoItemCampanaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido_producto_item_campana' => new sfWidgetFormInputHidden(),
      'id_pedido_producto_item'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => false)),
      'id_campana'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => false)),
      'id_marca'                        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_pedido_producto_item_campana' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pedido_producto_item_campana')), 'empty_value' => $this->getObject()->get('id_pedido_producto_item_campana'), 'required' => false)),
      'id_pedido_producto_item'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'))),
      'id_campana'                      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('campana'))),
      'id_marca'                        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido_producto_item_campana[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedidoProductoItemCampana';
  }

}
