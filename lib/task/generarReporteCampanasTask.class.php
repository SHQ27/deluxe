<?php

class generarReporteCampanasTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'generar-reporte-campanas';
		$this->briefDescription = 'Genera el reporte de campañas para las campañas que terminaron ayer';
		$this->detailedDescription = <<<EOF
La tarea [generar-reporte-campanas|INFO] genera el reporte de campañas para las campañas que terminaron ayer
Call it with: [php symfony deluxebuys:generar-reporte-campanas|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{		
		$this->log('--- Comienzo de ejecucion: "generarReporteCampanas"');
			
		$conn = Doctrine_Manager::connection();
		
		try
		{
		    $conn->beginTransaction();		
				    
    		$fechaAyer = date( 'Y-m-d', strtotime('-' . sfConfig::get('app_campana_diasReseteo') . ' days') );
    		
    		$campanas = campanaTable::getInstance()->listByFechaFin( $fechaAyer );
    		    		    		
    		foreach($campanas as $campana) $this->generarReporte($campana);
    		    		
    		$conn->commit();
    		
		}
		catch(Doctrine_Exception $e)
		{
		    echo $e->getMessage();
		    
		    $this->log('Fallo la ejecucion del Cron.');
		    $conn->rollback();
		}
    		
		
		$this->log('--- Fin de ejecucion: "generarReporteCampanas"');
	}
	
	protected function generarReporte($campana)
	{	    
	    $data = campanaTable::getInstance()->getReporteCampana( $campana->getIdCampana() );
	    
        $reporteCampana = reporteCampanaTable::getInstance()->fillObject( $campana->getIdCampana(), $data );
	    $reporteCampana->save();	    
	    
	    $this->log('Se genero el reporte de campaña para la campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');	    
	}
	
}