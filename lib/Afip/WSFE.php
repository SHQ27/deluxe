<?php

class Afip_WSFE extends Afip
{
	const FACTURA_B = 6;
	const NOTA_DE_CREDITO_B = 8;
	const MONEDA = 'PES';
	const TIPO_DOC_DNI = 96;
	const TIPO_DOC_LE = 89;
	const TIPO_DOC_LC = 90;
	
	static protected $instance;
			
	protected $wsdl;
	protected $URL;
	protected $cuit;
	protected $puntoDeVenta;
	protected $tipoIva;
	protected $client;
	protected $credentials;

	protected function __construct()
	{
		$configWS = sfConfig::get('app_afip_ws');
		
		if ( $configWS['env'] == Afip::PROD )
		{
			$this->URL 		= "https://servicios1.afip.gov.ar/wsfev1/service.asmx";
		}
		else 
		{
			$this->URL 		= "https://wswhomo.afip.gov.ar/wsfev1/service.asmx";
		}			
		
		$this->wsdl 		= dirname(__FILE__) . "/docs/wsfev1.wsdl";
		$this->cuit 		= doubleval( str_replace('-', '', $configWS['cuit'] ) );
		$this->puntoDeVenta = $configWS['punto_de_venta'];
		$this->tipoIva 		= (int) $configWS['tipo_iva'];
		$this->credentials 	= Afip_WSAA::getInstance()->getCredentials();
	}

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new Afip_WSFE();
		}

		self::$instance->checkStatus();
		
		return self::$instance;
	}

	public function getClient()
	{
		if (!$this->client)
		{
			$this->client = new SoapClient( $this->wsdl,
							array( 'soap_version' => SOAP_1_1,
							'location' => $this->URL,
							'exceptions'   => 0,
							'encoding'     => 'ISO-8859-1',
							'features'     => SOAP_USE_XSI_ARRAY_TYPE + SOAP_SINGLE_ELEMENT_ARRAYS,
							'trace'        => 1
						));
		}
		
		return $this->client; 
	}
	
	
	public function checkStatus()
	{
		$results = $this->getClient()->FEDummy();
		
	    $appServer = $results->FEDummyResult->AppServer;
	    $dbServer = $results->FEDummyResult->DbServer;
	    $authServer = $results->FEDummyResult->AuthServer;
	    
	    if ( $appServer != 'OK' || $dbServer != 'OK' || $authServer != 'OK' )
	    {
	    	throw new Exception("Fallo de infraestructura AFIP - AppServer: $appServer | DbServer: $dbServer | AuthServer $authServer");
	    }	    
	}
	
	public function UltimoCompAutorizado($tipoComprobante)
	{		
		$params = new stdClass();
		
		$params->Auth = new stdClass();
		$params->Auth->Token = $this->credentials->token;
		$params->Auth->Sign  = $this->credentials->sign;
		$params->Auth->Cuit  = $this->cuit;
		
		$params->PtoVta		= $this->puntoDeVenta;
		$params->CbteTipo	= $tipoComprobante;
		
	  	$results = $this->getClient()->FECompUltimoAutorizado($params);
	  	
	  	return $results->FECompUltimoAutorizadoResult->CbteNro;
	}
	
	public function consultarComprobanteEmitido($comprobante, $tipoComprobante)
	{		
		$params = new stdClass();
		
		$params->Auth = new stdClass();
		$params->Auth->Token = $this->credentials->token;
		$params->Auth->Sign  = $this->credentials->sign;
		$params->Auth->Cuit  = $this->cuit;

		$params->FeCompConsReq = new stdClass();
		$params->FeCompConsReq->CbteTipo = $tipoComprobante;
		$params->FeCompConsReq->CbteNro  = $comprobante;
		$params->FeCompConsReq->PtoVta   = $this->puntoDeVenta;
		
	  	$results = $this->client->FECompConsultar($params);
	  	
	  	return $results;
	}
	
	public function consultarTotalXRequest()
	{
		$params = new stdClass();
		
		$params->Auth = new stdClass();
		$params->Auth->Token = $this->credentials->token;
		$params->Auth->Sign  = $this->credentials->sign;
		$params->Auth->Cuit  = $this->cuit;
		
	  	$results = $this->client->FECompTotXRequest($params);
	  	return $results->FECompTotXRequestResult->RegXReq;
	}
	
	
	public function EmitirLote($montoFacturacion, $cantidad)
	{
		$proxComp = $this->UltimoCompAutorizado(self::FACTURA_B) + 1;

		$params = new stdClass();
		
		$params->Auth = new stdClass();
		$params->Auth->Token = $this->credentials->token;
		$params->Auth->Sign  = $this->credentials->sign;
		$params->Auth->Cuit  = $this->cuit;
		
		$FeCabReq = new stdClass();
		$FeCabReq->CantReg	= 1;
		$FeCabReq->PtoVta	= $this->puntoDeVenta;
		$FeCabReq->CbteTipo	= self::FACTURA_B;
		
		$params->FeCAEReq = new stdClass();
		$params->FeCAEReq->FeCabReq = $FeCabReq;
		
		$baseImponible = $montoFacturacion / 1.21;
		$baseImponibleRedondeado = round($baseImponible, 2, PHP_ROUND_HALF_EVEN);
		
		$importeIva = $baseImponible * 0.21;
		$importeIvaRedondeado = round($importeIva, 2, PHP_ROUND_HALF_EVEN);
		
		$impTotal = $baseImponibleRedondeado + $importeIvaRedondeado;
		$impTotal = round($impTotal, 2, PHP_ROUND_HALF_EVEN);
		
		$FEDetRequest = new stdClass();
		$FEDetRequest->Concepto		= 1;
		$FEDetRequest->DocTipo		= 99;
		$FEDetRequest->DocNro		= 0;
		$FEDetRequest->CbteDesde	= $proxComp;
		$FEDetRequest->CbteHasta	= $proxComp + ($cantidad - 1) ;
		$FEDetRequest->CbteFch		= date('Ymd');
		$FEDetRequest->ImpTotal		= $impTotal;
		$FEDetRequest->ImpTotConc	= 0;
		$FEDetRequest->ImpNeto		= $baseImponibleRedondeado;
		$FEDetRequest->ImpOpEx		= 0;
		$FEDetRequest->ImpTrib		= 0;
		$FEDetRequest->ImpIVA		= $importeIvaRedondeado;
		$FEDetRequest->MonId		= self::MONEDA;
		$FEDetRequest->MonCotiz		= 1;
		
		$IVAs = array();
		$IVAs[0]->Id		= $this->tipoIva;
		$IVAs[0]->BaseImp	= $baseImponibleRedondeado;
		$IVAs[0]->Importe	= $importeIvaRedondeado;
		
		$FEDetRequest->Iva	= $IVAs;
		
		$FeDetReq[] = $FEDetRequest;
		
		$params->FeCAEReq->FeDetReq = $FeDetReq;
		
		$results = $this->client->FECAESolicitar($params);
		
		$reponse['cabecera'] = $results->FECAESolicitarResult->FeCabResp;
		$reponse['detalle']  = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse[0];
		$reponse['errores']  = $results->FECAESolicitarResult->Errors;
		$reponse['request']  = $this->client->__getLastRequest();
		$reponse['response']  = $this->client->__getLastResponse();
		
		return $reponse;
	}
	
	
	public function Emitir($facturas)
	{
		$proxComp = $this->UltimoCompAutorizado(self::FACTURA_B) + 1;
		
		$params = new stdClass();
		
		$params->Auth = new stdClass();
		$params->Auth->Token = $this->credentials->token;
		$params->Auth->Sign  = $this->credentials->sign;
		$params->Auth->Cuit  = $this->cuit;
		
		$FeCabReq = new stdClass();
		$FeCabReq->CantReg	= count($facturas);
		$FeCabReq->PtoVta	= $this->puntoDeVenta;
		$FeCabReq->CbteTipo	= self::FACTURA_B;
		
		$params->FeCAEReq = new stdClass();
		$params->FeCAEReq->FeCabReq = $FeCabReq;
		
		$i = 0;
		foreach ($facturas as $factura)
		{
			$montoFacturacion = $factura->getPedido()->getMontoFacturacion();
			$usuario = $factura->getPedido()->getUsuario();
			
			$baseImponible = $montoFacturacion / 1.21;
			$baseImponibleRedondeado = round($baseImponible, 2, PHP_ROUND_HALF_EVEN);
			
			$importeIva = $baseImponible * 0.21;
			$importeIvaRedondeado = round($importeIva, 2, PHP_ROUND_HALF_EVEN);
			
			if ( $configWS['env'] == Afip::PROD )
			{
				$docTipo = constant( 'self::TIPO_DOC_' . $usuario->getTipoDocumento() );
				$docNro = $usuario->getDocumento();
			}
			else 
			{
				$docTipo = self::TIPO_DOC_DNI;
				$docNro = 12345678;
			}
			
			$impTotal = $baseImponibleRedondeado + $importeIvaRedondeado;
			$impTotal = round($impTotal, 2, PHP_ROUND_HALF_EVEN);
			
			$FEDetRequest = new stdClass();
			$FEDetRequest->Concepto		= 1;
			$FEDetRequest->DocTipo		= $docTipo;
			$FEDetRequest->DocNro		= $docNro;
			$FEDetRequest->CbteDesde	= $proxComp + $i;
			$FEDetRequest->CbteHasta	= $proxComp + $i;
			$FEDetRequest->CbteFch		= date('Ymd');
			$FEDetRequest->ImpTotal		= $impTotal;
			$FEDetRequest->ImpTotConc	= 0;
			$FEDetRequest->ImpNeto		= $baseImponibleRedondeado;
			$FEDetRequest->ImpOpEx		= 0;
			$FEDetRequest->ImpTrib		= 0;
			$FEDetRequest->ImpIVA		= $importeIvaRedondeado;
			$FEDetRequest->MonId		= self::MONEDA;
			$FEDetRequest->MonCotiz		= 1;
			
			$IVAs = array();
			$IVAs[0]->Id		= $this->tipoIva;
			$IVAs[0]->BaseImp	= $baseImponibleRedondeado;
			$IVAs[0]->Importe	= $importeIvaRedondeado;
			
			$FEDetRequest->Iva	= $IVAs;
			
			$FeDetReq[] = $FEDetRequest;
			$i++;
		}
		
		$params->FeCAEReq->FeDetReq = $FeDetReq;
		
		$results = $this->client->FECAESolicitar($params);

		$reponse['cabecera'] = $results->FECAESolicitarResult->FeCabResp;
		$reponse['detalles']  = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse;
		$reponse['errores']  = $results->FECAESolicitarResult->Errors;
		$reponse['request']  = $this->client->__getLastRequest();
		$reponse['response']  = $this->client->__getLastResponse();
		
		return $reponse;
	}
	
	public function EmitirNotasCredito($notasCredito)
	{
		$proxComp = $this->UltimoCompAutorizado(self::NOTA_DE_CREDITO_B) + 1;
		
		$params = new stdClass();
		
		$params->Auth = new stdClass();
		$params->Auth->Token = $this->credentials->token;
		$params->Auth->Sign  = $this->credentials->sign;
		$params->Auth->Cuit  = $this->cuit;
		
		$FeCabReq = new stdClass();
		$FeCabReq->CantReg	= count($notasCredito);
		$FeCabReq->PtoVta	= $this->puntoDeVenta;
		$FeCabReq->CbteTipo	= self::NOTA_DE_CREDITO_B;
		
		$params->FeCAEReq = new stdClass();
		$params->FeCAEReq->FeCabReq = $FeCabReq;
		
		$i = 0;
		foreach ($notasCredito as $notaCredito)
		{
		    $nCreditoFacturas = $notaCredito->getNcreditoFactura();
		    
			$montoTotal = $notaCredito->getImporte();
			
			$baseImponible = $montoTotal / 1.21;
			$baseImponibleRedondeado = round($baseImponible, 2, PHP_ROUND_HALF_EVEN);
			
			$importeIva = $baseImponible * 0.21;
			$importeIvaRedondeado = round($importeIva, 2, PHP_ROUND_HALF_EVEN);
			
			$response = $this->consultarComprobanteEmitido($nCreditoFacturas[0]->getFactura()->getComprobante(), self::FACTURA_B);
			$response = (array) $response->FECompConsultarResult;

			$docTipo = false;
			$docNro = false;

						
			if (!isset($response['Errors']))
			{					
				$docTipo = $response['ResultGet']->DocTipo;
				$docNro = $response['ResultGet']->DocNro;

				if ($montoTotal >= 1000 && !$docNro)
				{
					$usuario = $nCreditoFacturas[0]->getFactura()->getPedido()->getUsuario();
					$docTipo = $usuario->getTipoDocumento();
					$docNro = $usuario->getDocumento();
				}				
			}
						
			$FEDetRequest = new stdClass();
			$FEDetRequest->Concepto		= 1;
			$FEDetRequest->DocTipo		= $docTipo;
			$FEDetRequest->DocNro		= $docNro;
			$FEDetRequest->CbteDesde	= $proxComp + $i;
			$FEDetRequest->CbteHasta	= $proxComp + $i;
			$FEDetRequest->CbteFch		= date('Ymd');
			$FEDetRequest->ImpTotal		= $baseImponibleRedondeado + $importeIvaRedondeado;
			$FEDetRequest->ImpTotConc	= 0;
			$FEDetRequest->ImpNeto		= $baseImponibleRedondeado;
			$FEDetRequest->ImpOpEx		= 0;
			$FEDetRequest->ImpTrib		= 0;
			$FEDetRequest->ImpIVA		= $importeIvaRedondeado;
			$FEDetRequest->MonId		= self::MONEDA;
			$FEDetRequest->MonCotiz		= 1;
					
			
			$CbtesAsoc = array();
			$j = 0;
			foreach( $nCreditoFacturas as $nCreditoFactura )
			{
			    $CbtesAsoc[$j]->Tipo     = self::FACTURA_B;
			    $CbtesAsoc[$j]->PtoVta	 = $this->puntoDeVenta;
			    $CbtesAsoc[$j]->Nro		 = $nCreditoFactura->getFactura()->getComprobante();
			    $j++;
			}
			
			$FEDetRequest->CbtesAsoc = $CbtesAsoc;
			

			
			$IVAs = array();
			$IVAs[0]->Id		= $this->tipoIva;
			$IVAs[0]->BaseImp	= $baseImponibleRedondeado;
			$IVAs[0]->Importe	= $importeIvaRedondeado;
			$FEDetRequest->Iva	= $IVAs;
			
			$FeDetReq[] = $FEDetRequest;
			$i++;
		}
		
		$params->FeCAEReq->FeDetReq = $FeDetReq;
		
		$results = $this->client->FECAESolicitar($params);

		$reponse['cabecera'] = $results->FECAESolicitarResult->FeCabResp;
		$reponse['detalles']  = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse;
		$reponse['errores']  = $results->FECAESolicitarResult->Errors;
		$reponse['request']  = $this->client->__getLastRequest();
		$reponse['response']  = $this->client->__getLastResponse();
		
		return $reponse;
	}
	
}
