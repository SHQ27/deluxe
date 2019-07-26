<?php

/**
 * devolucionMotivo form base class.
 *
 * @method devolucionMotivo getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedevolucionMotivoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_devolucion_motivo' => new sfWidgetFormInputHidden(),
      'denominacion'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_devolucion_motivo' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_devolucion_motivo')), 'empty_value' => $this->getObject()->get('id_devolucion_motivo'), 'required' => false)),
      'denominacion'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('devolucion_motivo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devolucionMotivo';
  }

}
