<?php

class enviarCampanaRecordatorioEntregaTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'enviar-campana-recordatorio-entrega';
		$this->briefDescription = 'Envia el recordatorio de entrega de mercaderia de campaña a la marca';
		$this->detailedDescription = <<<EOF
La tarea [enviar-campana-recordatorio-entrega|INFO] envia el recordatorio de entrega de mercaderia de campaña a la marca 
Call it with: [php symfony deluxebuys:enviar-campana-recordatorio-entrega|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "enviarCampanaRecordatorioEntrega"');
				
		$campanaMarcas = campanaMarcaTable::getInstance()->pendientesDeEntrega();
		
		foreach( $campanaMarcas as $campanaMarca )
		{
		    $campanaMarca->setUltimoEnvio( new Doctrine_Expression('now()') );
		    $campanaMarca->save();
		    
		    $emails = explode(',', $campanaMarca->getEmailOrdenCompra() );

			$campana = $campanaMarca->getCampana();
		    $huboVenta = pedidoProductoItemTable::getInstance()->ordenDeCompraByIdCampana( $campana->getFechaInicio(), $campana->getFechaFin(), $campana->getIdCampana(), $campanaMarca->getIdMarca(), false, true);
		    		    
		    // Envio de Mail
	        if ( $huboVenta )
	        {
			    $subject = 'Entrega Pendiente de realizarse';
			    $vars = array( 'title'   => $subject, 'hash' => $campanaMarca->getHash());		    
			    $mailer = new Mailer('campanaRecordatorioEntrega', $vars);
			    $mailer->send( $subject, $emails, sfConfig::get('app_email_from_logistica')  );
			    		    
			    $marca = $campanaMarca->getMarca();
			    $campana = $campanaMarca->getCampana();
			    
			    $this->log('Se envio el mail de recordatorio a la marca "' . $marca->getNombre() . '" por la campaña "' . $campana->getDenominacion() . '"');
	        }
	        else
	        {
	            $this->log('No se envio el mail de recordatorio a la marca "' . $marca->getNombre() . '" por la campaña "' . $campana->getDenominacion() . '" debido a que no tuvo ventas');
	        }
		}
		
		$this->log('--- Fin de ejecucion: "enviarCampanaRecordatorioEntrega"');
	}
}
