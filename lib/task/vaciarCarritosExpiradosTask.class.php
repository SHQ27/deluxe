<?php

class vaciarCarritosExpiradosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'vaciar-carritos-expirados';
		$this->briefDescription = 'Vacia los carritos que tienen mas de X tiempo';
		$this->detailedDescription = <<<EOF
La tarea [vaciar-carritos-expirados|INFO] vacia los carritos que tienen mas de X tiempo
Call it with: [php symfony deluxebuys:vaciar-carritos-expirados|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "vaciarCarritosExpirados"');
		
		
		$sessionesConCarritoDescuento = sessionTable::getInstance()->listSessionesExpiradas(true);
		
		foreach($sessionesConCarritoDescuento as $session)
		{
		    $carritosDescuento = $session->getCarritoDescuento();
		    
		    foreach( $carritosDescuento as $carritoDescuento )
		    {
    		    $carritoDescuento->getDescuento()->devolver();
    		    $carritoDescuento->delete();
		    }
		}

		$sessiones = sessionTable::getInstance()->listSessionesExpiradas();
		
		$idsSession = array();
		foreach($sessiones as $session)
		{
		    $idsSession[] = $session->getIdSession();
		}
		
		carritoBonificacionTable::getInstance()->deleteAllByIdSession( $idsSession );
		carritoEnvioTable::getInstance()->deleteAllByIdSession( $idsSession );
		carritoProductoItemTable::getInstance()->deleteAllByIdSession( $idsSession );
		sessionTable::getInstance()->deleteAllByIdSession( $idsSession );
		
		$this->log('Se eliminaron ' . count( $idsSession ) . ' sessiones de carritos expirados.' );
	
		
		$this->log('--- Fin de ejecucion: "vaciarCarritosExpirados"');
	}  
}
