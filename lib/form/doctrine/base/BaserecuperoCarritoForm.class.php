<?php

/**
 * recuperoCarrito form base class.
 *
 * @method recuperoCarrito getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaserecuperoCarritoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_recupero_carrito' => new sfWidgetFormInputHidden(),
      'id_pedido'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'mail_enviado'        => new sfWidgetFormInputCheckbox(),
      'hash'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_recupero_carrito' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_recupero_carrito')), 'empty_value' => $this->getObject()->get('id_recupero_carrito'), 'required' => false)),
      'id_pedido'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'mail_enviado'        => new sfValidatorBoolean(array('required' => false)),
      'hash'                => new sfValidatorString(array('max_length' => 40, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recupero_carrito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'recuperoCarrito';
  }

}
