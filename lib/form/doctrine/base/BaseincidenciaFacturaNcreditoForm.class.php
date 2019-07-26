<?php

/**
 * incidenciaFacturaNcredito form base class.
 *
 * @method incidenciaFacturaNcredito getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseincidenciaFacturaNcreditoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_incidencia' => new sfWidgetFormInputHidden(),
      'descripcion'   => new sfWidgetFormTextarea(),
      'valor'         => new sfWidgetFormInputText(),
      'resuelta'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_incidencia' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_incidencia')), 'empty_value' => $this->getObject()->get('id_incidencia'), 'required' => false)),
      'descripcion'   => new sfValidatorString(array('required' => false)),
      'valor'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'resuelta'      => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('incidencia_factura_ncredito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'incidenciaFacturaNcredito';
  }

}
