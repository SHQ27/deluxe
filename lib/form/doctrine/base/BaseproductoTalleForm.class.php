<?php

/**
 * productoTalle form base class.
 *
 * @method productoTalle getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoTalleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_talle' => new sfWidgetFormInputHidden(),
      'denominacion'      => new sfWidgetFormInputText(),
      'orden'             => new sfWidgetFormInputText(),
      'id_familia_talle'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('familiaTalle'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_producto_talle' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_talle')), 'empty_value' => $this->getObject()->get('id_producto_talle'), 'required' => false)),
      'denominacion'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'orden'             => new sfValidatorInteger(array('required' => false)),
      'id_familia_talle'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('familiaTalle'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_talle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoTalle';
  }

}
