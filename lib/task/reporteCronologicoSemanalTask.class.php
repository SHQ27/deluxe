<?php

class reporteCronologicoSemanalTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'reporte-cronologico-semanal';
		$this->briefDescription = 'Genera un archivo excel con el reporte cronologico de la semana anterior';
		$this->detailedDescription = <<<EOF
La tarea [reporte-cronologico-semanal|INFO] genera un archivo excel con el reporte cronologico de la semana anterior
Call it with: [php symfony deluxebuys:reporte-cronologico-semanal|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "reporteCronologicoSemanal"');
				
		$periodo = array();
		$periodo['from'] = date("Y-m-d", strtotime("-7 day"));
		$periodo['to']   = date("Y-m-d", strtotime("-1 day"));
				
		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
		 
		$task = new Net_Gearman_Task ('ReporteCronologicoWorker', array ('periodo' => $periodo, 'idEshop' => null) );
		$task->type = Net_Gearman_Task::JOB_NORMAL;
		
		function complete($func, $handle, $result)  {		
		    $week = date("W", strtotime("-1 day"));
		    $year = date("Y", strtotime("-1 day"));

		    $tempFile = $result['result'];
		    $filename = sfConfig::get('app_reporteCronologico_dir') . '/reporte_cronologico_semana_' . $year . '_' . $week . '.xls';
		    
		    rename($tempFile, $filename);
		}
		$task->attachCallback ("complete",Net_Gearman_Task::TASK_COMPLETE);
		
		$set = new Net_Gearman_Set();
		$set->addTask ($task);
		
		$client->runSet ($set);	
		
		$this->log('--- Fin de ejecucion: "reporteCronologicoSemanal"');
	}  
}
