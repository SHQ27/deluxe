<?php

class Decidir extends PagoProvider
{    
    const PAGO_VISA        = 1;
    const PAGO_AMERICAN    = 6;
    const PAGO_MASTERCARD  = 15;
        
    protected function __construct() {	 }

	public function doCheckout( $pedido, $proveedorPago = null, $params = array() )
	{   
		$monto = round($pedido->getMontoTotal() * 100);
		$cuotas = sprintf("%02d", $pedido->getCuotas());

		if ( $pedido->getIdEshop() ) {
			$eshop = $pedido->getEshop();
			$nroComercio = $eshop->getDecidirNroComercio();
			$urlDinamica = 'http://' . $eshop->getDominio() . sfConfig::get('app_Decidir_urlIPN');
		} else {
			$nroComercio = sfConfig::get('app_Decidir_nroComercio');
			$urlDinamica = sfConfig::get('app_host') . sfConfig::get('app_Decidir_urlIPN');
		}

		// Si es promo especial se sobrescribe el numero de comercio
		if ( isset( $params['IDSITE'] ) ) {
		    $nroComercio = $params['IDSITE'];
		}

		$form = '';
		$form .= '<form name="decidirForm" action="' . sfConfig::get('app_Decidir_urlPost') . '" method="post">';
		$form .= '<input type="HIDDEN" name="NROCOMERCIO" value="' . $nroComercio . '">';
		$form .= '<input type="HIDDEN" name="NROOPERACION" value="' . $pedido->getIdPedido() . '">';
		$form .= '<input type="HIDDEN" name="MEDIODEPAGO" value="' . $proveedorPago . '">';
		$form .= '<input type="HIDDEN" name="MONTO" value="' . $monto . '">';
		$form .= '<input type="HIDDEN" name="CUOTAS" value="' . $cuotas . '">';
		$form .= '<input type="HIDDEN" name="URLDINAMICA" value="' . $urlDinamica . '">';
		$form .= '</form>';
		$form .= '<script>document.decidirForm.submit();</script>';

		echo $form;
		exit;
	}

	public function makeResponse($data)
	{
	    $response = array
	    (
	            'estado'    	  => $data['resultado'],
	            'nroOperacion'    => $data['noperacion'],
	            'cuotas'		  => $data['cuotas'],
	            'total'			  => $data['monto']
	    );
	
	    return $response;
	}

	public function procesar( $pagoNotificacion )
	{
	    $proveedorPagoResponse = $pagoNotificacion->getResponseArray();
	    
	    if (!$proveedorPagoResponse) {
	        return;
	    }
	    	    
	    // Actualizo los datos de pago
	    $pedido = $pagoNotificacion->getPedido();
	    $pedido->setDatosPago( json_encode($proveedorPagoResponse) );
	    $pedido->save();
	    
	    // Empiezo a procesar
	    if( $proveedorPagoResponse['estado'] == 'APROBADA' )
	    {
	        $this->procesarPedidoAprobado( $pedido, $pagoNotificacion );
	    }
	    else
	    {
	        $this->procesarPedidoRechazado( $pedido, $pagoNotificacion );
	    }

	    return $proveedorPagoResponse;
	}



}
