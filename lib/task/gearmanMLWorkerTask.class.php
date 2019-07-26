<?php

class gearmanMLWorkerTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'gearman-ml-worker';
		$this->briefDescription = 'Inicializa un worker de gearman para procesos con ML';
		$this->detailedDescription = <<<EOF
La tarea [gearman-worker|INFO] inicializa un worker de gearman para procesos con ML
Call it with: [php symfony deluxebuys:gearman-worker|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{	    
	    $worker = new Net_Gearman_Worker ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
	    
	    $worker->addAbility ('ProcesarComprasMLWorker');
	    $worker->addAbility ('ProductosSetCategoriaMLWorker');
	    $worker->addAbility ('ProductosPublicarMLWorker');
	    	    
	    $worker->beginWork();
	}
}