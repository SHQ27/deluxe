<?php

/**
 * reporteVentasPeriodo form base class.
 *
 * @method reporteVentasPeriodo getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasereporteVentasPeriodoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'                             => new sfWidgetFormInputHidden(),
      'total_dinero_ingresado_flash'      => new sfWidgetFormInputText(),
      'total_dinero_ingresado_permanente' => new sfWidgetFormInputText(),
      'total_dinero_ingresado_mixto'      => new sfWidgetFormInputText(),
      'venta_total_flash'                 => new sfWidgetFormInputText(),
      'venta_total_permanente'            => new sfWidgetFormInputText(),
      'costo_mercaderia_flash'            => new sfWidgetFormInputText(),
      'costo_mercaderia_permanente'       => new sfWidgetFormInputText(),
      'costo_envio_flash'                 => new sfWidgetFormInputText(),
      'costo_envio_permanente'            => new sfWidgetFormInputText(),
      'costo_envio_mixto'                 => new sfWidgetFormInputText(),
      'comisiones_flash'                  => new sfWidgetFormInputText(),
      'comisiones_permanente'             => new sfWidgetFormInputText(),
      'comisiones_mixto'                  => new sfWidgetFormInputText(),
      'cantidad_pedidos_flash'            => new sfWidgetFormInputText(),
      'cantidad_pedidos_permanente'       => new sfWidgetFormInputText(),
      'cantidad_pedidos_mixto'            => new sfWidgetFormInputText(),
      'unidades_flash'                    => new sfWidgetFormInputText(),
      'unidades_permanente'               => new sfWidgetFormInputText(),
      'descuentos_usados_flash'           => new sfWidgetFormInputText(),
      'descuentos_usados_permanente'      => new sfWidgetFormInputText(),
      'descuentos_usados_mixto'           => new sfWidgetFormInputText(),
      'bonificaciones_usados_flash'       => new sfWidgetFormInputText(),
      'bonificaciones_usados_permanente'  => new sfWidgetFormInputText(),
      'bonificaciones_usados_mixto'       => new sfWidgetFormInputText(),
      'cantidad_pedidos_0_50'             => new sfWidgetFormInputText(),
      'cantidad_pedidos_50_100'           => new sfWidgetFormInputText(),
      'cantidad_pedidos_100_200'          => new sfWidgetFormInputText(),
      'cantidad_pedidos_200_mas'          => new sfWidgetFormInputText(),
      'cliente_primera_compra'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'fecha'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('fecha')), 'empty_value' => $this->getObject()->get('fecha'), 'required' => false)),
      'total_dinero_ingresado_flash'      => new sfValidatorNumber(array('required' => false)),
      'total_dinero_ingresado_permanente' => new sfValidatorNumber(array('required' => false)),
      'total_dinero_ingresado_mixto'      => new sfValidatorNumber(array('required' => false)),
      'venta_total_flash'                 => new sfValidatorNumber(array('required' => false)),
      'venta_total_permanente'            => new sfValidatorNumber(array('required' => false)),
      'costo_mercaderia_flash'            => new sfValidatorNumber(array('required' => false)),
      'costo_mercaderia_permanente'       => new sfValidatorNumber(array('required' => false)),
      'costo_envio_flash'                 => new sfValidatorNumber(array('required' => false)),
      'costo_envio_permanente'            => new sfValidatorNumber(array('required' => false)),
      'costo_envio_mixto'                 => new sfValidatorNumber(array('required' => false)),
      'comisiones_flash'                  => new sfValidatorNumber(array('required' => false)),
      'comisiones_permanente'             => new sfValidatorNumber(array('required' => false)),
      'comisiones_mixto'                  => new sfValidatorNumber(array('required' => false)),
      'cantidad_pedidos_flash'            => new sfValidatorInteger(array('required' => false)),
      'cantidad_pedidos_permanente'       => new sfValidatorInteger(array('required' => false)),
      'cantidad_pedidos_mixto'            => new sfValidatorInteger(array('required' => false)),
      'unidades_flash'                    => new sfValidatorInteger(array('required' => false)),
      'unidades_permanente'               => new sfValidatorInteger(array('required' => false)),
      'descuentos_usados_flash'           => new sfValidatorNumber(array('required' => false)),
      'descuentos_usados_permanente'      => new sfValidatorNumber(array('required' => false)),
      'descuentos_usados_mixto'           => new sfValidatorNumber(array('required' => false)),
      'bonificaciones_usados_flash'       => new sfValidatorNumber(array('required' => false)),
      'bonificaciones_usados_permanente'  => new sfValidatorNumber(array('required' => false)),
      'bonificaciones_usados_mixto'       => new sfValidatorNumber(array('required' => false)),
      'cantidad_pedidos_0_50'             => new sfValidatorInteger(array('required' => false)),
      'cantidad_pedidos_50_100'           => new sfValidatorInteger(array('required' => false)),
      'cantidad_pedidos_100_200'          => new sfValidatorInteger(array('required' => false)),
      'cantidad_pedidos_200_mas'          => new sfValidatorInteger(array('required' => false)),
      'cliente_primera_compra'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reporte_ventas_periodo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reporteVentasPeriodo';
  }

}
