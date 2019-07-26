<?php

/**
 * faltante form base class.
 *
 * @method faltante getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefaltanteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_faltante'      => new sfWidgetFormInputHidden(),
      'id_pedido'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'id_producto_item' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'), 'add_empty' => false)),
      'cantidad'         => new sfWidgetFormInputText(),
      'fecha_aviso'      => new sfWidgetFormDateTime(),
      'id_bonificacion'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => true)),
      'procesado'        => new sfWidgetFormInputCheckbox(),
      'fecha_procesado'  => new sfWidgetFormDateTime(),
      'monto_devuelto'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_faltante'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_faltante')), 'empty_value' => $this->getObject()->get('id_faltante'), 'required' => false)),
      'id_pedido'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'id_producto_item' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoItem'))),
      'cantidad'         => new sfValidatorInteger(array('required' => false)),
      'fecha_aviso'      => new sfValidatorDateTime(),
      'id_bonificacion'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'required' => false)),
      'procesado'        => new sfValidatorBoolean(array('required' => false)),
      'fecha_procesado'  => new sfValidatorDateTime(array('required' => false)),
      'monto_devuelto'   => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('faltante[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'faltante';
  }

}
