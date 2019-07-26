<?php

/**
 * pedido filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepedidoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_usuario'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => true)),
      'fecha_alta'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_baja'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_pago'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_aviso_pago'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_envio'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_facturacion'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_ultima_comprobacion'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fecha_limite_pago'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'nombre'                       => new sfWidgetFormFilterInput(),
      'apellido'                     => new sfWidgetFormFilterInput(),
      'tipo_documento'               => new sfWidgetFormFilterInput(),
      'documento'                    => new sfWidgetFormFilterInput(),
      'email'                        => new sfWidgetFormFilterInput(),
      'telefono'                     => new sfWidgetFormFilterInput(),
      'celular'                      => new sfWidgetFormFilterInput(),
      'observaciones'                => new sfWidgetFormFilterInput(),
      'id_forma_pago'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => true)),
      'envio_tipo'                   => new sfWidgetFormFilterInput(),
      'envio_destinatario'           => new sfWidgetFormFilterInput(),
      'envio_calle'                  => new sfWidgetFormFilterInput(),
      'envio_numero'                 => new sfWidgetFormFilterInput(),
      'envio_piso'                   => new sfWidgetFormFilterInput(),
      'envio_depto'                  => new sfWidgetFormFilterInput(),
      'envio_codigo_postal'          => new sfWidgetFormFilterInput(),
      'envio_id_sucursal'            => new sfWidgetFormFilterInput(),
      'envio_id_provincia'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => true)),
      'envio_localidad'              => new sfWidgetFormFilterInput(),
      'envio_correo'                 => new sfWidgetFormFilterInput(),
      'envio_servicio'               => new sfWidgetFormFilterInput(),
      'envio_detalle'                => new sfWidgetFormFilterInput(),
      'envio_id_pedido_envio_pack'   => new sfWidgetFormFilterInput(),
      'monto_envio'                  => new sfWidgetFormFilterInput(),
      'monto_envio_deluxe'           => new sfWidgetFormFilterInput(),
      'monto_productos'              => new sfWidgetFormFilterInput(),
      'monto_bonificacion'           => new sfWidgetFormFilterInput(),
      'monto_descuento'              => new sfWidgetFormFilterInput(),
      'monto_total'                  => new sfWidgetFormFilterInput(),
      'monto_facturacion'            => new sfWidgetFormFilterInput(),
      'cuotas'                       => new sfWidgetFormFilterInput(),
      'interes'                      => new sfWidgetFormFilterInput(),
      'datos_pago'                   => new sfWidgetFormFilterInput(),
      'codigo_envio'                 => new sfWidgetFormFilterInput(),
      'nota'                         => new sfWidgetFormFilterInput(),
      'requiere_intervencion_manual' => new sfWidgetFormFilterInput(),
      'tipo_producto'                => new sfWidgetFormFilterInput(),
      'tiene_problema_oca'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'id_eshop'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'source'                       => new sfWidgetFormFilterInput(),
      'fecha_source'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'utm_campaign'                 => new sfWidgetFormFilterInput(),
      'utm_term'                     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_usuario'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('usuario'), 'column' => 'id_usuario')),
      'fecha_alta'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_baja'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_pago'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_aviso_pago'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_envio'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_facturacion'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_ultima_comprobacion'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_limite_pago'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'nombre'                       => new sfValidatorPass(array('required' => false)),
      'apellido'                     => new sfValidatorPass(array('required' => false)),
      'tipo_documento'               => new sfValidatorPass(array('required' => false)),
      'documento'                    => new sfValidatorPass(array('required' => false)),
      'email'                        => new sfValidatorPass(array('required' => false)),
      'telefono'                     => new sfValidatorPass(array('required' => false)),
      'celular'                      => new sfValidatorPass(array('required' => false)),
      'observaciones'                => new sfValidatorPass(array('required' => false)),
      'id_forma_pago'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('formaPago'), 'column' => 'id_forma_pago')),
      'envio_tipo'                   => new sfValidatorPass(array('required' => false)),
      'envio_destinatario'           => new sfValidatorPass(array('required' => false)),
      'envio_calle'                  => new sfValidatorPass(array('required' => false)),
      'envio_numero'                 => new sfValidatorPass(array('required' => false)),
      'envio_piso'                   => new sfValidatorPass(array('required' => false)),
      'envio_depto'                  => new sfValidatorPass(array('required' => false)),
      'envio_codigo_postal'          => new sfValidatorPass(array('required' => false)),
      'envio_id_sucursal'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'envio_id_provincia'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('provincia'), 'column' => 'id_provincia')),
      'envio_localidad'              => new sfValidatorPass(array('required' => false)),
      'envio_correo'                 => new sfValidatorPass(array('required' => false)),
      'envio_servicio'               => new sfValidatorPass(array('required' => false)),
      'envio_detalle'                => new sfValidatorPass(array('required' => false)),
      'envio_id_pedido_envio_pack'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'monto_envio'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto_envio_deluxe'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto_productos'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto_bonificacion'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto_descuento'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto_total'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'monto_facturacion'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cuotas'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'interes'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'datos_pago'                   => new sfValidatorPass(array('required' => false)),
      'codigo_envio'                 => new sfValidatorPass(array('required' => false)),
      'nota'                         => new sfValidatorPass(array('required' => false)),
      'requiere_intervencion_manual' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo_producto'                => new sfValidatorPass(array('required' => false)),
      'tiene_problema_oca'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'id_eshop'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('eshop'), 'column' => 'id_eshop')),
      'source'                       => new sfValidatorPass(array('required' => false)),
      'fecha_source'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'utm_campaign'                 => new sfValidatorPass(array('required' => false)),
      'utm_term'                     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedido';
  }

  public function getFields()
  {
    return array(
      'id_pedido'                    => 'Number',
      'id_usuario'                   => 'ForeignKey',
      'fecha_alta'                   => 'Date',
      'fecha_baja'                   => 'Date',
      'fecha_pago'                   => 'Date',
      'fecha_aviso_pago'             => 'Date',
      'fecha_envio'                  => 'Date',
      'fecha_facturacion'            => 'Date',
      'fecha_ultima_comprobacion'    => 'Date',
      'fecha_limite_pago'            => 'Date',
      'nombre'                       => 'Text',
      'apellido'                     => 'Text',
      'tipo_documento'               => 'Text',
      'documento'                    => 'Text',
      'email'                        => 'Text',
      'telefono'                     => 'Text',
      'celular'                      => 'Text',
      'observaciones'                => 'Text',
      'id_forma_pago'                => 'ForeignKey',
      'envio_tipo'                   => 'Text',
      'envio_destinatario'           => 'Text',
      'envio_calle'                  => 'Text',
      'envio_numero'                 => 'Text',
      'envio_piso'                   => 'Text',
      'envio_depto'                  => 'Text',
      'envio_codigo_postal'          => 'Text',
      'envio_id_sucursal'            => 'Number',
      'envio_id_provincia'           => 'ForeignKey',
      'envio_localidad'              => 'Text',
      'envio_correo'                 => 'Text',
      'envio_servicio'               => 'Text',
      'envio_detalle'                => 'Text',
      'envio_id_pedido_envio_pack'   => 'Number',
      'monto_envio'                  => 'Number',
      'monto_envio_deluxe'           => 'Number',
      'monto_productos'              => 'Number',
      'monto_bonificacion'           => 'Number',
      'monto_descuento'              => 'Number',
      'monto_total'                  => 'Number',
      'monto_facturacion'            => 'Number',
      'cuotas'                       => 'Number',
      'interes'                      => 'Number',
      'datos_pago'                   => 'Text',
      'codigo_envio'                 => 'Text',
      'nota'                         => 'Text',
      'requiere_intervencion_manual' => 'Number',
      'tipo_producto'                => 'Text',
      'tiene_problema_oca'           => 'Boolean',
      'id_eshop'                     => 'ForeignKey',
      'source'                       => 'Text',
      'fecha_source'                 => 'Date',
      'utm_campaign'                 => 'Text',
      'utm_term'                     => 'Text',
    );
  }
}
