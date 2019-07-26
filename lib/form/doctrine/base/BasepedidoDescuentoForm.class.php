<?php

/**
 * pedidoDescuento form base class.
 *
 * @method pedidoDescuento getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepedidoDescuentoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido_descuento' => new sfWidgetFormInputHidden(),
      'id_descuento'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => false)),
      'id_pedido'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'id_tipo_descuento'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'), 'add_empty' => false)),
      'valor'               => new sfWidgetFormInputText(),
      'monto'               => new sfWidgetFormInputText(),
      'info_adicional'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id_pedido_descuento' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pedido_descuento')), 'empty_value' => $this->getObject()->get('id_pedido_descuento'), 'required' => false)),
      'id_descuento'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'))),
      'id_pedido'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'id_tipo_descuento'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('tipoDescuento'))),
      'valor'               => new sfValidatorNumber(array('required' => false)),
      'monto'               => new sfValidatorNumber(array('required' => false)),
      'info_adicional'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido_descuento[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedidoDescuento';
  }

}
