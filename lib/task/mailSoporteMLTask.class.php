<?php

class mailSoporteMLTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'mail-soporte-ml';
		$this->briefDescription = 'Proceso para enviar tickets a zendesk ante un mail recibido en la direccion de soporte de ML';
		$this->detailedDescription = <<<EOF
La tarea [xml-adsnetworks|INFO] es un proceso para enviar tickets a zendesk ante un mail recibido en la direccion de soporte de ML
Call it with: [php symfony deluxebuys:mail-soporte-ml|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "mailSoporteML"');
		
		$config = sfConfig::get('app_ml_emailSoporte');
		
		// Se lee el mailbox para Deluxe Buys
		$this->readMailbox($config['cuenta'], $config['password'] );
		
		// Se lee el mailbox para los eShops habilitados en ML
		$eshopsEnabled = sfConfig::get('app_ml_eshopsEnabled');
		foreach ( $eshopsEnabled as $idEshop ) {
		    $eshop = eshopTable::getInstance()->findOneByIdEshop( $idEshop );
		    $this->readMailbox($eshop->getSoporteEmail(), $eshop->getSoportePass(), $eshop );
		}
				
		$this->log('--- Fin de ejecucion: "mailSoporteML"');
	}

	protected function readMailbox($email, $pass, $eshop = null ) {
	    
	    $params = array();
	    if ( $eshop ) {
	        $params['eShop']   = $eshop->getDenominacion();
	    }
	    
	    $config = sfConfig::get('app_ml_emailSoporte');
	    $carpetaRecepcion = $config['carpeta_recepcion'];
	    $carpetaProcesadas = $config['carpeta_procesadas'];
	    
	    $mailReader = new MailReader("imap.gmail.com", 993, array('ssl' => true ), $email, $pass);
	    
	    $domainsExcluded = array('mercadolibre.com', 'mail.mercadolibre.com', 'facebook.com', 'twitter.com', 'linkedin.com');
	    
	    $response = $mailReader->retrieve($carpetaRecepcion);
	    
	    foreach ($response as $message)
	    {
	        $from = $message['from'];
	    
	        $nombre = trim(substr($from, 0, stripos( $from, '<' ) ));
	        $email = substr($from, stripos( $from, '<' ) + 1, -1 );
	        $email = trim(substr($email, 0, strlen($email) ) );
	        $domain = trim(substr($email, stripos( $email, '@' ) + 1 ));
	    
	        if ( !in_array($domain, $domainsExcluded) ) {	            
	            ZendDeskHelper::getInstance()->createTicket($eshop, $nombre, $email, $message['subject'], $message['body'], $params);
	        }
	    
	        $mailReader->move($message['id'], $carpetaProcesadas);
	    }
	}
}
