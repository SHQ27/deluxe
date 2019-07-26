<?php

/**
 * factura form base class.
 *
 * @method factura getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_factura'      => new sfWidgetFormInputHidden(),
      'id_pedido'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => false)),
      'procesada'       => new sfWidgetFormInputCheckbox(),
      'CAE'             => new sfWidgetFormInputText(),
      'CAE_vencimiento' => new sfWidgetFormInputText(),
      'comprobante'     => new sfWidgetFormInputText(),
      'resultado'       => new sfWidgetFormInputText(),
      'entorno'         => new sfWidgetFormInputText(),
      'mail_enviado'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_factura'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_factura')), 'empty_value' => $this->getObject()->get('id_factura'), 'required' => false)),
      'id_pedido'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'))),
      'procesada'       => new sfValidatorBoolean(array('required' => false)),
      'CAE'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CAE_vencimiento' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'comprobante'     => new sfValidatorInteger(array('required' => false)),
      'resultado'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'entorno'         => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'mail_enviado'    => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'factura', 'column' => array('id_pedido', 'entorno')))
    );

    $this->widgetSchema->setNameFormat('factura[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'factura';
  }

}
