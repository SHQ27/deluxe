<?php

class reporteVentasPorDiaTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'reporte-ventas-por-dia';
		$this->briefDescription = 'Genera el reporte diario de ventas del dia anterior';
		$this->detailedDescription = <<<EOF
La tarea [reporte-ventas-por-dia|INFO] genera el reporte diario de ventas del dia anterior
Call it with: [php symfony deluxebuys:reporte-ventas-por-dia|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "reporteVentasPorDia"');		
		
		$fecha = date("Y-m-d", strtotime("yesterday"));
		
		$pedidos = pedidoTable::getInstance()->listPagadosIn($fecha, null);

		$totalDineroIngresadoFlash = $totalDineroIngresadoPermanente = $totalDineroIngresadoMixto = 0;
		$costoEnvioFlash = $costoEnvioPermanente = $costoEnvioMixto = 0;
		$descuentosUsadosFlash = $descuentosUsadosPermanente = $descuentosUsadosMixto = 0;
		$bonificacionesUsadosFlash = $bonificacionesUsadosPermanente = $bonificacionesUsadosMixto = 0;
		$cantidadPedidos050 = $cantidadPedidos50100 = $cantidadPedidos100200 = $cantidadPedidos200Mas = 0;
		$ventaTotalFlash = $ventaTotalPermanente = 0;
		$costoMercaderiaFlash = $costoMercaderiaPermanente = 0;
		$cantidadPedidosFlash = $cantidadPedidosPermanente = $cantidadPedidosMixto = 0;		
		$unidadesFlash = $unidadesPermanente = 0;
		$primeraCompra = 0;
		
		foreach ($pedidos as $pedido)
		{
			$soloStockPermanente = $pedido->tieneSoloStockPermanente();
			$soloOfertas 		 = $pedido->tieneSoloOfertas();
			$esMixto = (!$soloStockPermanente && !$soloOfertas); 
			
			$primerPedido = pedidoTable::getInstance()->getFirstByIdUsuario( $pedido->getIdUsuario() );
			if ( $pedido->getIdPedido() == $primerPedido->getIdPedido() ) $primeraCompra++;
			
			$totalDineroIngresado = $pedido->getMontoProductos() + $pedido->getMontoEnvio();
			
			if ( $soloOfertas )
			{
				$totalDineroIngresadoFlash += $totalDineroIngresado;
				$costoEnvioFlash += $pedido->getMontoEnvio();
				$descuentosUsadosFlash += $pedido->getMontoDescuento();
				$bonificacionesUsadosFlash += $pedido->getMontoBonificacion();
				$cantidadPedidosFlash++;			
			}
			
			if ( $soloStockPermanente )
			{
				$totalDineroIngresadoPermanente += $totalDineroIngresado;
				$costoEnvioPermanente += $pedido->getMontoEnvio();
				$descuentosUsadosPermanente += $pedido->getMontoDescuento();
				$bonificacionesUsadosPermanente += $pedido->getMontoBonificacion();
				$cantidadPedidosPermanente++;
			}
			
			if ( $esMixto )
			{
				$totalDineroIngresadoMixto += $totalDineroIngresado;
				$costoEnvioMixto += $pedido->getMontoEnvio();
				$descuentosUsadosMixto += $pedido->getMontoDescuento();
				$bonificacionesUsadosMixto += $pedido->getMontoBonificacion();
				$cantidadPedidosMixto++;
			}			
			
			// Cantidad por monto
			if ( $pedido->getMontoTotal() < 50 ) $cantidadPedidos050++;
			else if ( $pedido->getMontoTotal() < 100 ) $cantidadPedidos50100++;
			else if ( $pedido->getMontoTotal() < 200 ) $cantidadPedidos100200++;
			else $cantidadPedidos200Mas++;
			
			$pedidoProductoItems = $pedido->getPedidoProductoItem();
			foreach ($pedidoProductoItems as $pedidoProductoItem)
			{
				$cantidad = $pedidoProductoItem->getCantidad();
				$precioDB = $pedidoProductoItem->getPrecioDeluxe();
				$costo = $pedidoProductoItem->getCosto();
				
				if ( $pedidoProductoItem->esStockPermanente() )
				{
					$ventaTotalPermanente +=  $precioDB * $cantidad;
					$costoMercaderiaPermanente += $costo * $cantidad;
					$unidadesPermanente += $cantidad; 
				}
				else
				{
					$ventaTotalFlash += $precioDB * $cantidad;
					$costoMercaderiaFlash += $costo * $cantidad;
					$unidadesFlash += $cantidad;
				}
			}
		}
		
		$reporte = new reporteVentasPeriodo();
		
		$reporte->setFecha($fecha);

		$reporte->setTotalDineroIngresadoFlash( $totalDineroIngresadoFlash );
		$reporte->setTotalDineroIngresadoPermanente( $totalDineroIngresadoPermanente );
		$reporte->setTotalDineroIngresadoMixto( $totalDineroIngresadoMixto );
		
		$reporte->setVentaTotalFlash( $ventaTotalFlash );
		$reporte->setVentaTotalPermanente( $ventaTotalPermanente );
		
		$reporte->setCostoMercaderiaFlash( $costoMercaderiaFlash );
		$reporte->setCostoMercaderiaPermanente( $costoMercaderiaPermanente );
		
		$reporte->setCostoEnvioFlash( $costoEnvioFlash );
		$reporte->setCostoEnvioPermanente( $costoEnvioPermanente );
		$reporte->setCostoEnvioMixto( $costoEnvioMixto );
		
		$reporte->setComisionesFlash( $totalDineroIngresadoFlash * 0.05 );
		$reporte->setComisionesPermanente( $totalDineroIngresadoPermanente  * 0.05 );
		$reporte->setComisionesMixto( $totalDineroIngresadoMixto * 0.05 );
		
		$reporte->setCantidadPedidosFlash( $cantidadPedidosFlash );
		$reporte->setCantidadPedidosPermanente( $cantidadPedidosPermanente );
		$reporte->setCantidadPedidosMixto( $cantidadPedidosMixto );

		$reporte->setUnidadesFlash( $unidadesFlash );
		$reporte->setUnidadesPermanente( $unidadesPermanente );
		
		$reporte->setDescuentosUsadosFlash( $descuentosUsadosFlash );
		$reporte->setDescuentosUsadosPermanente( $descuentosUsadosPermanente );
		$reporte->setDescuentosUsadosMixto( $descuentosUsadosMixto );
				
		$reporte->setBonificacionesUsadosFlash( $bonificacionesUsadosFlash );
		$reporte->setBonificacionesUsadosPermanente( $bonificacionesUsadosPermanente );
		$reporte->setBonificacionesUsadosMixto( $bonificacionesUsadosMixto );
		
		$reporte->setCantidadPedidos050( $cantidadPedidos050 );
		$reporte->setCantidadPedidos50100( $cantidadPedidos50100 );
		$reporte->setCantidadPedidos100200( $cantidadPedidos100200 );
		$reporte->setCantidadPedidos200Mas( $cantidadPedidos200Mas );
				
		$reporte->setClientePrimeraCompra( $primeraCompra );
		
		$reporte->save();
		
		
		$this->log( $fecha . ' --> OK');
		$fecha = date('Y-m-d', strtotime($fecha) + 86400);
		
		$this->log('--- Fin de ejecucion: "reporteVentasPorDia"');
	}  
}
