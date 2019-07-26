<?php

/**
 * reciboEshop form base class.
 *
 * @method reciboEshop getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasereciboEshopForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_recibo_eshop' => new sfWidgetFormInputHidden(),
      'fecha'           => new sfWidgetFormDateTime(),
      'tipo'            => new sfWidgetFormInputText(),
      'importe'         => new sfWidgetFormInputText(),
      'id_eshop'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_recibo_eshop' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_recibo_eshop')), 'empty_value' => $this->getObject()->get('id_recibo_eshop'), 'required' => false)),
      'fecha'           => new sfValidatorDateTime(),
      'tipo'            => new sfValidatorPass(array('required' => false)),
      'importe'         => new sfValidatorNumber(array('required' => false)),
      'id_eshop'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'))),
    ));

    $this->widgetSchema->setNameFormat('recibo_eshop[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reciboEshop';
  }

}
