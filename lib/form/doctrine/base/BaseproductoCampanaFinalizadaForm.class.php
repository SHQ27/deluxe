<?php

/**
 * productoCampanaFinalizada form base class.
 *
 * @method productoCampanaFinalizada getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseproductoCampanaFinalizadaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto'    => new sfWidgetFormInputHidden(),
      'id_campana'     => new sfWidgetFormInputHidden(),
      'fecha'          => new sfWidgetFormDateTime(),
      'fue_restaurada' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_producto'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto')), 'empty_value' => $this->getObject()->get('id_producto'), 'required' => false)),
      'id_campana'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_campana')), 'empty_value' => $this->getObject()->get('id_campana'), 'required' => false)),
      'fecha'          => new sfValidatorDateTime(),
      'fue_restaurada' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_campana_finalizada[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'productoCampanaFinalizada';
  }

}
