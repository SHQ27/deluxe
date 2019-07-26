<?php

/**
 * productoItem filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseproductoItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => true)),
      'id_producto_talle'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'), 'add_empty' => true)),
      'id_producto_color'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoColor'), 'add_empty' => true)),
      'codigo'             => new sfWidgetFormFilterInput(),
      'stock'              => new sfWidgetFormFilterInput(),
      'stock_campana'      => new sfWidgetFormFilterInput(),
      'stock_permanente'   => new sfWidgetFormFilterInput(),
      'stock_outlet'       => new sfWidgetFormFilterInput(),
      'stock_refuerzo'     => new sfWidgetFormFilterInput(),
      'data_mercado_libre' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_producto'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('producto'), 'column' => 'id_producto')),
      'id_producto_talle'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoTalle'), 'column' => 'id_producto_talle')),
      'id_producto_color'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoColor'), 'column' => 'id_producto_color')),
      'codigo'             => new sfValidatorPass(array('required' => false)),
      'stock'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_campana'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_permanente'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_outlet'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'stock_refuerzo'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'data_mercado_libre' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoItem';
  }

  public function getFields()
  {
    return array(
      'id_producto_item'   => 'Number',
      'id_producto'        => 'ForeignKey',
      'id_producto_talle'  => 'ForeignKey',
      'id_producto_color'  => 'ForeignKey',
      'codigo'             => 'Text',
      'stock'              => 'Number',
      'stock_campana'      => 'Number',
      'stock_permanente'   => 'Number',
      'stock_outlet'       => 'Number',
      'stock_refuerzo'     => 'Number',
      'data_mercado_libre' => 'Text',
    );
  }
}
