<?php

/**
 * stockTipo form base class.
 *
 * @method stockTipo getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasestockTipoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_stock_tipo' => new sfWidgetFormInputHidden(),
      'denominacion'  => new sfWidgetFormInputText(),
      'es_de_sistema' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_stock_tipo' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_stock_tipo')), 'empty_value' => $this->getObject()->get('id_stock_tipo'), 'required' => false)),
      'denominacion'  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'es_de_sistema' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('stock_tipo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stockTipo';
  }

}
