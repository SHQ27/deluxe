<?php

/**
 * campanaUsuario form base class.
 *
 * @method campanaUsuario getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecampanaUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_campana_usuario' => new sfWidgetFormInputHidden(),
      'id_campana'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('campana'), 'add_empty' => false)),
      'id_sf_guard_user'   => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'usuario'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_campana_usuario' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_campana_usuario')), 'empty_value' => $this->getObject()->get('id_campana_usuario'), 'required' => false)),
      'id_campana'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('campana'))),
      'id_sf_guard_user'   => new sfValidatorInteger(array('required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'usuario'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('campana_usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'campanaUsuario';
  }

}
