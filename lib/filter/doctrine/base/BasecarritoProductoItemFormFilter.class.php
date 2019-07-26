<?php

/**
 * carritoProductoItem filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasecarritoProductoItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_item'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => true)),
      'id_session'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => true)),
      'cantidad'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'id_producto_item'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('productoItem'), 'column' => 'id_producto_item')),
      'id_session'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('session'), 'column' => 'id_session')),
      'cantidad'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('carrito_producto_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoProductoItem';
  }

  public function getFields()
  {
    return array(
      'id_carrito_producto_item' => 'Number',
      'id_producto_item'         => 'ForeignKey',
      'id_session'               => 'ForeignKey',
      'cantidad'                 => 'Number',
    );
  }
}
