<?php

/**
 * devolucionProductoItem filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasedevolucionProductoItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_devolucion'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('devolucion'), 'add_empty' => true)),
      'id_pedido_producto_item'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => true)),
      'id_producto_item'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'cantidad'                    => new sfWidgetFormFilterInput(),
      'cantidad_stock'              => new sfWidgetFormFilterInput(),
      'cantidad_fallados'           => new sfWidgetFormFilterInput(),
      'cantidad_devueltos_marcas'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_devolucion'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('devolucion'), 'column' => 'id_devolucion')),
      'id_pedido_producto_item'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedidoProductoItem'), 'column' => 'id_pedido_producto_item')),
      'id_producto_item'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoItem'), 'column' => 'id_producto_item')),
      'cantidad'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_stock'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_fallados'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_devueltos_marcas'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('devolucion_producto_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devolucionProductoItem';
  }

  public function getFields()
  {
    return array(
      'id_devolucion_producto_item' => 'Number',
      'id_devolucion'               => 'ForeignKey',
      'id_pedido_producto_item'     => 'ForeignKey',
      'id_producto_item'            => 'ForeignKey',
      'cantidad'                    => 'Number',
      'cantidad_stock'              => 'Number',
      'cantidad_fallados'           => 'Number',
      'cantidad_devueltos_marcas'   => 'Number',
    );
  }
}
