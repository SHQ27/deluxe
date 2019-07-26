<?php

class enviarEshopsOCTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'enviar-eshops-oc';
		$this->briefDescription = 'Envia la orden de compra diaria a cada uno de los eshops.';
		$this->detailedDescription = <<<EOF
La tarea [enviar-campana-oc|INFO] envia la orden de compra diaria a cada uno de los eshops. 
Call it with: [php symfony deluxebuys:enviar-campana-oc|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "enviarEshopsOC"');
		
		$fecha = date( 'Y-m-d', strtotime('-1 days') );
		$fechaLegible = date('d-m-Y', strtotime($fecha) );
		
		$eshops = eshopTable::getInstance()->listAll();
		
		foreach( $eshops as $eshop )
		{
			// Si no hay destinatarios definidos no se le envia la OC
			if ( !$eshop->getMailsOC() ) {
				continue;
			}
     
			$productos = ordenCompraHelper::getInstance()->makeOrdenCompra($eshop->getIdEshop(), $fecha . ' 00:00:00', $fecha . ' 23:59:59', $eshop->getIdMarca() );

			// Si no hay ventas no se envia la OC
			if ( !count($productos) ) {
				continue;
			}

	        $params = array(
				'idEshop' => $eshop->getIdEshop(),
				'fecha' => $fecha,
				'hash' => $eshop->getHashResumenPedidos( $fecha )
        	);

        	$hash = base64_encode( json_encode($params) );

		    $subject = $eshop->getDenominacion() . ' - Ventas del eShop durante el ' . $fechaLegible;
		    
		    if ( $eshop->getMailsOC() ) {
		    	$emails = explode(',', $eshop->getMailsOC() );
		    } else {
		    	$emails = array();
		    }
		    
		    $emails[] = sfConfig::get('app_email_from_logistica');
	       
		    $vars = array( 'title' => $subject, 'eshop' => $eshop, 'productos' => $productos, 'hash' => $hash, 'fecha' => $fechaLegible );

		    $mailer = new Mailer('enviarEshopOC', $vars);
		    $mailer->send( $subject, $emails, sfConfig::get('app_email_from_logistica') );

	        $this->log('Se envio el mail al eshop "' . $eshop->getDenominacion() . '"');
		}
		
		$this->log('--- Fin de ejecucion: "enviarEshopsOC"');
	}
}
