<?php

/**
 * descuento form base class.
 *
 * @method descuento getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedescuentoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_descuento'      => new sfWidgetFormInputHidden(),
      'codigo'            => new sfWidgetFormInputText(),
      'id_tipo_descuento' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'), 'add_empty' => false)),
      'valor'             => new sfWidgetFormInputText(),
      'vigencia_desde'    => new sfWidgetFormDateTime(),
      'vigencia_hasta'    => new sfWidgetFormDateTime(),
      'total'             => new sfWidgetFormInputText(),
      'utilizados'        => new sfWidgetFormInputText(),
      'es_interno'        => new sfWidgetFormInputCheckbox(),
      'id_eshop'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'recibe_premio'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_descuento'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_descuento')), 'empty_value' => $this->getObject()->get('id_descuento'), 'required' => false)),
      'codigo'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'id_tipo_descuento' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'))),
      'valor'             => new sfValidatorNumber(array('required' => false)),
      'vigencia_desde'    => new sfValidatorDateTime(array('required' => false)),
      'vigencia_hasta'    => new sfValidatorDateTime(array('required' => false)),
      'total'             => new sfValidatorInteger(array('required' => false)),
      'utilizados'        => new sfValidatorInteger(array('required' => false)),
      'es_interno'        => new sfValidatorBoolean(array('required' => false)),
      'id_eshop'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
      'recibe_premio'     => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('descuento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'descuento';
  }

}
