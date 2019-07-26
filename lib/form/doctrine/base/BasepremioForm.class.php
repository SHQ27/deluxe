<?php

/**
 * premio form base class.
 *
 * @method premio getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepremioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_premio'        => new sfWidgetFormInputHidden(),
      'monto_minimo'     => new sfWidgetFormInputText(),
      'valor'            => new sfWidgetFormInputText(),
      'dias_vencimiento' => new sfWidgetFormInputText(),
      'fecha_desde'      => new sfWidgetFormDate(),
      'fecha_hasta'      => new sfWidgetFormDate(),
      'tipo_premio'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_premio'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_premio')), 'empty_value' => $this->getObject()->get('id_premio'), 'required' => false)),
      'monto_minimo'     => new sfValidatorInteger(array('required' => false)),
      'valor'            => new sfValidatorInteger(array('required' => false)),
      'dias_vencimiento' => new sfValidatorInteger(array('required' => false)),
      'fecha_desde'      => new sfValidatorDate(array('required' => false)),
      'fecha_hasta'      => new sfValidatorDate(array('required' => false)),
      'tipo_premio'      => new sfValidatorString(array('max_length' => 5, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('premio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'premio';
  }

}
