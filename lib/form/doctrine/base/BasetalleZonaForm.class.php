<?php

/**
 * talleZona form base class.
 *
 * @method talleZona getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetalleZonaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_talle_zona' => new sfWidgetFormInputHidden(),
      'denominacion'  => new sfWidgetFormInputText(),
      'orden'         => new sfWidgetFormInputText(),
      'descripcion'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_talle_zona' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_talle_zona')), 'empty_value' => $this->getObject()->get('id_talle_zona'), 'required' => false)),
      'denominacion'  => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'orden'         => new sfValidatorInteger(array('required' => false)),
      'descripcion'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('talle_zona[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'talleZona';
  }

}
