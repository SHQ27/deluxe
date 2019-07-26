<?php

/**
 * newsletter form base class.
 *
 * @method newsletter getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasenewsletterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_newsletter' => new sfWidgetFormInputHidden(),
      'nombre'        => new sfWidgetFormInputText(),
      'apellido'      => new sfWidgetFormInputText(),
      'sexo'          => new sfWidgetFormInputText(),
      'email'         => new sfWidgetFormInputText(),
      'fecha_alta'    => new sfWidgetFormDateTime(),
      'source'        => new sfWidgetFormInputText(),
      'fecha_source'  => new sfWidgetFormDate(),
      'utm_campaign'  => new sfWidgetFormInputText(),
      'utm_term'      => new sfWidgetFormInputText(),
      'id_eshop'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_newsletter' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_newsletter')), 'empty_value' => $this->getObject()->get('id_newsletter'), 'required' => false)),
      'nombre'        => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'apellido'      => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'sexo'          => new sfValidatorString(array('max_length' => 1)),
      'email'         => new sfValidatorString(array('max_length' => 100)),
      'fecha_alta'    => new sfValidatorDateTime(),
      'source'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha_source'  => new sfValidatorDate(array('required' => false)),
      'utm_campaign'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'utm_term'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_eshop'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'newsletter', 'column' => array('email', 'sexo', 'id_eshop')))
    );

    $this->widgetSchema->setNameFormat('newsletter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'newsletter';
  }

}
