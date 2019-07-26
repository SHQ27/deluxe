<?php

class enviarCampanaOCTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'enviar-campana-oc';
		$this->briefDescription = 'Envia la orden de compra a los mails registrados en la campaña para cada marca perteneciente a la misma.';
		$this->detailedDescription = <<<EOF
La tarea [enviar-campana-oc|INFO] envia la orden de compra a los mails registrados en la campaña para cada marca perteneciente a la misma 
Call it with: [php symfony deluxebuys:enviar-campana-oc|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "enviarCampanaOC"');
		
		$hashKey = 'd3luxe-Pr4Gm0Re-h4SH';
		
		$campanaMarcas = campanaMarcaTable::getInstance()->pendientesDeEnvio();
		
		foreach( $campanaMarcas as $campanaMarca )
		{
		    $campanaMarca->setUltimoEnvio( new Doctrine_Expression('now()') );
		    
		    if ( !$campanaMarca->getHash() )
		    {
    		    $hash = array();
    		    $hash[] = $hashKey;
    		    $hash[] = $campanaMarca->getIdCampana();
    		    $hash[] = $campanaMarca->getIdMarca();
    		    $hash[] = time();
    
    		    $hash = sha1( implode('|', $hash) );
    		    $campanaMarca->setHash( $hash );
		    }
		    
		    $dataCantidades = pedidoProductoItemTable::getInstance()->getCantidades( $campanaMarca->getIdCampana(), $campanaMarca->getIdMarca() );		    
		    $campanaMarca->setCostoTotal($dataCantidades['costo_total']);
		    
		    $campanaMarca->save();
		    
		    $emails = explode(',', $campanaMarca->getEmailOrdenCompra() );
		    
	        $emails[] = 'noelia@deluxebuys.com';
	        $emails[] = 'info@deluxebuys.com';
	        $emails[] = sfConfig::get('app_email_from_logistica');
	        
	        
		    // Envio de Mail
	        $campana = $campanaMarca->getCampana();
	        $huboVenta = pedidoProductoItemTable::getInstance()->ordenDeCompraByIdCampana( $campana->getFechaInicio(), $campana->getFechaFin(), $campana->getIdCampana(), $campanaMarca->getIdMarca(), false, true);
	        	        
	        if ( $huboVenta )
	        {
	            $marca = $campanaMarca->getMarca();
	            	            
    		    $subject = 'Ventas Totales de ' . $marca->getNombre() . ' en ' . $campana->getDenominacion() . '. El envío de la mercadería es a cargo del Proveedor.';
    		    
    		    $vars = array( 'title'   => $subject, 'hash' => $campanaMarca->getHash() );
    		    $mailer = new Mailer('ingresarFechaEntregaCampana', $vars);
    		    $mailer->send( $subject, $emails, sfConfig::get('app_email_from_logistica')  );
    		    
    		    $this->log('Se envio el mail a la marca "' . $marca->getNombre() . '" por la campaña "' . $campana->getDenominacion() . '"');
	        }
	        else
	        {
	            $this->log('No hubo ventas de la marca "' . $marca->getNombre() . '" por la campaña "' . $campana->getDenominacion() . '"');
	        }
		}
		
		$this->log('--- Fin de ejecucion: "enviarCampanaOC"');
	}
}
