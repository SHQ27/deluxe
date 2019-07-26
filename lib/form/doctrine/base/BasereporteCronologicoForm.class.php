<?php

/**
 * reporteCronologico form base class.
 *
 * @method reporteCronologico getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasereporteCronologicoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_reporte_cronologico'         => new sfWidgetFormInputHidden(),
      'fecha'                          => new sfWidgetFormDateTime(),
      'accion'                         => new sfWidgetFormInputText(),
      'id_pedido'                      => new sfWidgetFormInputText(),
      'fuente'                         => new sfWidgetFormInputText(),
      'marca'                          => new sfWidgetFormInputText(),
      'condicion_fiscal'               => new sfWidgetFormInputText(),
      'codigo_producto'                => new sfWidgetFormInputText(),
      'producto'                       => new sfWidgetFormInputText(),
      'color'                          => new sfWidgetFormInputText(),
      'talle'                          => new sfWidgetFormInputText(),
      'categoria'                      => new sfWidgetFormInputText(),
      'genero'                         => new sfWidgetFormInputText(),
      'precio_deluxe'                  => new sfWidgetFormInputText(),
      'costo'                          => new sfWidgetFormInputText(),
      'cantidad'                       => new sfWidgetFormInputText(),
      'bonificacion_devolucion_mp'     => new sfWidgetFormInputText(),
      'bonificacion_devolucion_deluxe' => new sfWidgetFormInputText(),
      'bonificacion_motivo'            => new sfWidgetFormInputText(),
      'bonificacion_submotivo'         => new sfWidgetFormInputText(),
      'descuento'                      => new sfWidgetFormInputText(),
      'descuento_motivo'               => new sfWidgetFormInputText(),
      'descuento_codigo'               => new sfWidgetFormInputText(),
      'costo_envio'                    => new sfWidgetFormInputText(),
      'costo_envio_deluxe'             => new sfWidgetFormInputText(),
      'tipo_envio'                     => new sfWidgetFormInputText(),
      'venta_db_total'                 => new sfWidgetFormInputText(),
      'total_facturado'                => new sfWidgetFormInputText(),
      'cliente'                        => new sfWidgetFormInputText(),
      'localidad'                      => new sfWidgetFormInputText(),
      'provincia'                      => new sfWidgetFormInputText(),
      'forma_pago'                     => new sfWidgetFormInputText(),
      'id_eshop'                       => new sfWidgetFormInputText(),
      'nombre_eshop'                   => new sfWidgetFormInputText(),
      'cliente_tipo_documento'         => new sfWidgetFormInputText(),
      'cliente_documento'              => new sfWidgetFormInputText(),
      'cliente_email'                  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_reporte_cronologico'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_reporte_cronologico')), 'empty_value' => $this->getObject()->get('id_reporte_cronologico'), 'required' => false)),
      'fecha'                          => new sfValidatorDateTime(),
      'accion'                         => new sfValidatorString(array('max_length' => 255)),
      'id_pedido'                      => new sfValidatorInteger(array('required' => false)),
      'fuente'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'marca'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'condicion_fiscal'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'codigo_producto'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'producto'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'color'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'talle'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'categoria'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'genero'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'precio_deluxe'                  => new sfValidatorNumber(array('required' => false)),
      'costo'                          => new sfValidatorNumber(array('required' => false)),
      'cantidad'                       => new sfValidatorInteger(array('required' => false)),
      'bonificacion_devolucion_mp'     => new sfValidatorNumber(array('required' => false)),
      'bonificacion_devolucion_deluxe' => new sfValidatorNumber(array('required' => false)),
      'bonificacion_motivo'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'bonificacion_submotivo'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'descuento'                      => new sfValidatorNumber(array('required' => false)),
      'descuento_motivo'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'descuento_codigo'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'costo_envio'                    => new sfValidatorNumber(array('required' => false)),
      'costo_envio_deluxe'             => new sfValidatorNumber(array('required' => false)),
      'tipo_envio'                     => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'venta_db_total'                 => new sfValidatorNumber(array('required' => false)),
      'total_facturado'                => new sfValidatorNumber(array('required' => false)),
      'cliente'                        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'localidad'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'provincia'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'forma_pago'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_eshop'                       => new sfValidatorInteger(array('required' => false)),
      'nombre_eshop'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cliente_tipo_documento'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cliente_documento'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cliente_email'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reporte_cronologico[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'reporteCronologico';
  }

}
