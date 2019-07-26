<?php

class contactoForm extends sfFormSymfony
{    
    
    public static $choicesMotivoDeluxe = array
    (
            'saber_fecha_despacho' => 'Saber Fecha despacho',
            'problemas_con_el_pago' => 'Problemas con el pago',
            'devolucion_del_producto_comprado' => 'Devolucion del producto comprado',
            'como_usar_las_bonificaciones' => 'Como usar las bonificaciones',
            'problemas_con_oca' => 'Problemas con el correo',
            'reintegros_y_creditos' => 'Reintegros y Creditos',
            'contactarme_con_el_area_comercial' => 'Contactarme con el area comercial',
            'otras' => 'Otros'
    );
    
    public static $choicesSubMotivoDeluxe = array (
            'saber_fecha_despacho' => array (  'pedido_retrasado' => 'Pedido retrasado',
                    'saber_numero_de_ruta' => 'Saber numero de ruta'
            ),
            'problemas_con_el_pago' => array(
                    'tengo_problemas_para_pagar_con_tarjeta_de_credito' => 'Tengo problemas para pagar con tarjeta de credito',
                    'tengo_problemas_para_abonar_con_pagofacil_o_rapipago' => 'Tengo problemas para abonar con pagofacil o rapipago',
                    'tengo_problemas_con_mercadopago_al_momento_de_pagar' => 'Tengo problemas con mercadopago al momento de pagar',
                    'al_momento_de_pagar_me_piden_una_validacion_extra' => 'Al momento de pagar me piden una validacion extra',
                    'mi_pedido_ingreso_fuera_de_plazo' => 'Mi pedido ingreso fuera de plazo',
                    'mi_pedido_sigue_apareciendo_como_pendiente_de_pago.' => 'Mi pedido sigue apareciendo como pendiente de pago.'
            ),
            'devolucion_del_producto_comprado' => array(
                    'quisiera_conocer_la_politica_de_devoluciones' => 'Quisiera conocer la politica de devoluciones',
                    'quisiera_cambiar_el_producto_porque_no_me_gusto' => 'Quisiera cambiar el producto porque no me gusto',
                    'el_producto_que_recibi_estaba_fallado_o_me_vino_en_malas_condiciones' => 'El producto que recibi estaba fallado o me vino en malas condiciones',
                    'recibi_mi_pedido_pero_estaba_incompleto' => 'Recibi mi pedido pero estaba incompleto',
                    'recibi_un_pedido_incorrecto' => 'Recibi un pedido incorrecto'
    
            ),
            'como_usar_las_bonificaciones' => array(
                    'como_uso_el_credito_que_tenia_a_mi_favor' => 'Como uso el credito que tenia a mi favor',
                    'compre_un_cupon_en_un_sitio_de_descuento' => 'Compre un cupon en un sitio de descuento (Ej: Groupon Pez Urbano Clubcupon) y necesito saber como usarlo.'
            ),
            'problemas_con_oca' => array(
                    'no_pasaron_a_dejar_el_pedido' => 'No pasaron a dejar el pedido',
                    'antes_de_enviarlo_quisiera_cambiar_el_lugar_el_domicilio_de_entrega' => 'Antes de enviarlo quisiera cambiar el lugar el domicilio de entrega',
                    'el_estado_de_mi_pedido_dice_devuelto_al_remitente' => 'El estado de mi pedido dice: Devuelto al remitente',
                    'no_recibo_informacion_por_parte_de_oca' => 'No recibo informacion por parte del correo'
            ),
            'reintegros_y_creditos' => array(
                    'aun_no_se_acredito_el_dinero_por_mi_devolucion' => 'Aun no se acredito el dinero por mi devolucion',
                    'mercadopago_aun_no_me_devolvio_el_dinero_de_mi_compra' => 'Mercadopago aun no me devolvio el dinero de mi compra'
            ),
            'contactarme_con_el_area_comercial' => array(
                    'quiero_hacer_una_compra_mayorista' => 'Quiero hacer una compra mayorista',
                    'quiero_vender_mis_productos_en_deluxebuys' => 'Quiero vender mis productos en Deluxebuys'
            ),
            'otras' => array( 'otras_' => 'Otras')
    );

    
    public static $choicesMotivoEshop = array
    (
        'saber_fecha_despacho' => 'Saber Fecha despacho',
        'problemas_con_el_pago' => 'Problemas con el pago',
        'devolucion_del_producto_comprado' => 'Devolucion del producto comprado',
        'problemas_con_oca' => 'Problemas con el correo',
        'reintegros_y_creditos' => 'Reintegros y Creditos',
        'otras' => 'Otros'
    );
    
    
    public static $choicesSubMotivoEshop = array (
        'saber_fecha_despacho' => array (
            'saber_numero_de_ruta' => 'Saber numero de ruta'
        ),
        'problemas_con_el_pago' => array(
            'tengo_problemas_para_pagar_con_tarjeta_de_credito' => 'Tengo problemas para pagar con tarjeta de credito',
            'tengo_problemas_para_abonar_con_pagofacil_o_rapipago' => 'Tengo problemas para abonar con pagofacil o rapipago',
            'tengo_problemas_con_mercadopago_al_momento_de_pagar' => 'Tengo problemas con mercadopago al momento de pagar',
            'al_momento_de_pagar_me_piden_una_validacion_extra' => 'Al momento de pagar me piden una validacion extra',
            'mi_pedido_sigue_apareciendo_como_pendiente_de_pago.' => 'Mi pedido sigue apareciendo como pendiente de pago.'
        ),
        'devolucion_del_producto_comprado' => array(
            'quisiera_conocer_la_politica_de_devoluciones' => 'Quisiera conocer la politica de devoluciones',
            'recibi_un_pedido_incorrecto' => 'Recibi un pedido incorrecto'
    
        ),
        'como_usar_las_bonificaciones' => array(
        ),
        'problemas_con_oca' => array(
            'no_pasaron_a_dejar_el_pedido' => 'No pasaron a dejar el pedido',
            'antes_de_enviarlo_quisiera_cambiar_el_lugar_el_domicilio_de_entrega' => 'Antes de enviarlo quisiera cambiar el lugar el domicilio de entrega',
            'el_estado_de_mi_pedido_dice_devuelto_al_remitente' => 'El estado de mi pedido dice: Devuelto al remitente',
            'no_recibo_informacion_por_parte_de_oca' => 'No recibo informacion por parte de el correo'
        ),
        'reintegros_y_creditos' => array(
            'mercadopago_aun_no_me_devolvio_el_dinero_de_mi_compra' => 'Mercadopago aun no me devolvio el dinero de mi compra'
        ),
        'otras' => array( 'otras_' => 'Otras')
    );
    
    
  	public function configure()
  	{  	
  	    $eshop = $this->getOption('eshop');
  	    
  	    $choicesMotivos = ( $eshop ) ? self::$choicesMotivoEshop : self::$choicesMotivoDeluxe;
  	    $choicesSubMotivo = ( $eshop ) ? self::$choicesSubMotivoEshop : self::$choicesSubMotivoDeluxe;  	    
  	    
  	    $choicesMarca = array('' => '');
  	    $marcas = marcaTable::getInstance()->listAllOrdered();
  	    foreach( $marcas as $marca ) $choicesMarca[ $marca->getNombre() ] = $marca->getNombre();
  	      	    
	    $this->setWidgets(
	    	array
	    	(
				'nombre' => new sfWidgetFormInput(),
				'email' => new sfWidgetFormInput(),
				'motivo' => new sfWidgetFormSelect(array('choices' => $choicesMotivos)),
				'id_pedido' => new sfWidgetFormInput(),
				'mensaje' => new sfWidgetFormTextarea()
	    	)
	    );
	    	    
		
	
	    $this->setValidators
	    (
	    	array
	    	(
		    	'nombre' => new sfValidatorString(array('required' => true)),		    	
		    	'email' => new sfValidatorEmail(array('required' => true)),
		    	'motivo' => new sfValidatorString(array('required' => true)),
	    		'sub_motivo' => new sfValidatorString(array('required' => true)),
	    		'id_pedido' => new sfValidatorString(array('required' => false)),
				'mensaje' => new sfValidatorString(array('required' => true))
	    	)
	    );
	    
	    if ( $eshop ) {
	        $this->setWidget('marca', new sfWidgetFormInputHidden() );
	        $this->setValidator('marca', new sfValidatorString(array('required' => false)) );
	        $this->setDefault('marca', $eshop->getMarca() );
	    } else {
	        $this->setWidget('marca', new sfWidgetFormInputHidden() );
	        $this->setValidator('marca', new sfValidatorString(array('required' => false)) );
	    }
	    	    
	    $this->setWidget('sub_motivo', new sfWidgetFormArrayDependentSelect( array ( 'callable' => $choicesSubMotivo, 'depends' => 'motivo' ) ) );
	    
	    $this->getWidgetSchema()->setNameFormat('contacto[%s]');
	    
  	}
  			

