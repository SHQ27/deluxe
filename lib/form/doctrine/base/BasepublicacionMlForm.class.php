<?php

/**
 * publicacionMl form base class.
 *
 * @method publicacionMl getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepublicacionMlForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_producto'        => new sfWidgetFormInputHidden(),
      'fecha_inicio'       => new sfWidgetFormDateTime(),
      'fecha_fin'          => new sfWidgetFormDateTime(),
      'item_id'            => new sfWidgetFormInputText(),
      'data_mercado_libre' => new sfWidgetFormTextarea(),
      'status_ml'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_producto'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_producto')), 'empty_value' => $this->getObject()->get('id_producto'), 'required' => false)),
      'fecha_inicio'       => new sfValidatorDateTime(array('required' => false)),
      'fecha_fin'          => new sfValidatorDateTime(array('required' => false)),
      'item_id'            => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'data_mercado_libre' => new sfValidatorString(array('required' => false)),
      'status_ml'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('publicacion_ml[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'publicacionMl';
  }

}
