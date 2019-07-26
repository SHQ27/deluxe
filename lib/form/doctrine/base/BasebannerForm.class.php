<?php

/**
 * banner form base class.
 *
 * @method banner getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasebannerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_banner'     => new sfWidgetFormInputHidden(),
      'url'           => new sfWidgetFormInputText(),
      'orden'         => new sfWidgetFormInputText(),
      'activo'        => new sfWidgetFormInputCheckbox(),
      'ventana_nueva' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_banner'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_banner')), 'empty_value' => $this->getObject()->get('id_banner'), 'required' => false)),
      'url'           => new sfValidatorString(array('max_length' => 255)),
      'orden'         => new sfValidatorInteger(),
      'activo'        => new sfValidatorBoolean(array('required' => false)),
      'ventana_nueva' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('banner[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'banner';
  }

}
