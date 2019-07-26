<?php

/**
 * eshop form base class.
 *
 * @method eshop getObject() Returns the current form's model object
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseeshopForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_eshop'                          => new sfWidgetFormInputHidden(),
      'denominacion'                      => new sfWidgetFormInputText(),
      'dominio'                           => new sfWidgetFormInputText(),
      'id_marca'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('marca'), 'add_empty' => false)),
      'id_producto_genero'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('productoGenero'), 'add_empty' => false)),
      'lookbook'                          => new sfWidgetFormInputText(),
      'lookbook_imagenes_fila'            => new sfWidgetFormInputText(),
      'usa_campaign'                      => new sfWidgetFormInputCheckbox(),
      'usa_menu_flotante'                 => new sfWidgetFormInputCheckbox(),
      'activo'                            => new sfWidgetFormInputCheckbox(),
      'facebook'                          => new sfWidgetFormInputText(),
      'twitter'                           => new sfWidgetFormInputText(),
      'instagram'                         => new sfWidgetFormInputText(),
      'youtube'                           => new sfWidgetFormInputText(),
      'snapchat'                          => new sfWidgetFormInputText(),
      'data_fiscal'                       => new sfWidgetFormInputText(),
      'usa_acerca'                        => new sfWidgetFormInputCheckbox(),
      'acerca_titulo'                     => new sfWidgetFormInputText(),
      'acerca_texto_principal'            => new sfWidgetFormTextarea(),
      'acerca_texto_secundario'           => new sfWidgetFormTextarea(),
      'tiendas_titulo'                    => new sfWidgetFormInputText(),
      'tiendas_subtitulo'                 => new sfWidgetFormInputText(),
      'mi_carro_titulo'                   => new sfWidgetFormInputText(),
      'mercado_pago_client_id'            => new sfWidgetFormInputText(),
      'mercado_pago_client_secret'        => new sfWidgetFormInputText(),
      'envio_pack_api_key'                => new sfWidgetFormInputText(),
      'envio_pack_secret_key'             => new sfWidgetFormInputText(),
      'envio_pack_direccion_envio'        => new sfWidgetFormInputText(),
      'razon_social'                      => new sfWidgetFormInputText(),
      'cuit'                              => new sfWidgetFormInputText(),
      'email_no_reply'                    => new sfWidgetFormInputText(),
      'ml_client_id'                      => new sfWidgetFormInputText(),
      'ml_client_secret'                  => new sfWidgetFormInputText(),
      'ml_id_usuario_interno'             => new sfWidgetFormInputText(),
      'ml_id_official_store'              => new sfWidgetFormInputText(),
      'link_color'                        => new sfWidgetFormInputText(),
      'lista_sendgrid'                    => new sfWidgetFormInputText(),
      'tags'                              => new sfWidgetFormTextarea(),
      'soporte_email'                     => new sfWidgetFormInputText(),
      'soporte_pass'                      => new sfWidgetFormInputText(),
      'freeshipping'                      => new sfWidgetFormInputText(),
      'link_cace'                         => new sfWidgetFormInputText(),
      'devolucion_restringida_categorias' => new sfWidgetFormInputText(),
      'devolucion_restringida_mensaje'    => new sfWidgetFormInputText(),
      'devolucion_freeshipping'           => new sfWidgetFormInputCheckbox(),
      'decidir_nro_comercio'              => new sfWidgetFormInputText(),
      'formulario_titulo'                 => new sfWidgetFormInputText(),
      'formulario_texto'                  => new sfWidgetFormTextarea(),
      'formulario_campos'                 => new sfWidgetFormTextarea(),
      'formulario_to'                     => new sfWidgetFormInputText(),
      'mail_RRHH'                         => new sfWidgetFormInputText(),
      'mail_comercial'                    => new sfWidgetFormInputText(),
      'lookbook_titulo'                   => new sfWidgetFormInputText(),
      'campaign_titulo'                   => new sfWidgetFormInputText(),
      'mails_OC'                          => new sfWidgetFormInputText(),
      'zendesk_config'                    => new sfWidgetFormTextarea(),
      'texto_iniciar_sesion'              => new sfWidgetFormInputText(),
      'texto_seguinos'                    => new sfWidgetFormInputText(),
      'texto_agregar_al_carro'            => new sfWidgetFormInputText(),
      'texto_carro_de_compras'            => new sfWidgetFormInputText(),
      'texto_soy_miembro'                 => new sfWidgetFormInputText(),
      'texto_soy_nuevo'                   => new sfWidgetFormInputText(),
      'texto_consultas'                   => new sfWidgetFormInputText(),
      'domicilio_comercial'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_eshop'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id_eshop')), 'empty_value' => $this->getObject()->get('id_eshop'), 'required' => false)),
      'denominacion'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dominio'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id_marca'                          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('marca'))),
      'id_producto_genero'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('productoGenero'))),
      'lookbook'                          => new sfValidatorPass(array('required' => false)),
      'lookbook_imagenes_fila'            => new sfValidatorInteger(array('required' => false)),
      'usa_campaign'                      => new sfValidatorBoolean(array('required' => false)),
      'usa_menu_flotante'                 => new sfValidatorBoolean(array('required' => false)),
      'activo'                            => new sfValidatorBoolean(array('required' => false)),
      'facebook'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'instagram'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'youtube'                           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'snapchat'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'data_fiscal'                       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'usa_acerca'                        => new sfValidatorBoolean(array('required' => false)),
      'acerca_titulo'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'acerca_texto_principal'            => new sfValidatorString(array('required' => false)),
      'acerca_texto_secundario'           => new sfValidatorString(array('required' => false)),
      'tiendas_titulo'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'tiendas_subtitulo'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mi_carro_titulo'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mercado_pago_client_id'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mercado_pago_client_secret'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'envio_pack_api_key'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'envio_pack_secret_key'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'envio_pack_direccion_envio'        => new sfValidatorInteger(array('required' => false)),
      'razon_social'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cuit'                              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_no_reply'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ml_client_id'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ml_client_secret'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ml_id_usuario_interno'             => new sfValidatorInteger(array('required' => false)),
      'ml_id_official_store'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link_color'                        => new sfValidatorPass(array('required' => false)),
      'lista_sendgrid'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'tags'                              => new sfValidatorString(array('required' => false)),
      'soporte_email'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'soporte_pass'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'freeshipping'                      => new sfValidatorInteger(array('required' => false)),
      'link_cace'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'devolucion_restringida_categorias' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'devolucion_restringida_mensaje'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'devolucion_freeshipping'           => new sfValidatorBoolean(array('required' => false)),
      'decidir_nro_comercio'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'formulario_titulo'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'formulario_texto'                  => new sfValidatorString(array('required' => false)),
      'formulario_campos'                 => new sfValidatorString(array('required' => false)),
      'formulario_to'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mail_RRHH'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mail_comercial'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'lookbook_titulo'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'campaign_titulo'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mails_OC'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'zendesk_config'                    => new sfValidatorString(array('required' => false)),
      'texto_iniciar_sesion'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto_seguinos'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto_agregar_al_carro'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto_carro_de_compras'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto_soy_miembro'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto_soy_nuevo'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'texto_consultas'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'domicilio_comercial'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eshop[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'eshop';
  }

}
