<?php

class resetearCampanasTask extends deluxebuysBaseTask
{
    protected $fechaHoy;
    protected $horaActual;
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'resetear-campanas';
		$this->briefDescription = 'Resetea el stock de las campanas finalizadas';
		$this->addOption('fecha', null, sfCommandOption::PARAMETER_OPTIONAL, 'Fecha de ejecucion (Y-m-d)', false);
		$this->addOption('hora', null, sfCommandOption::PARAMETER_OPTIONAL, 'Hora de ejecucion (H:i)', false);
		$this->detailedDescription = <<<EOF
La tarea [resetear-campanas|INFO] resetea el stock de las campanas finalizadas
Call it with: [php symfony deluxebuys:resetear-campanas|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{	    
	    $this->fechaHoy = ( $options['fecha'] ) ? $options['fecha'] : date('Y-m-d', strtotime('today') );
	    $this->horaActual = ( $options['hora'] ) ? $options['hora'] : date('H:i');
	    	    	    		
		$this->resetearCampanas();
	}
	
	
	protected function resetearCampanas()
	{
	    $horasResetear = cacheHelper::getInstance()->get( 'campanas_a_resetear_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ) );
	    $minutosFechaLimiteExtendida = (int) sfConfig::get('app_pedido_minutosFechaLimiteExtendida');
	    $espera = $minutosFechaLimiteExtendida * 60;
	
	    if ( !$horasResetear )
	    {
	        $row = array();
	        	
	        $finalizan = campanaTable::getInstance()->listByFechaFin( $this->fechaHoy );
	        foreach($finalizan as $campana) {
	            $row[ date('H:i', strtotime( $campana->getFechaFin() ) + $espera ) ] = true;
	        }
	         
	        $horasResetear = array_keys($row);
	        $horasResetear = json_encode($horasResetear);
	
	        cacheHelper::getInstance()->set( 'campanas_a_resetear_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ), $horasResetear);
	        $this->log('Se actualiza la cache de campañas a resetar para el dia ' . $this->fechaHoy . ' con la siguiente info: ' . $horasResetear);
	    }
	
	    $horasResetear = json_decode($horasResetear);
	    $result = in_array($this->horaActual, $horasResetear);
	     
	    if ( $result !== false)
	    {
	        $fechaFin = $this->fechaHoy . ' ' . $this->horaActual;
	        $fechaFin = date('Y-m-d H:i', strtotime( $fechaFin ) - $espera );
	        
	        $campanas = campanaTable::getInstance()->listByFechaHoraFin( $fechaFin );
	        $count = count($campanas);
	        
	        $this->log( $count . ' Campañas por resetear. Se inicia el reseteo de las mismas.');
	        
	        foreach($campanas as $campana) {
	            $this->log('Se inicia el eliminado de pedidos fuera de plazo de la campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	            pedidoTable::getInstance()->eliminarPedidosFueraDePlazo( $this );

	            if ( $campana->getResetearAlFinalizar() ) {
	            	$this->doResetearCampana($campana);	
	            } else {
	            	$this->desasignarSinResetearCampana($campana);	
	            }
	        }
	    } else {
	        $this->log('No hay campañas a resetear en este instante de tiempo');
	    }
	}
	
	protected function doResetearCampana($campana)
	{
	     
	    $conn = Doctrine_Manager::connection();
	     
	    $this->log('Inicia Reseteo y Desasignacion - Campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	    
	    try
	    {
	        $conn->beginTransaction();
	         
	        $campana->resetearStock();
	
	        $productoCampanas = productoCampanaTable::getInstance()->listByIdCampana($campana->getIdCampana());
	
	        foreach($productoCampanas as $productoCampana)
	        {
	        	// Agregarlo a campaña finalizada permite utilizar la restauracion de campañas
	            $productoCampanaFinalizada = new productoCampanaFinalizada();
	            $productoCampanaFinalizada->setIdCampana( $productoCampana->getIdCampana() );
	            $productoCampanaFinalizada->setIdProducto( $productoCampana->getIdProducto() );
	            $productoCampanaFinalizada->setFueRestaurada( false );
	            $productoCampanaFinalizada->save();
	
				// Se lo elimina de la campaña
	            $productoCampana->delete();
	            productoLogTable::getInstance()->generate($productoCampana->getIdProducto(), 'Se quita de la Campaña #' . $campana->getIdCampana() . ' dado que esta finalizó.');
	        }
	
	        $this->log('Finaliza Reseteo y Desasignacion - Campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	         
	        $conn->commit();
	         
	    }
	    catch(Doctrine_Exception $e)
	    {
	        errorLogHelper::getInstance()->cronErrorEmail('resetearCampanas', $e->getMessage() );
	        $this->log('Hubo problemas al resetear la campaña "' . $campana->getDenominacion() . '"');
	        $conn->rollback();
	    }
	}

	protected function desasignarSinResetearCampana($campana)
	{
	     
	    $conn = Doctrine_Manager::connection();
	     
	    $this->log('Inicia Desasignacion - Campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	    
	    try
	    {
	        $conn->beginTransaction();
	         	
	        $productoCampanas = productoCampanaTable::getInstance()->listByIdCampana($campana->getIdCampana());
	
	        foreach($productoCampanas as $productoCampana)
	        {
	        	// Se agrega a campaña finalizada y se marca como si ya hubiera sido restaurado
	            $productoCampanaFinalizada = new productoCampanaFinalizada();
	            $productoCampanaFinalizada->setIdCampana( $productoCampana->getIdCampana() );
	            $productoCampanaFinalizada->setIdProducto( $productoCampana->getIdProducto() );
	            $productoCampanaFinalizada->setFueRestaurada( true );
	            $productoCampanaFinalizada->save();
	
				// Se lo elimina de la campaña
	            $productoCampana->delete();
	            productoLogTable::getInstance()->generate($productoCampana->getIdProducto(), 'Se quita de la Campaña #' . $campana->getIdCampana() . ' dado que esta finalizó.');
	        }
	
	        $this->log('Finaliza Desasignacion - Campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	         
	        $conn->commit();
	         
	    }
	    catch(Doctrine_Exception $e)
	    {
	        errorLogHelper::getInstance()->cronErrorEmail('resetearCampanas', $e->getMessage() );
	        $this->log('Hubo problemas al resetear la campaña "' . $campana->getDenominacion() . '"');
	        $conn->rollback();
	    }
	}
	
}