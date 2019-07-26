<?php

/**
 * pedidoProductoItem filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepedidoProductoItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'id_pedido'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'id_producto_talle'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'), 'add_empty' => true)),
      'id_producto_color'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoColor'), 'add_empty' => true)),
      'cantidad'                => new sfWidgetFormFilterInput(),
      'precio_lista'            => new sfWidgetFormFilterInput(),
      'precio_deluxe'           => new sfWidgetFormFilterInput(),
      'costo'                   => new sfWidgetFormFilterInput(),
      'origen'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoItem'), 'column' => 'id_producto_item')),
      'id_pedido'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'id_producto_talle'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoTalle'), 'column' => 'id_producto_talle')),
      'id_producto_color'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoColor'), 'column' => 'id_producto_color')),
      'cantidad'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'precio_lista'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'precio_deluxe'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'origen'                  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido_producto_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedidoProductoItem';
  }

  public function getFields()
  {
    return array(
      'id_pedido_producto_item' => 'Number',
      'id_producto_item'        => 'ForeignKey',
      'id_pedido'               => 'ForeignKey',
      'id_producto_talle'       => 'ForeignKey',
      'id_producto_color'       => 'ForeignKey',
      'cantidad'                => 'Number',
      'precio_lista'            => 'Number',
      'precio_deluxe'           => 'Number',
      'costo'                   => 'Number',
      'origen'                  => 'Text',
    );
  }
}
