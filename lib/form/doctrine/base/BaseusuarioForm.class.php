<?php

/**
 * usuario form base class.
 *
 * @method usuario getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseusuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_usuario'         => new sfWidgetFormInputHidden(),
      'nombre'             => new sfWidgetFormInputText(),
      'apellido'           => new sfWidgetFormInputText(),
      'sexo'               => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'password'           => new sfWidgetFormInputText(),
      'telefono'           => new sfWidgetFormInputText(),
      'celular'            => new sfWidgetFormInputText(),
      'fecha_nacimiento'   => new sfWidgetFormDate(),
      'tipo_documento'     => new sfWidgetFormInputText(),
      'documento'          => new sfWidgetFormInputText(),
      'activo'             => new sfWidgetFormInputCheckbox(),
      'fecha_alta'         => new sfWidgetFormDateTime(),
      'fecha_confirmacion' => new sfWidgetFormInputText(),
      'fecha_baja'         => new sfWidgetFormInputText(),
      'fid'                => new sfWidgetFormInputText(),
      'dias_devolucion'    => new sfWidgetFormInputText(),
      'source'             => new sfWidgetFormInputText(),
      'fecha_source'       => new sfWidgetFormDate(),
      'utm_campaign'       => new sfWidgetFormInputText(),
      'utm_term'           => new sfWidgetFormInputText(),
      'id_eshop'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_usuario'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_usuario')), 'empty_value' => $this->getObject()->get('id_usuario'), 'required' => false)),
      'nombre'             => new sfValidatorString(array('max_length' => 30)),
      'apellido'           => new sfValidatorString(array('max_length' => 30)),
      'sexo'               => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'password'           => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'telefono'           => new sfValidatorString(array('max_length' => 30)),
      'celular'            => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'fecha_nacimiento'   => new sfValidatorDate(array('required' => false)),
      'tipo_documento'     => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'documento'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'activo'             => new sfValidatorBoolean(array('required' => false)),
      'fecha_alta'         => new sfValidatorDateTime(),
      'fecha_confirmacion' => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'fecha_baja'         => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'fid'                => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'dias_devolucion'    => new sfValidatorInteger(array('required' => false)),
      'source'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha_source'       => new sfValidatorDate(array('required' => false)),
      'utm_campaign'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'utm_term'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_eshop'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'usuario', 'column' => array('email'))),
        new sfValidatorDoctrineUnique(array('model' => 'usuario', 'column' => array('email', 'sexo', 'id_eshop'))),
      ))
    );

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'usuario';
  }

}
