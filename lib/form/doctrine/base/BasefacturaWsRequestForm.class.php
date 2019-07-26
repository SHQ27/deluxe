<?php

/**
 * facturaWsRequest form base class.
 *
 * @method facturaWsRequest getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasefacturaWsRequestForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_factura_ws_request' => new sfWidgetFormInputHidden(),
      'request'               => new sfWidgetFormTextarea(),
      'response'              => new sfWidgetFormTextarea(),
      'fecha'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id_factura_ws_request' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_factura_ws_request')), 'empty_value' => $this->getObject()->get('id_factura_ws_request'), 'required' => false)),
      'request'               => new sfValidatorString(array('required' => false)),
      'response'              => new sfValidatorString(array('required' => false)),
      'fecha'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('factura_ws_request[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'facturaWsRequest';
  }

}
