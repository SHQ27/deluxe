<?php

/**
 * carritoBonificacion form base class.
 *
 * @method carritoBonificacion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecarritoBonificacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_carrito_bonificacion' => new sfWidgetFormInputHidden(),
      'id_bonificacion'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => false)),
      'id_session'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('session'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_carrito_bonificacion' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_carrito_bonificacion')), 'empty_value' => $this->getObject()->get('id_carrito_bonificacion'), 'required' => false)),
      'id_bonificacion'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'))),
      'id_session'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('session'))),
    ));

    $this->widgetSchema->setNameFormat('carrito_bonificacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'carritoBonificacion';
  }

}
