<?php

class cacheClearListadosTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'cache-clear-listados';
		$this->briefDescription = 'Borra la cache de los listados cada x tiempo';
		$this->detailedDescription = <<<EOF
La tarea [cache-clear-listados|INFO] Borra la cache de los listados cada x tiempo. 
Call it with: [php symfony deluxebuys:cache-clear-listados|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "cacheClearListados"');
        cacheHelper::getInstance()->clearListados();
		$this->log('--- Fin de ejecucion: "cacheClearListados"');
	}
}
