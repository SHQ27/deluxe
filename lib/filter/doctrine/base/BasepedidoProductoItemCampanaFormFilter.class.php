<?php

/**
 * pedidoProductoItemCampana filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepedidoProductoItemCampanaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido_producto_item'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => true)),
      'id_campana'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => true)),
      'id_marca'                        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_pedido_producto_item'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedidoProductoItem'), 'column' => 'id_pedido_producto_item')),
      'id_campana'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('campana'), 'column' => 'id_campana')),
      'id_marca'                        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('marca'), 'column' => 'id_marca')),
    ));

    $this->widgetSchema->setNameFormat('pedido_producto_item_campana_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedidoProductoItemCampana';
  }

  public function getFields()
  {
    return array(
      'id_pedido_producto_item_campana' => 'Number',
      'id_pedido_producto_item'         => 'ForeignKey',
      'id_campana'                      => 'ForeignKey',
      'id_marca'                        => 'ForeignKey',
    );
  }
}
