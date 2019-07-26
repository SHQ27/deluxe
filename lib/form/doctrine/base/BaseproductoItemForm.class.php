<?php

/**
 * productoItem form base class.
 *
 * @method productoItem getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_item'   => new sfWidgetFormInputHidden(),
      'id_producto'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => false)),
      'id_producto_talle'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'), 'add_empty' => false)),
      'id_producto_color'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoColor'), 'add_empty' => false)),
      'codigo'             => new sfWidgetFormInputText(),
      'stock'              => new sfWidgetFormInputText(),
      'stock_campana'      => new sfWidgetFormInputText(),
      'stock_permanente'   => new sfWidgetFormInputText(),
      'stock_outlet'       => new sfWidgetFormInputText(),
      'stock_refuerzo'     => new sfWidgetFormInputText(),
      'data_mercado_libre' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_producto_item'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_item')), 'empty_value' => $this->getObject()->get('id_producto_item'), 'required' => false)),
      'id_producto'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('producto'))),
      'id_producto_talle'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoTalle'))),
      'id_producto_color'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoColor'))),
      'codigo'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'stock'              => new sfValidatorInteger(array('required' => false)),
      'stock_campana'      => new sfValidatorInteger(array('required' => false)),
      'stock_permanente'   => new sfValidatorInteger(array('required' => false)),
      'stock_outlet'       => new sfValidatorInteger(array('required' => false)),
      'stock_refuerzo'     => new sfValidatorInteger(array('required' => false)),
      'data_mercado_libre' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoItem';
  }

}
