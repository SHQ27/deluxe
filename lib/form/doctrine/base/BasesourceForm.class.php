<?php

/**
 * source form base class.
 *
 * @method source getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesourceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_source'    => new sfWidgetFormInputHidden(),
      'codigo'       => new sfWidgetFormInputText(),
      'denominacion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_source'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_source')), 'empty_value' => $this->getObject()->get('id_source'), 'required' => false)),
      'codigo'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'denominacion' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('source[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'source';
  }

}
