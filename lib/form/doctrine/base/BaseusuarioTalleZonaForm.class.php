<?php

/**
 * usuarioTalleZona form base class.
 *
 * @method usuarioTalleZona getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseusuarioTalleZonaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_talle_zona' => new sfWidgetFormInputHidden(),
      'id_usuario'    => new sfWidgetFormInputHidden(),
      'medida'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_talle_zona' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_talle_zona')), 'empty_value' => $this->getObject()->get('id_talle_zona'), 'required' => false)),
      'id_usuario'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_usuario')), 'empty_value' => $this->getObject()->get('id_usuario'), 'required' => false)),
      'medida'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_talle_zona[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuarioTalleZona';
  }

}
