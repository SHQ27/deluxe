<?php

/**
 * devueltoOca form base class.
 *
 * @method devueltoOca getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedevueltoOcaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_devuelto_oca' => new sfWidgetFormInputHidden(),
      'fecha'           => new sfWidgetFormDateTime(),
      'id_pedido'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'fecha_retirado'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_devuelto_oca' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_devuelto_oca')), 'empty_value' => $this->getObject()->get('id_devuelto_oca'), 'required' => false)),
      'fecha'           => new sfValidatorDateTime(),
      'id_pedido'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'fecha_retirado'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('devuelto_oca[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devueltoOca';
  }

}
