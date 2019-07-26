<?php

/**
 * eshopTienda form base class.
 *
 * @method eshopTienda getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopTiendaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_tienda' => new sfWidgetFormInputHidden(),
      'id_eshop'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => false)),
      'denominacion'    => new sfWidgetFormInputText(),
      'direccion'       => new sfWidgetFormInputText(),
      'telefono'        => new sfWidgetFormInputText(),
      'latitud'         => new sfWidgetFormInputText(),
      'longitud'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop_tienda' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_tienda')), 'empty_value' => $this->getObject()->get('id_eshop_tienda'), 'required' => false)),
      'id_eshop'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'))),
      'denominacion'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'direccion'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telefono'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'latitud'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'longitud'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_tienda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopTienda';
  }

}
