<?php

/**
 * premioLog form base class.
 *
 * @method premioLog getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepremioLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_premio_log'   => new sfWidgetFormInputHidden(),
      'id_premio'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('premio'), 'add_empty' => false)),
      'id_bonificacion' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => false)),
      'id_pedido'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_premio_log'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_premio_log')), 'empty_value' => $this->getObject()->get('id_premio_log'), 'required' => false)),
      'id_premio'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('premio'))),
      'id_bonificacion' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'))),
      'id_pedido'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
    ));

    $this->widgetSchema->setNameFormat('premio_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'premioLog';
  }

}
