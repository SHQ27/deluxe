<?php

/**
 * devueltoMarca form base class.
 *
 * @method devueltoMarca getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedevueltoMarcaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_devuelto_marca'       => new sfWidgetFormInputHidden(),
      'id_pedido_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'), 'add_empty' => false)),
      'id_producto_item'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'devuelto'                => new sfWidgetFormInputCheckbox(),
      'fecha'                   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_devuelto_marca'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_devuelto_marca')), 'empty_value' => $this->getObject()->get('id_devuelto_marca'), 'required' => false)),
      'id_pedido_producto_item' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedidoProductoItem'))),
      'id_producto_item'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'devuelto'                => new sfValidatorBoolean(array('required' => false)),
      'fecha'                   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('devuelto_marca[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devueltoMarca';
  }

}
