<?php

class eliminarPedidosTruncadosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'eliminar-pedidos-truncados';
		$this->briefDescription = 'Elimina los pedidos que no hayan llegado a MP.';
		$this->detailedDescription = <<<EOF
La tarea [eliminar-pedidos-truncados|INFO] elimina los pedidos que no hayan llegado a MP,
para esto verifica si se recibió informacion de algun tipo desde MP en las ultimas X hs
Call it with: [php symfony deluxebuys:eliminar-pedidos-truncados|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "eliminarPedidosTruncados"');
		
		$pedidosTruncados = pedidoTable::getInstance()->listTruncados();
				
		foreach($pedidosTruncados as $pedido)
		{			
			$pedido->procesarBaja('Baja de pedido #' . $pedido->getIdPedido() . ' desde la task "eliminarPedidosTruncados"');
			$this->log('id_pedido= ' . $pedido->getIdPedido() . ' -> Dado de Baja!' );
		}
	
		$this->log('--- Fin de ejecucion: "eliminarPedidosTruncados"');
	}  
}
