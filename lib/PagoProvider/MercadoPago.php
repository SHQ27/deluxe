<?php

class MercadoPago extends PagoProvider
{
	protected function __construct() { }

	public function doCheckout( $pedido, $proveedorPago = null, $params = array() )
	{
	    $credentials = $this->getEshopCredentials( $pedido->getEshop() );


		if ( $pedido->getIdEshop() ) {
			$accessToken = EnvioPack::getInstance( $pedido->getIdEshop() )->getSplitPagoMercadoPagoAccessToken();
			$title = 'Pedido ' . $pedido->getIdPedido() . ' en ' . $pedido->getEshop()->getDenominacion();		    
			$mp = new MP( $accessToken );
		} else {
		    $title = 'Pedido ' . $pedido->getIdPedido() . ' en Deluxe Buys';
		    $mp = new MP( $credentials['client_id'], $credentials['client_secret'] );
		}

		$mp->sandbox_mode(false);

		$preference_data = array();

		// Se setea un unico item con el nombre del pedido
		$preference_data['items'] = array(
			array(
		       	'id' => $pedido->getIdPedido(),
		       	'title' => $title,
		       	'quantity' => 1,
		       	'currency_id' => 'ARS',
		       	'unit_price' => (float) $pedido->getMontoTotal()
	       )
	    );

		// Se setea la informacion del comprador
	    $preference_data['payer'] = array(
	    	'name' => $pedido->getNombre(),
	    	'surname' => $pedido->getApellido(),
	    	'email' => $pedido->getEmail()
    	);

		// Se setean las urls de respuesta
	    $preference_data['back_urls'] = array(
	    	'success' => sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_RetornoMercadoPago_correcto', 'idPedido' => $pedido->getIdPedido() ), true ),
	    	'failure' => sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_RetornoMercadoPago_fallo', 'idPedido' => $pedido->getIdPedido() ), true ),
	    	'pending' => sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_RetornoMercadoPago_pendiente', 'idPedido' => $pedido->getIdPedido() ), true )
    	);

		$preference_data['notification_url'] = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_RespuestaMercadoPago'), true );

	    $preference_data['auto_return'] = 'approved';

	    // Se excluyen los medidos de pago offline, si corresponde
		$paymentMethods = array();
		if ( $pedido->getTipoProducto() == pedido::PRODUCTO_TIPO_OUTLET )
		{
		    $paymentMethods = $this->excluirPagosOfflineOutlet( $pedido );  
		}
		else if ( $pedido->getTipoProducto() == pedido::PRODUCTO_TIPO_OFERTA )
		{
		    $paymentMethods = $this->excluirPagosOfflineCampana( $pedido );	    
		}
 		else if ( $pedido->getIdEshop() == eshop::RIE )
 		{
 		    $paymentMethods = $this->excluirPagosOffline();
 		}
		
    	$preference_data['payment_methods'] = $paymentMethods;


		// Se setean variables generales
    	$preference_data['external_reference'] = $pedido->getIdPedido();
    	$preference_data['expires'] = true;

		$from = new DateTime('now');
    	$preference_data['expiration_date_from'] = date('Y-m-d\TH:i:s') . '.000' . date('P');
    	$preference_data['expiration_date_to'] = date('Y-m-d\TH:i:s', strtotime( $pedido->getFechaLimitePago() )) . '.000' . date('P');


		if ( $pedido->getIdEshop() ) {
    		$preference_data['marketplace_fee'] = (float) $pedido->getMontoEnvioDeluxe();
    	}

    	// Se crea la preferencia
		$preference = $mp->create_preference($preference_data);

		$response = $preference['response'];

		$checkoutURL = $response['init_point'];
      	$checkoutURL = base64_encode( $checkoutURL );
    	$redirectURL = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_iniciar', 'idPedido' => $pedido->getIdPedido(), 'checkoutURL' => $checkoutURL ), true );
    	header( 'Location: ' . $redirectURL);
	}

