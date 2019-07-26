<?php

/**
 * productoColor form base class.
 *
 * @method productoColor getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoColorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_color' => new sfWidgetFormInputHidden(),
      'denominacion'      => new sfWidgetFormInputText(),
      'id_familia_color'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('familiaColor'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_producto_color' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_color')), 'empty_value' => $this->getObject()->get('id_producto_color'), 'required' => false)),
      'denominacion'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'id_familia_color'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('familiaColor'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_color[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoColor';
  }

}
