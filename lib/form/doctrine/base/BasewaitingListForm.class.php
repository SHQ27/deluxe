<?php

/**
 * waitingList form base class.
 *
 * @method waitingList getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasewaitingListForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_waiting_list'  => new sfWidgetFormInputHidden(),
      'id_usuario'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'fecha'            => new sfWidgetFormDateTime(),
      'id_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'cantidad'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_waiting_list'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_waiting_list')), 'empty_value' => $this->getObject()->get('id_waiting_list'), 'required' => false)),
      'id_usuario'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'fecha'            => new sfValidatorDateTime(),
      'id_producto_item' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'cantidad'         => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('waiting_list[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'waitingList';
  }

}
