<?php

/**
 * reporteVentasPeriodo filter form base class.
 *
 * @package    deluxebuys
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasereporteVentasPeriodoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'total_dinero_ingresado_flash'      => new sfWidgetFormFilterInput(),
      'total_dinero_ingresado_permanente' => new sfWidgetFormFilterInput(),
      'total_dinero_ingresado_mixto'      => new sfWidgetFormFilterInput(),
      'venta_total_flash'                 => new sfWidgetFormFilterInput(),
      'venta_total_permanente'            => new sfWidgetFormFilterInput(),
      'costo_mercaderia_flash'            => new sfWidgetFormFilterInput(),
      'costo_mercaderia_permanente'       => new sfWidgetFormFilterInput(),
      'costo_envio_flash'                 => new sfWidgetFormFilterInput(),
      'costo_envio_permanente'            => new sfWidgetFormFilterInput(),
      'costo_envio_mixto'                 => new sfWidgetFormFilterInput(),
      'comisiones_flash'                  => new sfWidgetFormFilterInput(),
      'comisiones_permanente'             => new sfWidgetFormFilterInput(),
      'comisiones_mixto'                  => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_flash'            => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_permanente'       => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_mixto'            => new sfWidgetFormFilterInput(),
      'unidades_flash'                    => new sfWidgetFormFilterInput(),
      'unidades_permanente'               => new sfWidgetFormFilterInput(),
      'descuentos_usados_flash'           => new sfWidgetFormFilterInput(),
      'descuentos_usados_permanente'      => new sfWidgetFormFilterInput(),
      'descuentos_usados_mixto'           => new sfWidgetFormFilterInput(),
      'bonificaciones_usados_flash'       => new sfWidgetFormFilterInput(),
      'bonificaciones_usados_permanente'  => new sfWidgetFormFilterInput(),
      'bonificaciones_usados_mixto'       => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_0_50'             => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_50_100'           => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_100_200'          => new sfWidgetFormFilterInput(),
      'cantidad_pedidos_200_mas'          => new sfWidgetFormFilterInput(),
      'cliente_primera_compra'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'total_dinero_ingresado_flash'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_dinero_ingresado_permanente' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_dinero_ingresado_mixto'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'venta_total_flash'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'venta_total_permanente'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_mercaderia_flash'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_mercaderia_permanente'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_envio_flash'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_envio_permanente'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'costo_envio_mixto'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'comisiones_flash'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'comisiones_permanente'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'comisiones_mixto'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cantidad_pedidos_flash'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_pedidos_permanente'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_pedidos_mixto'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'unidades_flash'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'unidades_permanente'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'descuentos_usados_flash'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'descuentos_usados_permanente'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'descuentos_usados_mixto'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bonificaciones_usados_flash'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bonificaciones_usados_permanente'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'bonificaciones_usados_mixto'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'cantidad_pedidos_0_50'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_pedidos_50_100'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_pedidos_100_200'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cantidad_pedidos_200_mas'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cliente_primera_compra'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('reporte_ventas_periodo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reporteVentasPeriodo';
  }

  public function getFields()
  {
    return array(
      'fecha'                             => 'Date',
      'total_dinero_ingresado_flash'      => 'Number',
      'total_dinero_ingresado_permanente' => 'Number',
      'total_dinero_ingresado_mixto'      => 'Number',
      'venta_total_flash'                 => 'Number',
      'venta_total_permanente'            => 'Number',
      'costo_mercaderia_flash'            => 'Number',
      'costo_mercaderia_permanente'       => 'Number',
      'costo_envio_flash'                 => 'Number',
      'costo_envio_permanente'            => 'Number',
      'costo_envio_mixto'                 => 'Number',
      'comisiones_flash'                  => 'Number',
      'comisiones_permanente'             => 'Number',
      'comisiones_mixto'                  => 'Number',
      'cantidad_pedidos_flash'            => 'Number',
      'cantidad_pedidos_permanente'       => 'Number',
      'cantidad_pedidos_mixto'            => 'Number',
      'unidades_flash'                    => 'Number',
      'unidades_permanente'               => 'Number',
      'descuentos_usados_flash'           => 'Number',
      'descuentos_usados_permanente'      => 'Number',
      'descuentos_usados_mixto'           => 'Number',
      'bonificaciones_usados_flash'       => 'Number',
      'bonificaciones_usados_permanente'  => 'Number',
      'bonificaciones_usados_mixto'       => 'Number',
      'cantidad_pedidos_0_50'             => 'Number',
      'cantidad_pedidos_50_100'           => 'Number',
      'cantidad_pedidos_100_200'          => 'Number',
      'cantidad_pedidos_200_mas'          => 'Number',
      'cliente_primera_compra'            => 'Number',
    );
  }
}
