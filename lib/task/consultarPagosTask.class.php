<?php

class consultarPagosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'consultar-pagos';
		$this->briefDescription = 'Solicita informacion a los proveedores de pago sobre algunos pedidos pendientes elegidos al azar';
		$this->detailedDescription = <<<EOF
La tarea [consultar-pagos|INFO] solicita informacion a los proveedores de pago sobre algunos pedidos pendientes elegidos al azar. 
Call it with: [php symfony deluxebuys:consultar-pagos|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "consultarPagosTask"');
		
		$pedidos = pedidoTable::getInstance()->listByCheckWithCron();
		
		foreach ( $pedidos as $pedido )
		{
		    // Obtengo la info de mercado pago
		    if ( $pedido->getIdFormaPago() == formaPago::MERCADOPAGO )
		    {
		  	    $response = PagoProvider::getInstance( formaPago::MERCADOPAGO )->consultar( $pedido->getIdPedido() );
		  	    $id = $pedido->getIdPedido();
	        }
	        elseif ( $pedido->getIdFormaPago() == formaPago::NPS )
	        {
	            $datosPago = json_decode( $pedido->getDatosPago(), true);

				if ( $datosPago['psp_TransactionId'] ) {
		            $response = PagoProvider::getInstance( formaPago::NPS )->consultar( $datosPago['psp_TransactionId'] );
		            $response = PagoProvider::getInstance( formaPago::NPS )->makeResponse( (array) $response->psp_Transaction );
		            $id = $response['id_transaccion'];					
				} else {
					$response = null;
				}

	        } else {
	        	continue;
	        }
	        
		  	if ($response)
		  	{
			  	// Anoto la respuesta para luego procesarla en batch
			  	$pagoNotificacion = new pagoNotificacion();
			  	$pagoNotificacion->setIdFormaPago( $pedido->getIdFormaPago() );
			  	$pagoNotificacion->setMetodo(pagoNotificacion::CRON);
			  	$pagoNotificacion->setIdPedido( $pedido->getIdPedido() );
			  	$pagoNotificacion->setResponse( json_encode($response) );
			  	$pagoNotificacion->setProcesado(false);
			  	$pagoNotificacion->setId($id);
			  	$pagoNotificacion->save();
			  	
			  	$this->log('id_pedido = ' . $pedido->getIdPedido() . ' -> Se agrego a la cola de procesamiento de pagos.');
		  	}
		  	else
		  	{
		  		$this->log('id_pedido = ' . $pedido->getIdPedido() . ' -> No se puedo agregar a la cola de procesamiento de pagos.');
		  	}

		}
		
		
		$this->log('--- Fin de ejecucion: "consultarPagosTask"');
	}  
}
