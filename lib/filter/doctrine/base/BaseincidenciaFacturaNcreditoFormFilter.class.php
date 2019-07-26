<?php

/**
 * incidenciaFacturaNcredito filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseincidenciaFacturaNcreditoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'descripcion'   => new sfWidgetFormFilterInput(),
      'valor'         => new sfWidgetFormFilterInput(),
      'resuelta'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'descripcion'   => new sfValidatorPass(array('required' => false)),
      'valor'         => new sfValidatorPass(array('required' => false)),
      'resuelta'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('incidencia_factura_ncredito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'incidenciaFacturaNcredito';
  }

  public function getFields()
  {
    return array(
      'id_incidencia' => 'Number',
      'descripcion'   => 'Text',
      'valor'         => 'Text',
      'resuelta'      => 'Boolean',
    );
  }
}
