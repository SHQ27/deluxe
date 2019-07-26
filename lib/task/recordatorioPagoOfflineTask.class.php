<?php

class recordatorioPagoOfflineTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'recordatorio-pago-offline';
		$this->briefDescription = 'Envia un recordatorio diario para el pago de pedidos realizados con medios offline';
		$this->detailedDescription = <<<EOF
La tarea [recordatorio-pago-offline|INFO] envia un recordatorio diario para el pago de pedidos realizados con medios offline
Call it with: [php symfony deluxebuys:recordatorio-pago-offline|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "recordatorioPagoOffline"');
		
		$pedidos = pedidoTable::getInstance()->listRecordatorioPagoOffline();
				
		foreach($pedidos as $pedido)
		{
			$segundosLimite = $pedido->getFechaLimiteConTolerancia('U');
			if ( time() >= $segundosLimite ) continue;
			
			$avisoPedido = $pedido->getAvisoPedido()->getFirst();
			
		    if (!$avisoPedido)
		    {
		        $avisoPedido = new avisoPedido();
		        $avisoPedido->setIdTipoAvisoPedido( tipoAvisoPedido::RECORDATORIO_OFF );
		        $avisoPedido->setIdPedido( $pedido->getIdPedido() );
		        
		        $hash = md5( $pedido->getIdPedido() . '-' . $pedido->getEmail() . time() );		        
		        $avisoPedido->setHash( $hash );
		    }
		    
		    $avisoPedido->setFecha( new Doctrine_Expression('now()') );
			$avisoPedido->save();
			
			$usuario = $pedido->getUsuario();
			
			// Envio el recordatorio via mail
			if ( $pedido->getIdEshop() ) {
			    $eshop = $pedido->getEshop();
			    $from = $eshop->getEmailNoReply();
			    $tipoMail  = 'ESHOP';
			} else {
			    $eshop = false;
			    $from = sfConfig::get('app_email_from_noreply');
			    $tipoMail  = 'DELUXE';
			}
			
			$subject = 'Recordatorio de pago. Pedido #' . $pedido->getIdPedido();
			$vars = array( 'eshop'   => $eshop, 'title'   => $subject, 'pedido' => $pedido, 'usuario' => $usuario, 'hash' => $avisoPedido->getHash() );
			$mailer = new Mailer('recordatorioPagoOffline' . $tipoMail, $vars);
			$mailer->send( $subject, $usuario->getEmail(), $from );
			
			$this->log('id_pedido= ' . $pedido->getIdPedido() . ' -> Se envio recordatorio de pago!' );
		}
	
		
		$this->log('--- Fin de ejecucion: "recordatorioPagoOffline"');
	}  
}
