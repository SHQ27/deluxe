<?php

/**
 * reporteCronologico filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasereporteCronologicoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'                          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'accion'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_pedido'                      => new sfWidgetFormFilterInput(),
      'fuente'                         => new sfWidgetFormFilterInput(),
      'marca'                          => new sfWidgetFormFilterInput(),
      'condicion_fiscal'               => new sfWidgetFormFilterInput(),
      'codigo_producto'                => new sfWidgetFormFilterInput(),
      'producto'                       => new sfWidgetFormFilterInput(),
      'color'                          => new sfWidgetFormFilterInput(),
      'talle'                          => new sfWidgetFormFilterInput(),
      'categoria'                      => new sfWidgetFormFilterInput(),
      'genero'                         => new sfWidgetFormFilterInput(),
      'precio_deluxe'                  => new sfWidgetFormFilterInput(),
      'costo'                          => new sfWidgetFormFilterInput(),
      'cantidad'                       => new sfWidgetFormFilterInput(),
      'bonificacion_devolucion_mp'     => new sfWidgetFormFilterInput(),
      'bonificacion_devolucion_deluxe' => new sfWidgetFormFilterInput(),
      'bonificacion_motivo'            => new sfWidgetFormFilterInput(),
      'bonificacion_submotivo'         => new sfWidgetFormFilterInput(),
      'descuento'                      => new sfWidgetFormFilterInput(),
      'descuento_motivo'               => new sfWidgetFormFilterInput(),
      'descuento_codigo'               => new sfWidgetFormFilterInput(),
      'costo_envio'                    => new sfWidgetFormFilterInput(),
      'costo_envio_deluxe'             => new sfWidgetFormFilterInput(),
      'tipo_envio'                     => new sfWidgetFormFilterInput(),
      'venta_db_total'                 => new sfWidgetFormFilterInput(),
      'total_facturado'                => new sfWidgetFormFilterInput(),
      'cliente'                        => new sfWidgetFormFilterInput(),
      'localidad'                      => new sfWidgetFormFilterInput(),
      'provincia'                      => new sfWidgetFormFilterInput(),
      'forma_pago'                     => new sfWidgetFormFilterInput(),
      'id_eshop'                       => new sfWidgetFormFilterInput(),
      'nombre_eshop'                   => new sfWidgetFormFilterInput(),
      'cliente_tipo_documento'         => new sfWidgetFormFilterInput(),
      'cliente_documento'              => new sfWidgetFormFilterInput(),
      'cliente_email'                  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'fecha'                          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'accion'                         => new sfValidatorPass(array('required' => false)),
      'id_pedido'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fuente'                         => new sfValidatorPass(array('required' => false)),
      'marca'                          => new sfValidatorPass(array('required' => false)),
      'condicion_fiscal'               => new sfValidatorPass(array('required' => false)),
      'codigo_producto'                => new sfValidatorPass(array('required' => false)),
      'producto'                       => new sfValidatorPass(array('required' => false)),
      'color'                          => new sfValidatorPass(array('required' => false)),
      'talle'                          => new sfValidatorPass(array('required' => false)),
      'categoria'                      => new sfValidatorPass(array('required' => false)),
      'genero'                         => new sfValidatorPass(array('required' => false)),
      'precio_deluxe'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo'                          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cantidad'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bonificacion_devolucion_mp'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bonificacion_devolucion_deluxe' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bonificacion_motivo'            => new sfValidatorPass(array('required' => false)),
      'bonificacion_submotivo'         => new sfValidatorPass(array('required' => false)),
      'descuento'                      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'descuento_motivo'               => new sfValidatorPass(array('required' => false)),
      'descuento_codigo'               => new sfValidatorPass(array('required' => false)),
      'costo_envio'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_envio_deluxe'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'tipo_envio'                     => new sfValidatorPass(array('required' => false)),
      'venta_db_total'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_facturado'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cliente'                        => new sfValidatorPass(array('required' => false)),
      'localidad'                      => new sfValidatorPass(array('required' => false)),
      'provincia'                      => new sfValidatorPass(array('required' => false)),
      'forma_pago'                     => new sfValidatorPass(array('required' => false)),
      'id_eshop'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nombre_eshop'                   => new sfValidatorPass(array('required' => false)),
      'cliente_tipo_documento'         => new sfValidatorPass(array('required' => false)),
      'cliente_documento'              => new sfValidatorPass(array('required' => false)),
      'cliente_email'                  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reporte_cronologico_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reporteCronologico';
  }

  public function getFields()
  {
    return array(
      'id_reporte_cronologico'         => 'Number',
      'fecha'                          => 'Date',
      'accion'                         => 'Text',
      'id_pedido'                      => 'Number',
      'fuente'                         => 'Text',
      'marca'                          => 'Text',
      'condicion_fiscal'               => 'Text',
      'codigo_producto'                => 'Text',
      'producto'                       => 'Text',
      'color'                          => 'Text',
      'talle'                          => 'Text',
      'categoria'                      => 'Text',
      'genero'                         => 'Text',
      'precio_deluxe'                  => 'Number',
      'costo'                          => 'Number',
      'cantidad'                       => 'Number',
      'bonificacion_devolucion_mp'     => 'Number',
      'bonificacion_devolucion_deluxe' => 'Number',
      'bonificacion_motivo'            => 'Text',
      'bonificacion_submotivo'         => 'Text',
      'descuento'                      => 'Number',
      'descuento_motivo'               => 'Text',
      'descuento_codigo'               => 'Text',
      'costo_envio'                    => 'Number',
      'costo_envio_deluxe'             => 'Number',
      'tipo_envio'                     => 'Text',
      'venta_db_total'                 => 'Number',
      'total_facturado'                => 'Number',
      'cliente'                        => 'Text',
      'localidad'                      => 'Text',
      'provincia'                      => 'Text',
      'forma_pago'                     => 'Text',
      'id_eshop'                       => 'Number',
      'nombre_eshop'                   => 'Text',
      'cliente_tipo_documento'         => 'Text',
      'cliente_documento'              => 'Text',
      'cliente_email'                  => 'Text',
    );
  }
}
