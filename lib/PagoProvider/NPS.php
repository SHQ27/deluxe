<?php

class NPS extends PagoProvider
{
    const PAGO_VISA        = 14;
    const PAGO_AMERICAN    = 1;
    const PAGO_MASTERCARD  = 5;
    
    protected $client;
        
    protected function __construct()
	{	
		$this->URL 			        = sfConfig::get('app_NPS_URL');
		$this->Merchant_id 	    	= sfConfig::get('app_NPS_Merchant_id');
		$this->Secret_Code 	    	= sfConfig::get('app_NPS_Secret_Code');
		$this->psp_ReturnURL    	= 'http://'. $_SERVER['HTTP_HOST'] . sfConfig::get('app_NPS_psp_ReturnURL');
		$this->psp_Version 	    	= sfConfig::get('app_NPS_psp_Version');
		$this->psp_TxSource     	= sfConfig::get('app_NPS_psp_TxSource');
		$this->psp_Currency    		= sfConfig::get('app_NPS_psp_Currency');
		$this->psp_3DSecureAction 	= sfConfig::get('app_NPS_psp_3DSecureAction');
		$this->psp_FrmLanguage		= sfConfig::get('app_NPS_psp_FrmLanguage');
		$this->psp_Country		    = sfConfig::get('app_NPS_psp_Country');
		$this->psp_MerchantMail		= sfConfig::get('app_NPS_psp_MerchantMail');
    }
	    
	public function doCheckout( $pedido, $proveedorPago = null, $params = array() )
	{   
		$postData = array(
			'psp_Amount'		=> round($pedido->getMontoTotal() * 100), 
			'psp_Country' 		=> $this->psp_Country,
			'psp_Currency' 		=> $this->psp_Currency, 
			'psp_CustomerMail' 	=> $pedido->getEmail(), 
			'psp_FrmLanguage' 	=> $this->psp_FrmLanguage, 
	        'psp_MerchOrderId'	=> $pedido->getIdPedido(),
	        'psp_MerchTxRef' 	=> $pedido->getIdPedido(),
			'psp_MerchantId'	=> $this->Merchant_id,
	        'psp_MerchantMail'	=> $this->psp_MerchantMail,
			'psp_NumPayments' 	=> $pedido->getCuotas(),
			'psp_PosDateTime' 	=> date('Y-m-d H:i:s'),
			'psp_Product' 		=> $proveedorPago,
		    );
		
		if ( isset( $params['promotionCode'] ) ) {
		    $postData['psp_PromotionCode'] = $params['promotionCode'];
		}
		
        $postData['psp_ReturnURL'] = $this->psp_ReturnURL;
        $postData['psp_TxSource'] = $this->psp_TxSource;
        $postData['psp_Version'] = $this->psp_Version;
		
		$postData['psp_SecureHash']	= md5( implode('', $postData) . $this->Secret_Code );
		
		$result = $this->getClient()->PayOnline_3p( $postData );
      	$pedido->setDatosPago( json_encode($result) );
      	$pedido->save();
  		header( 'Location: ' . $result->psp_FrontPSP_URL );
	}
		
	public function makeResponse($postArray)
	{
	    $response = array
	    (
	            'codigo_respuesta'    => $postArray['psp_ResponseCod'],
	            'respuesta'	          => $postArray['psp_ResponseMsg'],
	            'id_transaccion'      => $postArray['psp_TransactionId'],
	            'cuotas'		      => $postArray['psp_NumPayments'],
	            'total'			      => $postArray['psp_Amount']/100,
	            'producto_NPS'	      => $postArray['psp_Product']
	    );
	
	    return $response;
	}
	
	public function procesar( $pagoNotificacion )
	{
	    $proveedorPagoResponse = $pagoNotificacion->getResponseArray();
	    
	    if (!$proveedorPagoResponse)
	    {
	        return;
	    }
	    	    
	    // Actualizo los datos de pago
	    $pedido = $pagoNotificacion->getPedido();
	    $pedido->setDatosPago( json_encode($proveedorPagoResponse) );
	    $pedido->save();
	    
	    // Empiezo a procesar
	    if( $proveedorPagoResponse['codigo_respuesta'] == 0 && $proveedorPagoResponse['codigo_respuesta'] !== null )
	    {
	        $this->procesarPedidoAprobado( $pedido, $pagoNotificacion );
	    }
	    else
	    {
	        $this->procesarPedidoRechazado( $pedido, $pagoNotificacion );
	    }

	    return $proveedorPagoResponse;
	}
	
	public function consultar($idTransaccionNPS)
	{
	    
	    $postData = array(
	            'psp_MerchantId'    	=> $this->Merchant_id,
	            'psp_PosDateTime'     	=> date('Y-m-d H:i:s'),
	            'psp_QueryCriteria'    	=> 'T',
	            'psp_QueryCriteriaId'	=> $idTransaccionNPS,
	            'psp_Version'		    => $this->psp_Version
	    );
	    
	    $postData['psp_SecureHash']	= md5( implode('', $postData) . $this->Secret_Code );
	    
	    return $this->getClient()->SimpleQueryTx( $postData );
	}

    public function getClient()
	{
		if (!$this->client)
		{
			$this->client = new SoapClient($this->URL);
		}
		
		return $this->client; 
	}

}
