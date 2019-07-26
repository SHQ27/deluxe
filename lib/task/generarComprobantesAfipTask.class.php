<?php

class generarComprobantesAfipTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'generar-comprobantes-afip';
		$this->briefDescription = 'Genera Facturas y Notas de credito desde la ultima corrida.';
		$this->detailedDescription = <<<EOF
La tarea [generar-comprobantes-afip|INFO] genera Facturas y Notas de credito desde la ultima corrida. 
Call it with: [php symfony deluxebuys:generar-comprobantes-afip|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "generarComprobantesAfip"');
		
		//$this->procesarFacturasMenoresAMil();
		
		//$this->procesarFacturasMayoresOIgualAMil();
		
		//$this->procesarNotasCredito();
		
		//$this->verificarCorrelatividadEnFacturas();
		
		$this->log('--- Fin de ejecucion: "generarComprobantesAfip"');
	}  
	
	/*
	 * Se procesan las facturas con monto menor a $1000, en un solo lote
	 */
	protected function procesarFacturasMenoresAMil()
	{
	    $idFacturasProcesadas = array();
	
	    $facturas = facturaTable::getInstance()->listPendientes( facturaTable::MENORES_A_MIL );
	
	    // Si no hay facturas, se corta el proceso
	    if (!count($facturas))
	    {
	        $this->log('No hay facturas menores a $1000 pendientes de procesar');
	        return $idFacturasProcesadas;
	    }
	    
	    $cantidad = 0;
	    $montototal = 0;
	    foreach ($facturas as $factura)
	    {
	        $montototal += $factura->getPedido()->getMontoFacturacion();
	        $cantidad++;
	    }
	
	    // Si el monto total es cero, se corta el proceso
	    if ($montototal == 0) return $idFacturasProcesadas;
	
	    $response = Afip_WSFE::getInstance()->EmitirLote($montototal, $cantidad);
	
	    $facturaWsRequest = new facturaWsRequest();
	    $facturaWsRequest->setRequest( $response['request'] );
	    $facturaWsRequest->setResponse( $response['response'] );
	    $facturaWsRequest->save();
	
	    if (!$response['errores'])
	    {
	        $comprobante = $response['detalle']->CbteDesde;
	
	        foreach ($facturas as $factura)
	        {
	            // Si el pedido se facturo correctamente
	            if ( $response['detalle']->Resultado == 'A' )
	            {
	                $factura->setProcesada(true);
	                $factura->setCAE( $response['detalle']->CAE );
	                $factura->setCAEVencimiento( $response['detalle']->CAEFchVto );
	                $factura->setComprobante( $comprobante );
	
	                $comprobante++;
	
	                // Marco al pedido como facturado
	                $factura->getPedido()->setFechaFacturacion( new Doctrine_Expression('now()') );
	                $factura->getPedido()->save();
	            }
	
	            $factura->setResultado( $response['detalle']->Resultado );
	
	            $factura->save();
	
	            $facturaWsRequestFactura = new facturaWsRequestFactura();
	            $facturaWsRequestFactura->setIdFactura( $factura->getIdFactura() );
	            $facturaWsRequestFactura->setIdFacturaWsRequest( $facturaWsRequest->getIdFacturaWsRequest() );
	            $facturaWsRequestFactura->save();
	
	            $idFacturasProcesadas[] = $factura->getIdFactura();
	
	            $this->log('id_factura = ' . $factura->getIdFactura() . ' | Resultado devuelto por Afip: ' . $response['detalle']->Resultado);
	        }
	    }
	    else
	    {
	        $this->log('El WS devolvio un fallo al procesar las facturas menores a $1000. id_factura_ws_request = ' . $facturaWsRequest->getIdFacturaWsRequest());
	    }
	
	    return $idFacturasProcesadas;
	}
	
	
	
	/*
	 * Se procesan las facturas con monto mayor o igual a $1000, en lotes individuales
	 *  En este caso ademas es necesario enviar el DNI del comprador
	 */
	protected function procesarFacturasMayoresOIgualAMil()
	{
	    $idFacturasProcesadas = array();
	
	    $facturas = facturaTable::getInstance()->listPendientes( facturaTable::MAYORES_O_IGUAL_A_MIL );
	
	    // Si no hay facturas, se corta el proceso
	    if (!count($facturas))
	    {
	        $this->log('No hay facturas mayores o igual a $1000 pendientes de procesar');
	        return $idFacturasProcesadas;
	    }
	
	    $response = Afip_WSFE::getInstance()->Emitir($facturas);
	
	    $facturaWsRequest = new facturaWsRequest();
	    $facturaWsRequest->setRequest( $response['request'] );
	    $facturaWsRequest->setResponse( $response['response'] );
	    $facturaWsRequest->save();
	
	    if (!$response['errores'])
	    {
	        $i = 0;
	        foreach ($facturas as $factura)
	        {
	            $detalle = $response['detalles'][$i];
	
	            // Si el pedido se facturo correctamente
	            if ( $detalle->Resultado == 'A' )
	            {
	                $factura->setProcesada(true);
	                $factura->setCAE( $detalle->CAE );
	                $factura->setCAEVencimiento( $detalle->CAEFchVto );
	                $factura->setComprobante( $detalle->CbteDesde );
	
	                // Marco al pedido como facturado
	                $factura->getPedido()->setFechaFacturacion( new Doctrine_Expression('now()') );
	                $factura->getPedido()->save();
	            }
	
	            $factura->setResultado( $detalle->Resultado );
	            $factura->save();
	
	            $facturaWsRequestFactura = new facturaWsRequestFactura();
	            $facturaWsRequestFactura->setIdFactura( $factura->getIdFactura() );
	            $facturaWsRequestFactura->setIdFacturaWsRequest( $facturaWsRequest->getIdFacturaWsRequest() );
	            $facturaWsRequestFactura->save();
	
	            $idFacturasProcesadas[] = $factura->getIdFactura();
	
	            $this->log('id_factura = ' . $factura->getIdFactura() . ' | Resultado devuelto por Afip: ' . $detalle->Resultado);
	
	            $i++;
	        }
	    }
	    else
	    {
	        $this->log('El WS devolvio un fallo al procesar las facturas mayores o igual a $1000 . id_factura_ws_request = ' . $facturaWsRequest->getIdFacturaWsRequest());
	    }
	
	    return $idFacturasProcesadas;
	}
	
	protected function procesarNotasCredito()
	{
	    $idNotasCreditoProcesadas = array();

        // Se limita la cantidad de comprobante a procesar a la vez
        $limite = 50;
	    $notasCredito = ncreditoTable::getInstance()->listPendientes($limite);
	
	    // Si no hay notas de credito, se corta el proceso
	    if (!count($notasCredito))
	    {
	        $this->log('No hay notas de credito por procesar');
	        return $idNotasCreditoProcesadas;
	    }
	
	    $response = Afip_WSFE::getInstance()->EmitirNotasCredito($notasCredito);
	
	    $ncreditoWsRequest = new ncreditoWsRequest();
	    $ncreditoWsRequest->setRequest( $response['request'] );
	    $ncreditoWsRequest->setResponse( $response['response'] );
	    $ncreditoWsRequest->save();
	
	    $huboError = false;
	    if (!$response['errores'])
	    {
	        $i = 0;
	        foreach ($notasCredito as $notaCredito)
	        {
	            $detalle = $response['detalles'][$i];
	
	            if ( $detalle->Resultado == 'A' )
	            {
	                $notaCredito->setProcesada(true);
	                $notaCredito->setCAE( $detalle->CAE );
	                $notaCredito->setCAEVencimiento( $detalle->CAEFchVto );
	                $notaCredito->setComprobante( $detalle->CbteDesde );
	            }
	            else
	           {
	               $huboError = true;
	            }
	
	            $notaCredito->setResultado( $detalle->Resultado );
	            $notaCredito->save();
	
	            $ncreditoWsRequestNcredito = new ncreditoWsRequestNcredito();
	            $ncreditoWsRequestNcredito->setIdNcredito( $notaCredito->getIdNcredito() );
	            $ncreditoWsRequestNcredito->setIdNcreditoWsRequest( $ncreditoWsRequest->getIdNcreditoWsRequest() );
	            $ncreditoWsRequestNcredito->save();
	
	            $this->log('id_ncredito = ' . $notaCredito->getIdNcredito() . ' | Resultado devuelto por Afip: ' . $detalle->Resultado);
	
	            $idNotasCreditoProcesadas[] = $notaCredito->getIdNcredito();
	
	            $i++;
	        }
	    }
	    else
	    {
	        $this->log('El WS devolvio un fallo al procesar las notas de credito. id_ncredito_ws_request = ' . $ncreditoWsRequest->getIdNcreditoWsRequest());
	        $huboError = true;
	    }
	    
	    if ( $huboError )
	    {
	        $subject = 'Error al procesar notas de credito';
    		$to = explode( ',', sfConfig::get('app_email_to_avisoErrorNC') );
    		$vars = array( 'title' => $subject, 'content' => 'Hubo un error al enviar las notas de credito a AFIP, por favor revisar el proceso' );
    		$mailer = new Mailer('notificacionInterna', $vars);
    		$mailer->send( $subject, $to );
	    }
	
	    return $idNotasCreditoProcesadas;
	}
	
	
	protected function verificarCorrelatividadEnFacturas()
	{	
	    $valorInterno = valorInternoTable::getInstance()->getComprobanteNumberProcess();
	
	    if ($valorInterno)
	    {
	        $lastComprobanteValue = $valorInterno->getValor();
	        $comprobantesToCheck = facturaTable::getInstance()->listByComprobante($lastComprobanteValue);
	        $desde = $lastComprobanteValue;
	    }
	    else
	    {
	        $comprobantesToCheck = facturaTable::getInstance()->listar();
	        $desde = 1;
	    }
	
	    if (!count($comprobantesToCheck)) return;
	
	    $data = array();
	
	    foreach ($comprobantesToCheck as $comprobante)
	    {
	        $data[$comprobante->getComprobante()] = $comprobante->getComprobante();
	    }
	
	    $conn = Doctrine_Manager::connection();
	    
        try
       {
            $conn->beginTransaction();
            
            $noCorrelativos = array();
            $hasta = end($data);
            
            for($i = $desde ; $i <= $hasta ; $i++)
            {
               if (!isset($data[$i]))
               {
                   $incidencia = new incidenciaFactura();
                   $incidencia->setValor($i);
                   $incidencia->setDescripcion("Nro. de comprobante ".$i." no correlativo");
                   $incidencia->setResuelta(false);
                   $incidencia->save();
                   array_push($noCorrelativos, $i);
               }
            }
            
            if (!$valorInterno)
            {
               $valorInterno = new valorInterno();
               $valorInterno->setIdValorInterno(valorInterno::LAST_COMPROBANTE);
               $valorInterno->setDenominacion("Ultimo comprobante procesado");
            }
            
            $valorInterno->setValor(end($data));
            $valorInterno->save();
            
            $conn->commit();
    	}
    	catch (Exception $e)
    	{
    	    $conn->rollback();
    	}
    	
	    $conn->close();
	}
	
}
