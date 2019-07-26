<?php

/**
 * descuentoRestriccion form base class.
 *
 * @method descuentoRestriccion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedescuentoRestriccionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_descuento_restriccion' => new sfWidgetFormInputHidden(),
      'id_descuento'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => false)),
      'tipo'                     => new sfWidgetFormInputText(),
      'valor'                    => new sfWidgetFormInputText(),
      'excluir'                  => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_descuento_restriccion' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_descuento_restriccion')), 'empty_value' => $this->getObject()->get('id_descuento_restriccion'), 'required' => false)),
      'id_descuento'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'))),
      'tipo'                     => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'valor'                    => new sfValidatorInteger(array('required' => false)),
      'excluir'                  => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('descuento_restriccion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'descuentoRestriccion';
  }

}
