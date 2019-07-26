<?php

class gearmanRestaurarCampanaWorkerTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'gearman-restaurar-campana-worker';
		$this->briefDescription = 'Inicializa un worker de gearman para el proceso de restauracion de campaña';
		$this->detailedDescription = <<<EOF
La tarea [gearman-worker|INFO] inicializa un worker de gearman para el proceso de restauracion de campaña
Call it with: [php symfony deluxebuys:gearman-restaurar-campana-worker|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{	    
	    $worker = new Net_Gearman_Worker ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
	    
		$worker->addAbility ('RestaurarCampanaWorker');
	    	    
	    $worker->beginWork();
	}
}