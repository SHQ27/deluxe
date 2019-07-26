<?php

/**
 * productoCategoriaEshop form base class.
 *
 * @method productoCategoriaEshop getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoCategoriaEshopForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_categoria' => new sfWidgetFormInputHidden(),
      'id_eshop'              => new sfWidgetFormInputHidden(),
      'tipo_prenda'           => new sfWidgetFormInputText(),
      'orden'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto_categoria' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_categoria')), 'empty_value' => $this->getObject()->get('id_producto_categoria'), 'required' => false)),
      'id_eshop'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop')), 'empty_value' => $this->getObject()->get('id_eshop'), 'required' => false)),
      'tipo_prenda'           => new sfValidatorPass(),
      'orden'                 => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('producto_categoria_eshop[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoCategoriaEshop';
  }

}
