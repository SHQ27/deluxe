<?php

/**
 * remitoPedido form base class.
 *
 * @method remitoPedido getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseremitoPedidoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_remito' => new sfWidgetFormInputHidden(),
      'id_pedido' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_remito' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_remito')), 'empty_value' => $this->getObject()->get('id_remito'), 'required' => false)),
      'id_pedido' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pedido')), 'empty_value' => $this->getObject()->get('id_pedido'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('remito_pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'remitoPedido';
  }

}
