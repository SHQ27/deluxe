<?php

/**
 * facturaWsRequestFactura form base class.
 *
 * @method facturaWsRequestFactura getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaWsRequestFacturaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_factura_ws_request' => new sfWidgetFormInputHidden(),
      'id_factura'            => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_factura_ws_request' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_factura_ws_request')), 'empty_value' => $this->getObject()->get('id_factura_ws_request'), 'required' => false)),
      'id_factura'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_factura')), 'empty_value' => $this->getObject()->get('id_factura'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('factura_ws_request_factura[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaWsRequestFactura';
  }

}
