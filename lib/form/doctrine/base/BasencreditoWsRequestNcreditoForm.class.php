<?php

/**
 * ncreditoWsRequestNcredito form base class.
 *
 * @method ncreditoWsRequestNcredito getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasencreditoWsRequestNcreditoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_ncredito'            => new sfWidgetFormInputHidden(),
      'id_ncredito_ws_request' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_ncredito'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_ncredito')), 'empty_value' => $this->getObject()->get('id_ncredito'), 'required' => false)),
      'id_ncredito_ws_request' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_ncredito_ws_request')), 'empty_value' => $this->getObject()->get('id_ncredito_ws_request'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ncredito_ws_request_ncredito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ncreditoWsRequestNcredito';
  }

}
