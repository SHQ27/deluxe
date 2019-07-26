<?php

/**
 * reciboEshopPedido form base class.
 *
 * @method reciboEshopPedido getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasereciboEshopPedidoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_recibo_eshop' => new sfWidgetFormInputHidden(),
      'id_pedido'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_recibo_eshop' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_recibo_eshop')), 'empty_value' => $this->getObject()->get('id_recibo_eshop'), 'required' => false)),
      'id_pedido'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pedido')), 'empty_value' => $this->getObject()->get('id_pedido'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recibo_eshop_pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reciboEshopPedido';
  }

}
