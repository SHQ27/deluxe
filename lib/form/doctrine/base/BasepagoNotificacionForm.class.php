<?php

/**
 * pagoNotificacion form base class.
 *
 * @method pagoNotificacion getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepagoNotificacionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pago_notificacion' => new sfWidgetFormInputHidden(),
      'fecha'                => new sfWidgetFormDateTime(),
      'id_forma_pago'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => false)),
      'metodo'               => new sfWidgetFormInputText(),
      'id_pedido'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'response'             => new sfWidgetFormTextarea(),
      'procesado'            => new sfWidgetFormInputCheckbox(),
      'mensaje'              => new sfWidgetFormTextarea(),
      'id'                   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_pago_notificacion' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pago_notificacion')), 'empty_value' => $this->getObject()->get('id_pago_notificacion'), 'required' => false)),
      'fecha'                => new sfValidatorDateTime(),
      'id_forma_pago'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'))),
      'metodo'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'id_pedido'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'required' => false)),
      'response'             => new sfValidatorString(array('required' => false)),
      'procesado'            => new sfValidatorBoolean(array('required' => false)),
      'mensaje'              => new sfValidatorString(array('required' => false)),
      'id'                   => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pago_notificacion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pagoNotificacion';
  }

}
