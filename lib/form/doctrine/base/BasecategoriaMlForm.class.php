<?php

/**
 * categoriaMl form base class.
 *
 * @method categoriaMl getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecategoriaMlForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_categoria_ml'       => new sfWidgetFormInputHidden(),
      'id_categoria_ml_padre' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('categoriaMlPadre'), 'add_empty' => true)),
      'denominacion'          => new sfWidgetFormInputText(),
      'id_externo'            => new sfWidgetFormInputText(),
      'tiene_hijos'           => new sfWidgetFormInputCheckbox(),
      'attribute_types'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_categoria_ml'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_categoria_ml')), 'empty_value' => $this->getObject()->get('id_categoria_ml'), 'required' => false)),
      'id_categoria_ml_padre' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('categoriaMlPadre'), 'required' => false)),
      'denominacion'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_externo'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tiene_hijos'           => new sfValidatorBoolean(array('required' => false)),
      'attribute_types'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categoria_ml[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'categoriaMl';
  }

}
