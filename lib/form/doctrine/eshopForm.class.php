<?php

/**
 * eshop form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopForm extends BaseeshopForm
{
  public function configure()
  {        
    $eshop = $this->getObject();

    $this->getWidget('denominacion')->setAttributes( array('disabled' => 'disabled') );
    $this->getWidget('dominio')->setAttributes( array('disabled' => 'disabled') );
    $this->getWidget('id_marca')->setAttributes( array('disabled' => 'disabled') );
    $this->getWidget('id_producto_genero')->setAttributes( array('disabled' => 'disabled') );

    $this->getWidget('freeshipping')->setLabel( 'Monto a partir del cual se habilita el FreeShipping' );
    $this->getWidget('link_cace')->setLabel( 'Link de la CACE' );

    $this->setValidator('denominacion', new sfValidatorPass());
    $this->setValidator('dominio', new sfValidatorPass());
    $this->setValidator('id_marca', new sfValidatorPass());
    $this->setValidator('id_producto_genero', new sfValidatorPass());



    // Banner Listado
    $this->setWidget( "banner_listado", new sfWidgetFormInputFileEditable(
      imageHelper::getInstance()->getOptionForWidget('eshop_banner_listado', $eshop)
    ));
    
    $this->setValidator( "banner_listado", new sfValidatorFile (
      imageHelper::getInstance()->getOptionForValidator('eshop_banner_listado', $eshop),
      imageHelper::getInstance()->getMessagesForValidator('eshop_banner_listado')
    )); 
                    
    $this->setValidator( "banner_listado_delete", new sfValidatorBoolean() );



    // Banner Medios Pago en Detalle de Producto
    $this->setWidget( "banner_medios_pago_producto", new sfWidgetFormInputFileEditable(
      imageHelper::getInstance()->getOptionForWidget('eshop_medios_pagos_producto', $eshop)
    ));
    
    $this->setValidator( "banner_medios_pago_producto", new sfValidatorFile (
      imageHelper::getInstance()->getOptionForValidator('eshop_medios_pagos_producto', $eshop),
      imageHelper::getInstance()->getMessagesForValidator('eshop_medios_pagos_producto')
    )); 
                    
    $this->setValidator( "banner_medios_pago_producto_delete", new sfValidatorBoolean() );



    // Banner Medios Pago en Carrito
    $this->setWidget( "banner_medios_pago_carrito", new sfWidgetFormInputFileEditable(
      imageHelper::getInstance()->getOptionForWidget('eshop_medios_pagos_carrito', $eshop)
    ));
    
    $this->setValidator( "banner_medios_pago_carrito", new sfValidatorFile (
      imageHelper::getInstance()->getOptionForValidator('eshop_medios_pagos_carrito', $eshop),
      imageHelper::getInstance()->getMessagesForValidator('eshop_medios_pagos_carrito')
    )); 
                    
    $this->setValidator( "banner_medios_pago_carrito_delete", new sfValidatorBoolean() );



    // Lookbook
    $lookbookChoices = array(
          eshopLookbook::NO_USA   => 'No Usa',
          eshopLookbook::SIN_ZOOM => 'Usa - Sin Zoom',
          eshopLookbook::CON_ZOOM => 'Usa - Con Zoom'
    );

    $this->setWidget( 'lookbook', new sfWidgetFormChoice( array( 'choices' => $lookbookChoices)));
    $this->setValidator( 'lookbook', new sfValidatorChoice( array( 'choices' => array_keys($lookbookChoices) ) ) );

    $lookbookImagenesFilaChoices = array(
          1 => 1,
          2 => 2,
          3 => 3,
          4 => 4,
    );

    $this->setWidget( 'lookbook_imagenes_fila', new sfWidgetFormChoice( array( 'choices' => $lookbookImagenesFilaChoices)));
    $this->setValidator( 'lookbook_imagenes_fila', new sfValidatorChoice( array( 'choices' => array_keys($lookbookImagenesFilaChoices) ) ) );
  }
  
  protected function doSave($con = null)
  {
      $bannerListado = $this->getValue('banner_listado');
      unset($this->values['banner_listado']);

      $bannerMediosPagoProducto = $this->getValue('banner_medios_pago_producto');
      unset($this->values['banner_medios_pago_producto']);

      $bannerMediosPagoCarrito = $this->getValue('banner_medios_pago_carrito');
      unset($this->values['banner_medios_pago_carrito']);

      $eshop = $this->getObject();

      $eshop->setFreeshipping( $this->getValue('freeshipping') );
      $eshop->setDevolucionFreeshipping( $this->getValue('devolucion_freeshipping') );
      
      $eshop->setLookbook( $this->getValue('lookbook') );
      $eshop->setLookbookImagenesFila( $this->getValue('lookbook_imagenes_fila') );

      $eshop->setUsaCampaign( $this->getValue('usa_campaign') );

      $eshop->setTwitter( $this->getValue('twitter') );
      $eshop->setFacebook( $this->getValue('facebook') );
      $eshop->setInstagram( $this->getValue('instagram') );
      $eshop->setYoutube( $this->getValue('youtube') );
      $eshop->setSnapchat( $this->getValue('snapchat') );
      $eshop->setDataFiscal( $this->getValue('data_fiscal') );
      $eshop->setLinkCace( $this->getValue('link_cace') );
      $eshop->setMailRRHH( $this->getValue('mail_RRHH') );
      $eshop->setMailComercial( $this->getValue('mail_comercial') );
      
      $eshop->setUsaAcerca( $this->getValue('usa_acerca') );
      $eshop->setAcercaTitulo( $this->getValue('acerca_titulo') );
      $eshop->setAcercaTextoPrincipal( $this->getValue('acerca_texto_principal') );
      $eshop->setAcercaTextoSecundario( $this->getValue('acerca_texto_secundario') );

      $eshop->setTiendasTitulo( $this->getValue('mi_carro_titulo') );
      
      $eshop->setTiendasTitulo( $this->getValue('tiendas_titulo') );
      $eshop->setTiendasSubtitulo( $this->getValue('tiendas_subtitulo') );
      

      $eshop->setCampaignTitulo( $this->getValue('campaign_titulo') );
      $eshop->setLookbookTitulo( $this->getValue('lookbook_titulo') );


      $eshop->setLookbookTitulo( $this->getValue('lookbook_titulo') );

      $eshop->setTextoIniciarSesion(  $this->getValue('texto_iniciar_sesion')   );
      $eshop->setTextoSeguinos(       $this->getValue('texto_seguinos')         );
      $eshop->setTextoAgregarAlCarro( $this->getValue('texto_agregar_al_carro') );
      $eshop->setTextoCarroDeCompras( $this->getValue('texto_carro_de_compras')  );
      $eshop->setTextoSoyMiembro(     $this->getValue('texto_soy_miembro')      );
      $eshop->setTextoSoyNuevo(       $this->getValue('texto_soy_nuevo')        );
      $eshop->setTextoConsultas(      $this->getValue('texto_consultas')        );

      $eshop->save($con);  


      // Banner Listado
      imageHelper::getInstance()->processDeleteFile('eshop_banner_listado', $eshop, $this->getValue('banner_listado_delete') );

      if (isset($bannerListado))
      {
         imageHelper::getInstance()->processDeleteFile('eshop_banner_listado', $eshop, true);
         imageHelper::getInstance()->processSaveFile('eshop_banner_listado', $eshop, $bannerListado);
      }

      // Banner Medios Pago en Detalle de Producto
      imageHelper::getInstance()->processDeleteFile('eshop_medios_pagos_producto', $eshop, $this->getValue('banner_medios_pago_producto_delete') );

      if (isset($bannerMediosPagoProducto))
      {
         imageHelper::getInstance()->processDeleteFile('eshop_medios_pagos_producto', $eshop, true);
         imageHelper::getInstance()->processSaveFile('eshop_medios_pagos_producto', $eshop, $bannerMediosPagoProducto);
      }


      // Banner Medios Pago en Carrito
      imageHelper::getInstance()->processDeleteFile('eshop_medios_pagos_carrito', $eshop, $this->getValue('banner_medios_pago_carrito_delete') );

      if (isset($bannerMediosPagoCarrito))
      {
         imageHelper::getInstance()->processDeleteFile('eshop_medios_pagos_carrito', $eshop, true);
         imageHelper::getInstance()->processSaveFile('eshop_medios_pagos_carrito', $eshop, $bannerMediosPagoCarrito);
      }



  }
  
}