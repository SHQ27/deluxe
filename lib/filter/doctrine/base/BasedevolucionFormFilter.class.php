<?php

/**
 * devolucion filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasedevolucionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'id_bonificacion'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('bonificacion'), 'add_empty' => true)),
      'id_usuario'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'tipo_envio'                 => new sfWidgetFormFilterInput(),
      'tipo_credito'               => new sfWidgetFormFilterInput(),
      'nombre'                     => new sfWidgetFormFilterInput(),
      'apellido'                   => new sfWidgetFormFilterInput(),
      'calle'                      => new sfWidgetFormFilterInput(),
      'numero'                     => new sfWidgetFormFilterInput(),
      'piso'                       => new sfWidgetFormFilterInput(),
      'dpto'                       => new sfWidgetFormFilterInput(),
      'codigo_postal'              => new sfWidgetFormFilterInput(),
      'id_provincia'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => true)),
      'localidad'                  => new sfWidgetFormFilterInput(),
      'fecha_envio_oca'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_recibido'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_cierre'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'id_devolucion_motivo'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('devolucionMotivo'), 'add_empty' => true)),
      'motivo_otro'                => new sfWidgetFormFilterInput(),
      'codigo_envio'               => new sfWidgetFormFilterInput(),
      'envio_id_pedido_envio_pack' => new sfWidgetFormFilterInput(),
      'monto_total'                => new sfWidgetFormFilterInput(),
      'id_eshop'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_bonificacion'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('bonificacion'), 'column' => 'id_bonificacion')),
      'id_usuario'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id_usuario')),
      'tipo_envio'                 => new sfValidatorPass(array('required' => false)),
      'tipo_credito'               => new sfValidatorPass(array('required' => false)),
      'nombre'                     => new sfValidatorPass(array('required' => false)),
      'apellido'                   => new sfValidatorPass(array('required' => false)),
      'calle'                      => new sfValidatorPass(array('required' => false)),
      'numero'                     => new sfValidatorPass(array('required' => false)),
      'piso'                       => new sfValidatorPass(array('required' => false)),
      'dpto'                       => new sfValidatorPass(array('required' => false)),
      'codigo_postal'              => new sfValidatorPass(array('required' => false)),
      'id_provincia'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('provincia'), 'column' => 'id_provincia')),
      'localidad'                  => new sfValidatorPass(array('required' => false)),
      'fecha_envio_oca'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_recibido'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_cierre'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'id_devolucion_motivo'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('devolucionMotivo'), 'column' => 'id_devolucion_motivo')),
      'motivo_otro'                => new sfValidatorPass(array('required' => false)),
      'codigo_envio'               => new sfValidatorPass(array('required' => false)),
      'envio_id_pedido_envio_pack' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'monto_total'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'id_eshop'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
    ));

    $this->widgetSchema->setNameFormat('devolucion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'devolucion';
  }

  public function getFields()
  {
    return array(
      'id_devolucion'              => 'Number',
      'fecha'                      => 'Date',
      'id_bonificacion'            => 'ForeignKey',
      'id_usuario'                 => 'ForeignKey',
      'tipo_envio'                 => 'Text',
      'tipo_credito'               => 'Text',
      'nombre'                     => 'Text',
      'apellido'                   => 'Text',
      'calle'                      => 'Text',
      'numero'                     => 'Text',
      'piso'                       => 'Text',
      'dpto'                       => 'Text',
      'codigo_postal'              => 'Text',
      'id_provincia'               => 'ForeignKey',
      'localidad'                  => 'Text',
      'fecha_envio_oca'            => 'Date',
      'fecha_recibido'             => 'Date',
      'fecha_cierre'               => 'Date',
      'id_devolucion_motivo'       => 'ForeignKey',
      'motivo_otro'                => 'Text',
      'codigo_envio'               => 'Text',
      'envio_id_pedido_envio_pack' => 'Number',
      'monto_total'                => 'Number',
      'id_eshop'                   => 'ForeignKey',
    );
  }
}
