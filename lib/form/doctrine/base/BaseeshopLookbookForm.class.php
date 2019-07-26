<?php

/**
 * eshopLookbook form base class.
 *
 * @method eshopLookbook getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopLookbookForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_lookbook' => new sfWidgetFormInputHidden(),
      'denominacion'      => new sfWidgetFormInputText(),
      'texto'             => new sfWidgetFormInputText(),
      'id_eshop'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => false)),
      'activo'            => new sfWidgetFormInputCheckbox(),
      'orden'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop_lookbook' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_lookbook')), 'empty_value' => $this->getObject()->get('id_eshop_lookbook'), 'required' => false)),
      'denominacion'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_eshop'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'))),
      'activo'            => new sfValidatorBoolean(array('required' => false)),
      'orden'             => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_lookbook[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopLookbook';
  }

}
