<?php

/**
 * stock filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasestockFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'id_stock_tipo'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('stockTipo'), 'add_empty' => true)),
      'cantidad'                => new sfWidgetFormFilterInput(),
      'origen'                  => new sfWidgetFormFilterInput(),
      'id_pedido_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => true)),
      'observacion'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoItem'), 'column' => 'id_producto_item')),
      'id_stock_tipo'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('stockTipo'), 'column' => 'id_stock_tipo')),
      'cantidad'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'origen'                  => new sfValidatorPass(array('required' => false)),
      'id_pedido_producto_item' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedidoProductoItem'), 'column' => 'id_pedido_producto_item')),
      'observacion'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('stock_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stock';
  }

  public function getFields()
  {
    return array(
      'id_stock'                => 'Number',
      'fecha'                   => 'Date',
      'id_producto_item'        => 'ForeignKey',
      'id_stock_tipo'           => 'ForeignKey',
      'cantidad'                => 'Number',
      'origen'                  => 'Text',
      'id_pedido_producto_item' => 'ForeignKey',
      'observacion'             => 'Text',
    );
  }
}
