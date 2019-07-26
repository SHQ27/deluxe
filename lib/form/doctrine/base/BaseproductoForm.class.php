<?php

/**
 * producto form base class.
 *
 * @method producto getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto'           => new sfWidgetFormInputHidden(),
      'denominacion'          => new sfWidgetFormInputText(),
      'descripcion'           => new sfWidgetFormTextarea(),
      'info_adicional'        => new sfWidgetFormTextarea(),
      'id_marca'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => false)),
      'id_producto_categoria' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoCategoria'), 'add_empty' => false)),
      'fecha_modificacion'    => new sfWidgetFormDateTime(),
      'precio_lista'          => new sfWidgetFormInputText(),
      'mostrar_precio_lista'  => new sfWidgetFormInputCheckbox(),
      'precio_normal'         => new sfWidgetFormInputText(),
      'precio_outlet'         => new sfWidgetFormInputText(),
      'precio_deluxe'         => new sfWidgetFormInputText(),
      'costo'                 => new sfWidgetFormInputText(),
      'peso'                  => new sfWidgetFormInputText(),
      'destacar'              => new sfWidgetFormInputText(),
      'vendidos'              => new sfWidgetFormInputText(),
      'visitas'               => new sfWidgetFormInputText(),
      'es_outlet'             => new sfWidgetFormInputCheckbox(),
      'observacion'           => new sfWidgetFormTextarea(),
      'activo'                => new sfWidgetFormInputCheckbox(),
      'id_talle_set'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('talleSet'), 'add_empty' => true)),
      'id_producto_sticker'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoSticker'), 'add_empty' => true)),
      'id_categoria_ml'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('categoriaMl'), 'add_empty' => true)),
      'id_eshop'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'orden_eshop'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto')), 'empty_value' => $this->getObject()->get('id_producto'), 'required' => false)),
      'denominacion'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'descripcion'           => new sfValidatorString(array('required' => false)),
      'info_adicional'        => new sfValidatorString(array('required' => false)),
      'id_marca'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('marca'))),
      'id_producto_categoria' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoCategoria'))),
      'fecha_modificacion'    => new sfValidatorDateTime(array('required' => false)),
      'precio_lista'          => new sfValidatorNumber(array('required' => false)),
      'mostrar_precio_lista'  => new sfValidatorBoolean(array('required' => false)),
      'precio_normal'         => new sfValidatorNumber(array('required' => false)),
      'precio_outlet'         => new sfValidatorNumber(array('required' => false)),
      'precio_deluxe'         => new sfValidatorNumber(array('required' => false)),
      'costo'                 => new sfValidatorNumber(array('required' => false)),
      'peso'                  => new sfValidatorNumber(array('required' => false)),
      'destacar'              => new sfValidatorInteger(array('required' => false)),
      'vendidos'              => new sfValidatorInteger(array('required' => false)),
      'visitas'               => new sfValidatorInteger(array('required' => false)),
      'es_outlet'             => new sfValidatorBoolean(array('required' => false)),
      'observacion'           => new sfValidatorString(array('required' => false)),
      'activo'                => new sfValidatorBoolean(array('required' => false)),
      'id_talle_set'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('talleSet'), 'required' => false)),
      'id_producto_sticker'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoSticker'), 'required' => false)),
      'id_categoria_ml'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('categoriaMl'), 'required' => false)),
      'id_eshop'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
      'orden_eshop'           => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'producto';
  }

}
