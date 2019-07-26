<?php

/**
 * talleSet form base class.
 *
 * @method talleSet getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetalleSetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_talle_set' => new sfWidgetFormInputHidden(),
      'denominacion' => new sfWidgetFormInputText(),
      'id_marca'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_talle_set' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_talle_set')), 'empty_value' => $this->getObject()->get('id_talle_set'), 'required' => false)),
      'denominacion' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'id_marca'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('marca'))),
    ));

    $this->widgetSchema->setNameFormat('talle_set[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'talleSet';
  }

}
