<?php

/**
 * pedidoBonificacion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepedidoBonificacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_bonificacion'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => true)),
      'id_pedido'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'id_tipo_descuento'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'), 'add_empty' => true)),
      'valor'                  => new sfWidgetFormFilterInput(),
      'monto'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_bonificacion'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('bonificacion'), 'column' => 'id_bonificacion')),
      'id_pedido'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'id_tipo_descuento'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('tipoDescuento'), 'column' => 'id_tipo_descuento')),
      'valor'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pedido_bonificacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedidoBonificacion';
  }

  public function getFields()
  {
    return array(
      'id_pedido_bonificacion' => 'Number',
      'id_bonificacion'        => 'ForeignKey',
      'id_pedido'              => 'ForeignKey',
      'id_tipo_descuento'      => 'ForeignKey',
      'valor'                  => 'Number',
      'monto'                  => 'Number',
    );
  }
}
