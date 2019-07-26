<?php

class avisoReporteVentaTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name = 'aviso-reporte-venta';
		$this->briefDescription = 'Envia el aviso cada 2 dias para informar a los proveedores que esta disponible el reporte de seguimiento de una campana.';
		$this->detailedDescription = <<<EOF
La tarea [aviso-reporte-venta|INFO] envia el aviso cada 2 dias para informar a los proveedores que esta disponible el reporte de seguimiento de una campana.
Call it with: [php symfony deluxebuys:aviso-reporte-venta|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "avisoReporteVenta"');
		
		$campanas = campanaTable::getInstance()->listVigentes();
		
		foreach ($campanas as $campana)
		{
			 $fechaInicio = strtotime( date('Y-m-d', strtotime( $campana->getFechaInicio() ) ) );
			 $fechaHoy = strtotime( date('Y-m-d') );
			 
			 $diffDias = ($fechaHoy - $fechaInicio) / 86400;
			 
			 if($diffDias !=0 && $diffDias % 2 == 0)
			 {
			 	$campanaUsuarios = $campana->getCampanaUsuario();
			 	
			 	foreach ($campanaUsuarios as $campanaUsuario)
			 	{
				 	$subject = 'Reporte de ventas disponible';
				 	$vars = array( 'title' => $subject, 'campana' => $campana );
				 	$mailer = new Mailer('proveedoresRecordatorio', $vars);
				 	$mailer->send( $subject, $campanaUsuario->getEmail() );
				 	
				 	$this->log('Campana: ' . $campana->getDenominacion() . ' / Mail: ' . $campanaUsuario->getEmail() . ' Enviado!');
			 	}
			 }
			 	
			 
			 
			 
		}
		
		$this->log('--- Fin de ejecucion: "avisoReporteVenta"');
	}  
}
