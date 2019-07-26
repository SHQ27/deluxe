<?php

/**
 * tag form base class.
 *
 * @method tag getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tag'       => new sfWidgetFormInputHidden(),
      'denominacion' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_tag'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_tag')), 'empty_value' => $this->getObject()->get('id_tag'), 'required' => false)),
      'denominacion' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'tag', 'column' => array('denominacion')))
    );

    $this->widgetSchema->setNameFormat('tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tag';
  }

}
