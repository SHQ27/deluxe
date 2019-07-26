<?php

/**
 * tipoAvisoPedido form base class.
 *
 * @method tipoAvisoPedido getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetipoAvisoPedidoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_tipo_aviso_pedido' => new sfWidgetFormInputHidden(),
      'denominacion'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_tipo_aviso_pedido' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_tipo_aviso_pedido')), 'empty_value' => $this->getObject()->get('id_tipo_aviso_pedido'), 'required' => false)),
      'denominacion'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tipo_aviso_pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'tipoAvisoPedido';
  }

}