    public function sentToMail()
    {       
        $eshop = $this->getOption('eshop');
        $eshopDenominacion = ( $eshop ) ? $eshop->getDenominacion() : 'DeluxeBuys';

        $choicesMotivos = ( $eshop ) ? self::$choicesMotivoEshop : self::$choicesMotivoDeluxe;
        $choicesSubMotivo = ( $eshop ) ? self::$choicesSubMotivoEshop : self::$choicesSubMotivoDeluxe;
        

        $nombre     = $this->getValue('nombre');
        $email      = $this->getValue('email');
        $motivo     = $this->getValue('motivo');
        $submotivo  = $this->getValue('sub_motivo');
        $marca      = $this->getValue('marca');
        
        $idPedido   = $this->getValue('id_pedido');
        $mensaje    = $this->getValue('mensaje');
        
        $motivoDenominacion = $choicesMotivos[$motivo];
        $submotivoDenominacion = $choicesSubMotivo[$motivo][$submotivo];
        
        $subject = "$motivoDenominacion ($submotivoDenominacion) - $nombre";
        
        $cantPedidos = pedidoTable::getInstance()->countPagadosByEmail( $email );
        
        if ( $cantPedidos <= 2 ) {
            $experiencia = '* (1 Estrella)';
        } else if ( $cantPedidos <= 7 ) {
            $experiencia = '** (2 Estrellas)';
        } else {
            $experiencia = '*** (3 Estrellas)';
        }
    
        $title = 'Nuevo Contacto';

        $params = array(
            'eshop'                 => $eshop,
            'title'                 => $title,
            'nombre'                => $nombre,
            'email'                 => $email,
            'motivoDenominacion'    => $motivoDenominacion,
            'submotivoDenominacion' => $submotivoDenominacion,
            'idPedido'              => $idPedido,
            'eshopDenominacion'     => $eshopDenominacion,
            'experiencia'           => $experiencia,
            'mensaje'               => $mensaje
        );


        $emailTo =  sfConfig::get('app_email_contacto_' . $eshop->getIdEshop());

        $mailer = new Mailer('contacto', $params);
        $params['ReplyToAddresses'] = $email;
        $mailer->send( $title, $emailTo, sfConfig::get('app_contacto_from_email'), $params );
    }

}
