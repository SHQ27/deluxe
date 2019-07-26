<?php

/**
 * carritoEnvio form base class.
 *
 * @method carritoEnvio getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecarritoEnvioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_carrito_envio' => new sfWidgetFormInputHidden(),
      'id_session'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => false)),
      'tipo'             => new sfWidgetFormInputText(),
      'enviopack_data'   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_carrito_envio' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_carrito_envio')), 'empty_value' => $this->getObject()->get('id_carrito_envio'), 'required' => false)),
      'id_session'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('session'))),
      'tipo'             => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'enviopack_data'   => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('carrito_envio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoEnvio';
  }

}
