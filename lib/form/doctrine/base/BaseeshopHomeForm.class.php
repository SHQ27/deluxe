<?php

/**
 * eshopHome form base class.
 *
 * @method eshopHome getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopHomeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop_home'  => new sfWidgetFormInputHidden(),
      'id_eshop'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => false)),
      'denominacion'   => new sfWidgetFormInputText(),
      'tipo'           => new sfWidgetFormInputText(),
      'vigencia_desde' => new sfWidgetFormDateTime(),
      'vigencia_hasta' => new sfWidgetFormDateTime(),
      'orden'          => new sfWidgetFormInputText(),
      'activo'         => new sfWidgetFormInputCheckbox(),
      'texto'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop_home'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop_home')), 'empty_value' => $this->getObject()->get('id_eshop_home'), 'required' => false)),
      'id_eshop'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'))),
      'denominacion'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'tipo'           => new sfValidatorPass(array('required' => false)),
      'vigencia_desde' => new sfValidatorDateTime(array('required' => false)),
      'vigencia_hasta' => new sfValidatorDateTime(array('required' => false)),
      'orden'          => new sfValidatorInteger(array('required' => false)),
      'activo'         => new sfValidatorBoolean(array('required' => false)),
      'texto'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop_home[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshopHome';
  }

}
