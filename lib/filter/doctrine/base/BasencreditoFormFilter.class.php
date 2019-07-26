<?php

/**
 * ncredito filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasencreditoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'procesada'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'CAE'             => new sfWidgetFormFilterInput(),
      'CAE_vencimiento' => new sfWidgetFormFilterInput(),
      'comprobante'     => new sfWidgetFormFilterInput(),
      'resultado'       => new sfWidgetFormFilterInput(),
      'entorno'         => new sfWidgetFormFilterInput(),
      'importe'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'procesada'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'CAE'             => new sfValidatorPass(array('required' => false)),
      'CAE_vencimiento' => new sfValidatorPass(array('required' => false)),
      'comprobante'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'resultado'       => new sfValidatorPass(array('required' => false)),
      'entorno'         => new sfValidatorPass(array('required' => false)),
      'importe'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('ncredito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ncredito';
  }

  public function getFields()
  {
    return array(
      'id_ncredito'     => 'Number',
      'procesada'       => 'Boolean',
      'CAE'             => 'Text',
      'CAE_vencimiento' => 'Text',
      'comprobante'     => 'Number',
      'resultado'       => 'Text',
      'entorno'         => 'Text',
      'importe'         => 'Number',
    );
  }
}
