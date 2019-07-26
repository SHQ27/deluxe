<?php

class facturacionEnvioTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'facturacion-envio';
		$this->briefDescription = 'Envia el mail al cliente avisando que su factura esta lista';
		$this->detailedDescription = <<<EOF
La tarea [facturacion-envio|INFO] envia el mail al cliente avisando que su factura esta lista 
Call it with: [php symfony deluxebuys:facturacion-envio|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "facturacionEnvio"');
				
		$configWS = sfConfig::get('app_afip_ws');
		
	  	$facturas = facturaTable::getInstance()->listPendienteEnvio();	  	
	  	
	  	foreach ($facturas as $factura)
	  	{
	  		$factura->setMailEnviado(true);
	  		$factura->save();
	  		
	  		$pedido = $factura->getPedido();
	  		$usuario = $pedido->getUsuario();
	  		
	  		if ($factura->getEntorno() == Afip::PROD)
	  		{
				$subject = 'Tu factura correspondiente al pedido ' . $pedido->getIdPedido() . ' ya está disponible';
				$vars = array( 'title'   => $subject, 'pedido' => $pedido, 'usuario' => $usuario );
				$mailer = new Mailer('facturaAviso', $vars);
				$mailer->send( $subject, $usuario->getEmail() );
	  		}
	  	}
		
		$this->log('--- Fin de ejecucion: "facturacionEnvio"');
	}  
	
}