	public function makeResponse($data)
	{
		$idPedido   = $data['id_pedido'];
		$pagos      = $data['pagos'];
		$montoTotal = $data['total'];

		$modalidad = false;
		$estado = false;
		$estadoDescripcion = '';
		$montoPagado = 0;

		foreach ($pagos as $pago) {

			// Si algun pago es offline el pedido se marca como modalidad offline
			if ( $modalidad != 'OFF' ) {
				$modalidad = $this->getModalidad( $pago['payment_type'] );	
			}
			
			/* Si algun pago esta aprobado se suma el monto pagado para luego comparar
			 * mas abajo si esta pagada la totalidad del pedido
			 */
			if($pago['status'] == 'approved'){
	    		$montoPagado += $pago['transaction_amount'];
	    	} else {

				/* Entre los estados P y C se prioriza al estado C si al menos
				 * un pago esta en dicho estado, el pedido queda en estado C
				 */
	    		if ( $estado != 'C' ) {
					$estado = $this->getEstado( $pago['status'] );
					$estadoDescripcion .= $pago['status'] . ': ' . $pago['status_detail'] . '<br/>';
	    		} 
	    	}



		}

		// Si se pago la totalidad se lo marca en estado A
		if ( $montoPagado >= $montoTotal ) {
			$estado = 'A';
			$estadoDescripcion = 'Se recibió la totalidad del pago';
		} else {
			$estadoDescripcion = substr( $estadoDescripcion, 0, strlen($estadoDescripcion) - 5 );
		}

		$response = array
		(
			'modalidad'				=> $modalidad,
			'estado'				=> $estado,
			'estadoDescripcion'		=> $estadoDescripcion,
			'idPedido'				=> $idPedido,
			'total'					=> (float) $montoPagado
		);
		return $response;
	}

	public function procesar( $pagoNotificacion )
	{
		// Obtengo la informacion de Mercado Pago sobre el pedido
		$proveedorPagoResponse = $pagoNotificacion->getResponseArray();
		$idPedido = $pagoNotificacion->getIdPedido();

		if (!$proveedorPagoResponse)
		{
			return;
		}

		// Obtengo el pedido en base de datos
		$pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );

		// Actualizo los datos de pago
		$pedido->setDatosPago( json_encode($pagoNotificacion->getResponseArray()) );
		$pedido->save();

		// Empiezo a procesar
		$response = $this->verificarEnviadoMP( $pedido, $pagoNotificacion );
		if ( $response ) return $response;

