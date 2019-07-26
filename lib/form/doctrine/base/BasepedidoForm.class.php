<?php

/**
 * pedido form base class.
 *
 * @method pedido getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepedidoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_pedido'                    => new sfWidgetFormInputHidden(),
      'id_usuario'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'), 'add_empty' => false)),
      'fecha_alta'                   => new sfWidgetFormDateTime(),
      'fecha_baja'                   => new sfWidgetFormDateTime(),
      'fecha_pago'                   => new sfWidgetFormDateTime(),
      'fecha_aviso_pago'             => new sfWidgetFormDateTime(),
      'fecha_envio'                  => new sfWidgetFormDateTime(),
      'fecha_facturacion'            => new sfWidgetFormDateTime(),
      'fecha_ultima_comprobacion'    => new sfWidgetFormDateTime(),
      'fecha_limite_pago'            => new sfWidgetFormDateTime(),
      'nombre'                       => new sfWidgetFormInputText(),
      'apellido'                     => new sfWidgetFormInputText(),
      'tipo_documento'               => new sfWidgetFormInputText(),
      'documento'                    => new sfWidgetFormInputText(),
      'email'                        => new sfWidgetFormInputText(),
      'telefono'                     => new sfWidgetFormInputText(),
      'celular'                      => new sfWidgetFormInputText(),
      'observaciones'                => new sfWidgetFormTextarea(),
      'id_forma_pago'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'add_empty' => true)),
      'envio_tipo'                   => new sfWidgetFormInputText(),
      'envio_destinatario'           => new sfWidgetFormInputText(),
      'envio_calle'                  => new sfWidgetFormInputText(),
      'envio_numero'                 => new sfWidgetFormInputText(),
      'envio_piso'                   => new sfWidgetFormInputText(),
      'envio_depto'                  => new sfWidgetFormInputText(),
      'envio_codigo_postal'          => new sfWidgetFormInputText(),
      'envio_id_sucursal'            => new sfWidgetFormInputText(),
      'envio_id_provincia'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'add_empty' => true)),
      'envio_localidad'              => new sfWidgetFormInputText(),
      'envio_correo'                 => new sfWidgetFormInputText(),
      'envio_servicio'               => new sfWidgetFormInputText(),
      'envio_detalle'                => new sfWidgetFormTextarea(),
      'envio_id_pedido_envio_pack'   => new sfWidgetFormInputText(),
      'monto_envio'                  => new sfWidgetFormInputText(),
      'monto_envio_deluxe'           => new sfWidgetFormInputText(),
      'monto_productos'              => new sfWidgetFormInputText(),
      'monto_bonificacion'           => new sfWidgetFormInputText(),
      'monto_descuento'              => new sfWidgetFormInputText(),
      'monto_total'                  => new sfWidgetFormInputText(),
      'monto_facturacion'            => new sfWidgetFormInputText(),
      'cuotas'                       => new sfWidgetFormInputText(),
      'interes'                      => new sfWidgetFormInputText(),
      'datos_pago'                   => new sfWidgetFormTextarea(),
      'codigo_envio'                 => new sfWidgetFormInputText(),
      'nota'                         => new sfWidgetFormTextarea(),
      'requiere_intervencion_manual' => new sfWidgetFormInputText(),
      'tipo_producto'                => new sfWidgetFormInputText(),
      'tiene_problema_oca'           => new sfWidgetFormInputCheckbox(),
      'id_eshop'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'add_empty' => true)),
      'source'                       => new sfWidgetFormInputText(),
      'fecha_source'                 => new sfWidgetFormDateTime(),
      'utm_campaign'                 => new sfWidgetFormInputText(),
      'utm_term'                     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_pedido'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_pedido')), 'empty_value' => $this->getObject()->get('id_pedido'), 'required' => false)),
      'id_usuario'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('usuario'))),
      'fecha_alta'                   => new sfValidatorDateTime(),
      'fecha_baja'                   => new sfValidatorDateTime(array('required' => false)),
      'fecha_pago'                   => new sfValidatorDateTime(array('required' => false)),
      'fecha_aviso_pago'             => new sfValidatorDateTime(array('required' => false)),
      'fecha_envio'                  => new sfValidatorDateTime(array('required' => false)),
      'fecha_facturacion'            => new sfValidatorDateTime(array('required' => false)),
      'fecha_ultima_comprobacion'    => new sfValidatorDateTime(array('required' => false)),
      'fecha_limite_pago'            => new sfValidatorDateTime(array('required' => false)),
      'nombre'                       => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'apellido'                     => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'tipo_documento'               => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'documento'                    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'email'                        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'telefono'                     => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'celular'                      => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'observaciones'                => new sfValidatorString(array('required' => false)),
      'id_forma_pago'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('formaPago'), 'required' => false)),
      'envio_tipo'                   => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'envio_destinatario'           => new sfValidatorString(array('max_length' => 60, 'required' => false)),
      'envio_calle'                  => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'envio_numero'                 => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'envio_piso'                   => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'envio_depto'                  => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'envio_codigo_postal'          => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'envio_id_sucursal'            => new sfValidatorInteger(array('required' => false)),
      'envio_id_provincia'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('provincia'), 'required' => false)),
      'envio_localidad'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'envio_correo'                 => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'envio_servicio'               => new sfValidatorPass(array('required' => false)),
      'envio_detalle'                => new sfValidatorString(array('required' => false)),
      'envio_id_pedido_envio_pack'   => new sfValidatorInteger(array('required' => false)),
      'monto_envio'                  => new sfValidatorNumber(array('required' => false)),
      'monto_envio_deluxe'           => new sfValidatorNumber(array('required' => false)),
      'monto_productos'              => new sfValidatorNumber(array('required' => false)),
      'monto_bonificacion'           => new sfValidatorNumber(array('required' => false)),
      'monto_descuento'              => new sfValidatorNumber(array('required' => false)),
      'monto_total'                  => new sfValidatorNumber(array('required' => false)),
      'monto_facturacion'            => new sfValidatorNumber(array('required' => false)),
      'cuotas'                       => new sfValidatorInteger(array('required' => false)),
      'interes'                      => new sfValidatorNumber(array('required' => false)),
      'datos_pago'                   => new sfValidatorString(array('required' => false)),
      'codigo_envio'                 => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'nota'                         => new sfValidatorString(array('required' => false)),
      'requiere_intervencion_manual' => new sfValidatorInteger(array('required' => false)),
      'tipo_producto'                => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'tiene_problema_oca'           => new sfValidatorBoolean(array('required' => false)),
      'id_eshop'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('eshop'), 'required' => false)),
      'source'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fecha_source'                 => new sfValidatorDateTime(array('required' => false)),
      'utm_campaign'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'utm_term'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pedido[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'pedido';
  }

}
