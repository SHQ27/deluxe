<?php

class cacheClearInicioFinTask extends deluxebuysBaseTask
{
    protected $fechaHoy;
    protected $horaActual;
    protected $espera;
    
	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'cache-clear-inicio-fin';
		$this->briefDescription = 'Borra caches en el momento de inicio o finalizacion de campañas y promos de permanente.';
		$this->detailedDescription = <<<EOF
La tarea [cache-clear-inicio-fin-campanas|INFO] borra caches en el momento de inicio o finalizacion de campañas y promos de permanente
Call it with: [php symfony deluxebuys:cache-clear-inicio-fin|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
	    $this->fechaHoy = date('Y-m-d', strtotime('today') );
	    $this->horaActual = date('H:i');
	    $this->espera = 120; // Segundos
	    
	    $resultCampanas = $this->borrarCacheCampanas();
	    $resultOutlet = $this->borrarCacheOutlet();
	    
	    if ( $resultCampanas || $resultOutlet) {
	        $this->borrarCacheGeneral();
	    }
	    
    }
	
	protected function borrarCacheCampanas()
	{
	    $horas = cacheHelper::getInstance()->get( 'campana_cacheClearInicioFin_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ) );
	    
	    if ( !$horas )
	    {
    	    $row = array();
    	     
    	    $empiezan = campanaTable::getInstance()->listByFechaInicio( $this->fechaHoy );
    	    foreach($empiezan as $campana) {
    	        $row[date('H:i', strtotime( $campana->getFechaInicio() ) + $this->espera )] = true;
    	    }
    	
    	    $finalizan = campanaTable::getInstance()->listByFechaFin( $this->fechaHoy );
    	    foreach($finalizan as $campana) {
    	        $row[date('H:i', strtotime( $campana->getFechaFin() ) + $this->espera )] = true;
    	    }
    	     
    	    $horas = array_keys($row);
    	    $horas = json_encode($horas);
    	    
    	    cacheHelper::getInstance()->set( 'campana_cacheClearInicioFin_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ), $horas);
	    }
	    
	    $horas = json_decode($horas);
	    $result = in_array($this->horaActual, $horas);
	     
	    if ( $result !== false)
	    {
	        cacheHelper::getInstance()->deleteByPrefix('campana_listVigentes');
	        cacheHelper::getInstance()->delete('campana_listProximas');
	        cacheHelper::getInstance()->delete('campana_listProximasFecha');
	
	        $this->log('Se borro cache de campañas');
	        return true;
	    }
	    
	    return false;
	}
	
	protected function borrarCacheOutlet()
	{
	    $horas = cacheHelper::getInstance()->get( 'outlet_cacheClearInicioFin_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ) );
	    
	    if ( !$horas )
	    {
    	    $outlet = configuracionTable::getInstance()->getOutlet();
    	    $outletData = json_decode($outlet->getValor(), true);
    
    	    $row = array();
    	    $row[date('H:i', strtotime( $outletData['fecha_inicio'] ) + $this->espera )] = true;
    	    $row[date('H:i', strtotime( $outletData['fecha_fin'] ) + $this->espera )] = true;
    	    
    	    $horas = array_keys($row);
    	    $horas = json_encode($horas);
    	    
    	    cacheHelper::getInstance()->set( 'outlet_cacheClearInicioFin_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ), $horas);
	    }
	    
	    $horas = json_decode($horas);

	    $result = in_array($this->horaActual, $horas);
	
	    if ( $result !== false)
	    {
	        $this->log('Se borro cache de outlet');
	        return true;
	    }
	    
	    return false;
	}
	
	protected function borrarCacheGeneral()
	{
	    cacheHelper::getInstance()->deleteByPrefix('productoCategoria_listByIdProductoGenero');
	    cacheHelper::getInstance()->deleteByPrefix('productoSticker_listVigentes');
	    cacheHelper::getInstance()->deleteByPrefix('bannerPrincipal_listVigentes');
	     
	    cacheHelper::getInstance()->clearListados();
	}
	
}