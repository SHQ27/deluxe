<?php

/**
 * productoLog form base class.
 *
 * @method productoLog getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto_log' => new sfWidgetFormInputHidden(),
      'id_producto'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('producto'), 'add_empty' => false)),
      'observacion'     => new sfWidgetFormInputText(),
      'fecha'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_producto_log' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto_log')), 'empty_value' => $this->getObject()->get('id_producto_log'), 'required' => false)),
      'id_producto'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('producto'))),
      'observacion'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('producto_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoLog';
  }

}
