<?php

class eliminarDescuentosNoUtilizadosTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
				
		$this->name             = 'eliminar-descuentos-no-utilizado';
		$this->briefDescription = 'Elimina todos los descuentos que hayan expirado y todavia no hayan sido usados';
		$this->detailedDescription = <<<EOF
La tarea [eliminar-descuentos-no-utilizado|INFO] elimina todos los descuentos que hayan expirado y todavia no hayan sido usados.
Call it with: [php symfony deluxebuys:eliminar-pedidos-truncados|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "eliminarDescuentosNoUtilizado"');
		
		descuentoTable::getInstance()->deleteNoUtilizados();
		
		$this->log('--- Fin de ejecucion: "eliminarDescuentosNoUtilizado"');
	}  
}
