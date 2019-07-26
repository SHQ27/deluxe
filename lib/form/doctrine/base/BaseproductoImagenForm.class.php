<?php

/**
 * productoImagen form base class.
 *
 * @method productoImagen getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoImagenForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_imagen' => new sfWidgetFormInputHidden(),
      'id_producto'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => false)),
      'orden'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto_imagen' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_imagen')), 'empty_value' => $this->getObject()->get('id_producto_imagen'), 'required' => false)),
      'id_producto'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('producto'))),
      'orden'              => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_imagen[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoImagen';
  }

}
