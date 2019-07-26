<?php

class procesarPagosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'procesar-pagos';
		$this->briefDescription = 'Procesa los pagos sin procesar en la tabla pago_notificacion';
		$this->detailedDescription = <<<EOF
La tarea [deluxebuys:procesar-pagos|INFO] procesa los pagos sin procesar en la tabla pago_notificacion.
Call it with: [php symfony deluxebuys:procesar-pagos|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "procesarPagosTask"');
				
		$pagoNotificaciones = pagoNotificacionTable::getInstance()->listSinProcesar();
		
		foreach ($pagoNotificaciones as $pagoNotificacion)
		{

			// Evito procesar pedido de Mercado Libre
			if ( $pagoNotificacion->getIdFormaPago() == formaPago::MERCADOLIBRE ) {
				continue;
			}

			// Se procesa la notificacion
			$pagoProvider = PagoProvider::getInstance( $pagoNotificacion->getIdFormaPago() );
			$pagoProvider->procesar( $pagoNotificacion );

			$this->log('id_pagoNotificacion = ' . $pagoNotificacion->getIdPagoNotificacion() . ' -> Procesado!' );
			
			// Se marca como procesada
			$pagoNotificacion->setProcesado(true);
			$pagoNotificacion->save();
		}
		
		$this->log('--- Fin de ejecucion: "procesarPagosTask"');
	}  
}
