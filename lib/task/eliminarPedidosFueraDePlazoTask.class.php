<?php

class eliminarPedidosFueraDePlazoTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'eliminar-pedidos-fuera-de-plazo';
		$this->briefDescription = 'Da de baja y cancela en MP todos los pedidos que han superado su fecha limite de pago';
		$this->detailedDescription = <<<EOF
La tarea [deluxebuys:eliminar-pedidos-fuera-de-plazo|INFO] da de baja y cancela en MP todos los pedidos que han superado su fecha limite de pago
Call it with: [php symfony deluxebuys:eliminar-pedidos-fuera-de-plazo|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "eliminarPedidosFueraDePlazoTask"');
		
		pedidoTable::getInstance()->eliminarPedidosFueraDePlazo( $this );
		
		$this->log('--- Fin de ejecucion: "eliminarPedidosFueraDePlazoTask"');
	}  
}
