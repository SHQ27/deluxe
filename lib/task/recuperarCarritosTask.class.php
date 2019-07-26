<?php

class recuperarCarritosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'recuperar-carritos';
		$this->briefDescription = 'Intenta recuperar carritos mediante el envio de un mail';
		$this->detailedDescription = <<<EOF
La tarea [recuperar-carritos|INFO] intenta recuperar carritos mediante el envio de un mail
Call it with: [php symfony deluxebuys:recuperar-carritos|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "recuperarCarritos"');
		
		$pedidosARecuperar = pedidoTable::getInstance()->listForRecuperarCarritos();
		
		$mailsEnviados = 0;
		foreach( $pedidosARecuperar as $pedido ) {
		    
		    $pedidoProductoItems = $pedido->getPedidoProductoItem();

		    $pedidoProductoItemRecuperables = array();
		    foreach ($pedidoProductoItems as $pedidoProductoItem) {
		        $productoItem = $pedidoProductoItem->getProductoItem();
		        $producto = $productoItem->getProducto();
		        		        
		        if ( $producto->estaHabilitado() && $productoItem->getCurrentStock() > 0 ) {
		            $pedidoProductoItemRecuperables[] = $pedidoProductoItem;
		        }
		    }
		    		    
		    $enviarMail = (bool) count( $pedidoProductoItemRecuperables );
		    
		    $hash = null;
		    if ( $enviarMail ) {
		        
		        $usuario = $pedido->getUsuario();
		        $fechaLimite = $pedido->getFechaLimite();
		        $hash = sha1( $pedido->getIdPedido() . '_' . $usuario->getIdUsuario() . '_' . time() );
		        
		        $subject = 'Algo muy especial te esta esperando';
		        $mailer = new Mailer('recuperarCarrito', array( 'usuario' => $usuario, 'pedidoProductoItems' => $pedidoProductoItemRecuperables, 'fechaLimite' => $fechaLimite, 'hash' => $hash ));
		        $mailer->send( $subject, $usuario->getEmail() );
		        $mailsEnviados++;
		    }

		    $recuperoCarrito = new recuperoCarrito();
		    $recuperoCarrito->setIdPedido( $pedido->getIdPedido() );
		    $recuperoCarrito->setMailEnviado( $enviarMail );
		    $recuperoCarrito->setHash( $hash );
		    $recuperoCarrito->save();
		}
		
		$total = count( $pedidosARecuperar );
		
		$this->log('Se enviaron ' . $mailsEnviados . ' mails de un total de ' . $total . ' carritos.');		
		$this->log('--- Fin de ejecucion: "recuperarCarritos"');
	}
}
