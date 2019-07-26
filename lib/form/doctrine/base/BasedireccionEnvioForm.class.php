<?php

/**
 * direccionEnvio form base class.
 *
 * @method direccionEnvio getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedireccionEnvioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_direccion_envio' => new sfWidgetFormInputHidden(),
      'id_usuario'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'id_provincia'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => false)),
      'localidad'          => new sfWidgetFormInputText(),
      'calle'              => new sfWidgetFormInputText(),
      'numero'             => new sfWidgetFormInputText(),
      'piso'               => new sfWidgetFormInputText(),
      'depto'              => new sfWidgetFormInputText(),
      'codigo_postal'      => new sfWidgetFormInputText(),
      'horario'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_direccion_envio' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_direccion_envio')), 'empty_value' => $this->getObject()->get('id_direccion_envio'), 'required' => false)),
      'id_usuario'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'id_provincia'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'))),
      'localidad'          => new sfValidatorString(array('max_length' => 50)),
      'calle'              => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'numero'             => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'piso'               => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'depto'              => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'codigo_postal'      => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'horario'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('direccion_envio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'direccionEnvio';
  }

}
