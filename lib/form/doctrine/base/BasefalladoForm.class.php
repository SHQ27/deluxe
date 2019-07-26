<?php

/**
 * fallado form base class.
 *
 * @method fallado getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefalladoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_fallado'              => new sfWidgetFormInputHidden(),
      'id_pedido_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => false)),
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'descripcion'             => new sfWidgetFormInputText(),
      'recuperado'              => new sfWidgetFormInputCheckbox(),
      'fecha'                   => new sfWidgetFormDateTime(),
      'id_eshop'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_fallado'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_fallado')), 'empty_value' => $this->getObject()->get('id_fallado'), 'required' => false)),
      'id_pedido_producto_item' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'))),
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'descripcion'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'recuperado'              => new sfValidatorBoolean(array('required' => false)),
      'fecha'                   => new sfValidatorDateTime(),
      'id_eshop'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('fallado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'fallado';
  }

}
