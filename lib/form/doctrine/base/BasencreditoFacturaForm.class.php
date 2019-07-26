<?php

/**
 * ncreditoFactura form base class.
 *
 * @method ncreditoFactura getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasencreditoFacturaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_ncredito' => new sfWidgetFormInputHidden(),
      'id_factura'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id_ncredito' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_ncredito')), 'empty_value' => $this->getObject()->get('id_ncredito'), 'required' => false)),
      'id_factura'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_factura')), 'empty_value' => $this->getObject()->get('id_factura'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ncredito_factura[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ncreditoFactura';
  }

}
