<?php

/**
 * familiaTalle form base class.
 *
 * @method familiaTalle getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefamiliaTalleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_familia_talle' => new sfWidgetFormInputHidden(),
      'denominacion'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_familia_talle' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_familia_talle')), 'empty_value' => $this->getObject()->get('id_familia_talle'), 'required' => false)),
      'denominacion'     => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('familia_talle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'familiaTalle';
  }

}
