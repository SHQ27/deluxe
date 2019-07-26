<?php

/**
 * fallado filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasefalladoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => true)),
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'descripcion'             => new sfWidgetFormFilterInput(),
      'recuperado'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'id_eshop'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_pedido_producto_item' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedidoProductoItem'), 'column' => 'id_pedido_producto_item')),
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoItem'), 'column' => 'id_producto_item')),
      'descripcion'             => new sfValidatorPass(array('required' => false)),
      'recuperado'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_eshop'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('fallado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'fallado';
  }

  public function getFields()
  {
    return array(
      'id_fallado'              => 'Number',
      'id_pedido_producto_item' => 'ForeignKey',
      'id_producto_item'        => 'ForeignKey',
      'descripcion'             => 'Text',
      'recuperado'              => 'Boolean',
      'fecha'                   => 'Date',
      'id_eshop'                => 'ForeignKey',
    );
  }
}
