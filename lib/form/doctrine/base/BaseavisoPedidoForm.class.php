<?php

/**
 * avisoPedido form base class.
 *
 * @method avisoPedido getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseavisoPedidoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_aviso_pedido'      => new sfWidgetFormInputHidden(),
      'id_tipo_aviso_pedido' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('tipoAvisoPedido'), 'add_empty' => false)),
      'fecha'                => new sfWidgetFormDateTime(),
      'id_pedido'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'hash'                 => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_aviso_pedido'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_aviso_pedido')), 'empty_value' => $this->getObject()->get('id_aviso_pedido'), 'required' => false)),
      'id_tipo_aviso_pedido' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('tipoAvisoPedido'))),
      'fecha'                => new sfValidatorDateTime(array('required' => false)),
      'id_pedido'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'hash'                 => new sfValidatorString(array('max_length' => 32, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'avisoPedido', 'column' => array('hash')))
    );

    $this->widgetSchema->setNameFormat('aviso_pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'avisoPedido';
  }

}
