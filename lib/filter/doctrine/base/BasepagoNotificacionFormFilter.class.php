<?php

/**
 * pagoNotificacion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepagoNotificacionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'id_forma_pago'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => true)),
      'metodo'               => new sfWidgetFormFilterInput(),
      'id_pedido'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('pedido'), 'add_empty' => true)),
      'response'             => new sfWidgetFormFilterInput(),
      'procesado'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mensaje'              => new sfWidgetFormFilterInput(),
      'id'                   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_forma_pago'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('formaPago'), 'column' => 'id_forma_pago')),
      'metodo'               => new sfValidatorPass(array('required' => false)),
      'id_pedido'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('pedido'), 'column' => 'id_pedido')),
      'response'             => new sfValidatorPass(array('required' => false)),
      'procesado'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mensaje'              => new sfValidatorPass(array('required' => false)),
      'id'                   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pago_notificacion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pagoNotificacion';
  }

  public function getFields()
  {
    return array(
      'id_pago_notificacion' => 'Number',
      'fecha'                => 'Date',
      'id_forma_pago'        => 'ForeignKey',
      'metodo'               => 'Text',
      'id_pedido'            => 'ForeignKey',
      'response'             => 'Text',
      'procesado'            => 'Boolean',
      'mensaje'              => 'Text',
      'id'                   => 'Text',
    );
  }
}
