<?php

/**
 * productoTag form base class.
 *
 * @method productoTag getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoTagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto' => new sfWidgetFormInputHidden(),
      'id_tag'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_producto' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto')), 'empty_value' => $this->getObject()->get('id_producto'), 'required' => false)),
      'id_tag'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_tag')), 'empty_value' => $this->getObject()->get('id_tag'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoTag';
  }

}
