<?php

/**
 * promoPago filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepromoPagoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'denominacion'   => new sfWidgetFormFilterInput(),
      'proveedor'      => new sfWidgetFormFilterInput(),
      'id_forma_pago'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => true)),
      'vigencia_desde' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'vigencia_hasta' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'dias_semana'    => new sfWidgetFormFilterInput(),
      'cuotas'         => new sfWidgetFormFilterInput(),
      'params'         => new sfWidgetFormFilterInput(),
      'id_descuento'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('descuento'), 'add_empty' => true)),
      'orden'          => new sfWidgetFormFilterInput(),
      'activo'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'id_eshop'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'denominacion'   => new sfValidatorPass(array('required' => false)),
      'proveedor'      => new sfValidatorPass(array('required' => false)),
      'id_forma_pago'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('formaPago'), 'column' => 'id_forma_pago')),
      'vigencia_desde' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'vigencia_hasta' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'dias_semana'    => new sfValidatorPass(array('required' => false)),
      'cuotas'         => new sfValidatorPass(array('required' => false)),
      'params'         => new sfValidatorPass(array('required' => false)),
      'id_descuento'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('descuento'), 'column' => 'id_descuento')),
      'orden'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activo'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'id_eshop'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('promo_pago_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'promoPago';
  }

  public function getFields()
  {
    return array(
      'id_promo_pago'  => 'Number',
      'denominacion'   => 'Text',
      'proveedor'      => 'Text',
      'id_forma_pago'  => 'ForeignKey',
      'vigencia_desde' => 'Date',
      'vigencia_hasta' => 'Date',
      'dias_semana'    => 'Text',
      'cuotas'         => 'Text',
      'params'         => 'Text',
      'id_descuento'   => 'ForeignKey',
      'orden'          => 'Number',
      'activo'         => 'Boolean',
      'id_eshop'       => 'ForeignKey',
    );
  }
}
