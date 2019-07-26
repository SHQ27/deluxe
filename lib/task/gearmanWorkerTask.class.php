<?php

class gearmanWorkerTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'gearman-worker';
		$this->briefDescription = 'Inicializa un worker de gearman';
		$this->detailedDescription = <<<EOF
La tarea [gearman-worker|INFO] inicializa un worker de gearman
Call it with: [php symfony deluxebuys:gearman-worker|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{	    
	    $worker = new Net_Gearman_Worker ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
	    
	    $worker->addAbility ('ImportarProductoWorker');
	    $worker->addAbility ('ReporteCronologicoWorker');
	    $worker->addAbility ('VerificarFacturaOcaWorker');
	    $worker->addAbility ('ReporteCampanasWorker');
	    $worker->addAbility ('LibroIvaVentaWorker');
	    $worker->addAbility ('CitiVentasWorker');
	    $worker->addAbility ('EditStockWorker');
	    $worker->addAbility ('EditPricesWorker');
	    $worker->addAbility ('CampanaAsignacionCSVWorker');
	    $worker->addAbility ('EdicionStockPrecioCSVWorker');
	    $worker->addAbility ('ProductosSetOutletWorker');
	    $worker->addAbility ('PrepararEnvioWorker');
	    $worker->addAbility ('HojaDeRutaWorker');
	    	    
	    $worker->beginWork();
	}
}