 		$method = 'procesarPedido' . $proveedorPagoResponse['estado'];
 		$response = $this->$method( $pedido, $pagoNotificacion );
 		return $response;
	}

	public function consultar($idPedido, $idMerchantOrder = null)
	{
	    $pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );

	    // Accedo a la Api
		$credentials = $this->getEshopCredentials( $pedido->getEshop() );
		$mp = new MP( $credentials['client_id'], $credentials['client_secret'] );

		// Busco el pago
		if ( $idMerchantOrder ) {
			$response = $mp->get("/merchant_orders/" . $idMerchantOrder);

			// Se verifica que la respuesta sea valida
			if ( !isset( $response["response"]["payments"] ) ) return false;

			$payments = $response["response"]["payments"];

			$pagos = array();
			foreach ($payments as $payment) {
				$pago = $mp->get_payment( $payment['id'] ); 
				$pago = $pago['response']['collection'];
				$pagos[] = $pago;
			}

			$payments = $pagos;

		} else {
			$response = $mp->search_payment( array( 'external_reference' => $idPedido) );	

			// Se verifica que la respuesta sea valida
			if ( !isset( $response['response'] ) ) return false;
			if ( !isset( $response['response']['results'] ) ) return false;
			if ( !count( $response['response']['results'] ) ) return false;

			$payments = $response['response']['results'];

		}

		$data = array(
			'id_pedido' => $pedido->getIdPedido(),
			'total' 	=> $pedido->getMontoTotal(),
			'pagos' 	=> $payments
		);

		$response = $this->makeResponse( $data );

		if ( !$response['estado'] ) return false;

		// Actualizo la fecha de ultima comprobacion
		$pedido->setFechaUltimaComprobacion( new Doctrine_Expression('now()') );
		$pedido->save();

		return $response;
	}

	public function getReferencesByMerchantOrder($id, $eshop)
	{
	    // Accedo a la Api
	    $credentials = $this->getEshopCredentials( $eshop );
	    $mp = new MP( $credentials['client_id'], $credentials['client_secret'] );

		// Obtengo la info de mercado pago
	  	$data = $mp->get("/merchant_orders/" . $id);

	  	return array(
	  		'idPedido' => $data['response']['external_reference'],
	  		'idMerchantOrder' => $id,
  		);

	}

	public function getReferencesByPago($id, $eshop)
	{
	    // Accedo a la Api
	    $credentials = $this->getEshopCredentials( $eshop );
	    $mp = new MP( $credentials['client_id'], $credentials['client_secret'] );

		// Obtengo la info de mercado pago
	  	$data = $mp->get_payment_info($_GET["id"]);

	  	return array(
	  		'idPedido' => $data['response']['collection']['external_reference'],
	  		'idMerchantOrder' => $data['response']['collection']['merchant_order_id'],
  		);

	}

	public function cancelarPago( $pedido )
	{
	    // Obtengo el id del pedido en Mercado Pago
	    $datosPago = json_decode($pedido->getDatosPago(), true);

	    // Accedo a la Api
		$credentials = $this->getEshopCredentials( $pedido->getEshop() );
		$mp = new MP( $credentials['client_id'], $credentials['client_secret'] );

		// Busco los pagos asociados a un pedido
		$response = $mp->search_payment( array( 'external_reference' => $pedido->getIdPedido()) );
		if ( !isset( $response['response'] ) ) return false;
		if ( !isset( $response['response']['results'] ) ) return false;

		$pagos = $response['response']['results'];

		// Cancelo el pago		
		foreach ($pagos as $pago) {
			$pagoId = $pago['collection']['id'];
			$response = $mp->cancel_payment( $pagoId );
			if ( $response['status'] != 'cancelled' ) {
				return false;
			}
		}

	    return true;
	}

	protected function procesarPedidoC( $pedido, $pagoNotificacion )
	{
		$gestionarStock = true;
	    if ( $proveedorPagoResponse['estadoDescripcion'] === 'refunded: refunded' ) {
	    	$gestionarStock = false;
	    }

		return $this->procesarPedidoRechazado( $pedido, $pagoNotificacion, $gestionarStock );
	}


	protected function procesarPedidoA( $pedido, $pagoNotificacion )
	{
		return $this->procesarPedidoAprobado( $pedido, $pagoNotificacion );
	}


	protected function procesarPedidoP( $pedido, $pagoNotificacion )
	{
		$proveedorPagoResponse = $pagoNotificacion->getResponseArray();

		$pagoNotificacion->addMensaje('El pedido ' . $pedido->getIdPedido() . ' está pendiente de pago, se actualizó el estado en el sistema (Estado P).');

		// Si el pedido es offline y no se le envió el aviso con la fecha de pago limite
		if( $proveedorPagoResponse['modalidad'] == "OFF" && !$pedido->getFechaAvisoPago() )
		{
			if( $pedido->enviarAvisoPagoOffline() )
			{
				$pagoNotificacion->addMensaje('Se le notificó al cliente del pedido ' . $pedido->getIdPedido() . ' la fecha límite para el pago, ya que seleccionó método OFF (Estado P).');
			}
		}

		return $proveedorPagoResponse['estado'];
	}

	protected function verificarEnviadoMP( $pedido, $pagoNotificacion )
	{
		$proveedorPagoResponse = $pagoNotificacion->getResponseArray();

		if ( $pagoNotificacion->getMetodo() == pagoNotificacion::ENVIADOMP || $pagoNotificacion->getMetodo() == pagoNotificacion::RETORNO )
		{			 
			if( $proveedorPagoResponse['estado'] != 'C' && $pedido->getFechaBaja() )
			{
				$respuestaReactivacion = $pedido->procesarReactivacion();
				if ( $respuestaReactivacion['status'] === true )
				{
					$pagoNotificacion->addMensaje('Se informó que el pedido ' . $pedido->getIdPedido() . ' está en estado ' . $proveedorPagoResponse['estado'] . ', pero en nuestro sistema ya estaba eliminado. Ya que habia stock, bonificaciones y descuentos disponibles para cumplir con el pedido se deriva a procesamiento para el cambio de estado.');
						
					$method = 'procesarPedido' . $proveedorPagoResponse['estado'];
					$response = $this->$method( $pedido, $pagoNotificacion );
					return $response;
				}
				else
				{				    
					$subject = 'Atención: pedido '. $pedido->getIdPedido() .' cambió de estado';
					$content = 'MercadoPago informó que el estado del pedido ' . $pedido->getIdPedido() . ' es ' . $proveedorPagoResponse['estado'] . ' (' . $proveedorPagoResponse['estadoDescripcion'] . '), pero internamente ya estaba eliminado. El sistema retorno el siguiente mensaje, el cual requiere intervencion manual: ' . $respuestaReactivacion;
					$this->sendNotificationEmail( $subject, $content, $pedido, $respuestaReactivacion['tipoIntervencionManual'] );

					$pagoNotificacion->addMensaje('Se informó que el pedido ' . $pedido->getIdPedido() . ' está en estado ' . $proveedorPagoResponse['estado'] . ', pero en nuestro sistema ya estaba eliminado. . El sistema retorno el siguiente mensaje, el cual requiere intervencion manual: ' . $respuestaReactivacion['message'] );
					
					return $proveedorPagoResponse['estado'];
				}
			}
				
				
			// Pedido en estado C o P que ya estaba pagado
			if( $proveedorPagoResponse['estado'] != 'A'  && $pedido->getFechaPago() && !$pedido->getFechaBaja() )
			{
				$subject = 'Atención: pedido '. $pedido->getIdPedido() . ' cambió de estado';
				$content = 'MercadoPago informó que el estado del pedido ' . $pedido->getIdPedido() . ' es ' . $proveedorPagoResponse['estado'] . ' (' . $proveedorPagoResponse['estadoDescripcion'] . '), pero internamente ya estaba marcado como pagado. Esto precisa intervención manual';
				$this->sendNotificationEmail( $subject, $content, $pedido );

				$pagoNotificacion->addMensaje('Se informó que el pedido ' . $pedido->getIdPedido() . ' está en estado ' . $proveedorPagoResponse['estado'] . ', pero en nuestro sistema ya estaba como pagado.');
				
				return $proveedorPagoResponse['estado'];
			}
				
		}

		return false;
	}

	/*
	 * Engloba todos los envios de notificaciones via email al administrador de DeluxeBuys
	 */
	protected function sendNotificationEmail( $subject, $content, $pedido, $tipoIntervencionManual = pedido::INTEVENCION_MANUAL_REQUIERE_ALTA )
	{
		if ( $pedido->getRequiereIntervencionManual() ) return;

		$to = explode( ',', sfConfig::get('app_email_to_notificacionPedido') );

		$vars = array( 'title' => $subject, 'content' => $content );
		$mailer = new Mailer('notificacionInterna', $vars);
		$mailer->send( $subject, $to );

		$pedido->setRequiereIntervencionManual( $tipoIntervencionManual );
		$pedido->save();
	}

	
	protected function excluirPagosOfflineCampana( $pedido )
	{
	    $idProductos = array();
	    foreach ($pedido->getPedidoProductoItem() as $pedidoProductoItem)
	    {
	        $productoItem = $pedidoProductoItem->getProductoItem();
	        $idProductos[] = $productoItem->getIdProducto();
	    }
	    
	    $primeraCampana = campanaTable::getInstance()->getPrimeraCampanaByIdProductos($idProductos);
	    $fechaPrimeraCampana = ( $primeraCampana ) ? $primeraCampana->getFechaFin() : false;
	    
	    // Si no se permite pago offline se excluye
	    if ( $primeraCampana && !$primeraCampana->getPermitirPagoOffline() )
	    {
	        return $this->excluirPagosOffline();
	    }
	    // Si se permite se verifica la fecha de finalizacion de la campaña
	    else if ($fechaPrimeraCampana )
	    {
	        $timestampLimite = pmDateHelper::getInstance()->restarDiasHabiles( sfConfig::get('app_pedido_diasPagoOffline'), 'U', strtotime($fechaPrimeraCampana) );
	    
	        if ( strtotime('now') > $timestampLimite )
	        {
	            return $this->excluirPagosOffline();
	        }
	    }

	    return array();
	}
	
	protected function excluirPagosOfflineOutlet( $pedido )
	{
	    $outletData = configuracionTable::getInstance()->getOutlet();
	    $outletData = json_decode($outletData->getValor(), true);
	    	    
	    if ( !isset( $outletData['permitir_pago_offline'] ) || !$outletData['permitir_pago_offline'] )
	    {
	        return $this->excluirPagosOffline();
	    }
	    else
	    {
	        $timestampLimite = pmDateHelper::getInstance()->restarDiasHabiles( sfConfig::get('app_pedido_diasPagoOffline'), 'U', strtotime($outletData['fecha_fin']) );

	        if ( strtotime('now') > $timestampLimite )
	        {
	            return $this->excluirPagosOffline();
	        }	        
	    }

	    return array();
	}

	protected function excluirPagosOffline()
	{	    
		return array (
            "excluded_payment_types" => array (
                array ( "id" => "ticket" ),
                array ( "id" => "atm" )
            )
        );
	}
	
	protected function getModalidad($paymentType)
	{
		switch( $paymentType )
		{
			case 'account_money': return 'EFE';
			case 'ticket': 	      return 'OFF';
			case 'bank_transfer': return 'OFF';
			case 'atm':           return 'OFF';
			case 'credit_card':   return 'TCO';
			case 'debit_card':    return 'DEB';
			default:              return 'OFF';
		}
	}

	protected function getEstado( $status )
	{
		switch( $status )
		{
			case 'pending': 	 return 'P';
			case 'authorized': 	 return 'P';
			case 'approved': 	 return 'A';
			case 'in_process': 	 return 'P';
			case 'rejected': 	 return 'C';
			case 'cancelled': 	 return 'C';
			case 'refunded':  	 return 'C';
			case 'in_mediation': return 'P';
			default:             return 'P';
		}
	}

	protected function getEshopCredentials( $eshop )
	{
        if ( $eshop && $eshop->getIdEshop() ) {
            
            return array
            (
                'client_id'		=> $eshop->getMercadoPagoClientId(),
                'client_secret'	=> $eshop->getMercadoPagoClientSecret()
            );
                        
        } else {
            
            return array
            (
                'client_id'		=> sfConfig::get('app_mercadopago_client_id'),
                'client_secret'	=> sfConfig::get('app_mercadopago_client_secret')
            );     
                   
        }
	}

}



