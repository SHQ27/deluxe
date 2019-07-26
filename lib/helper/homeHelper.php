<?php

class homeHelper
{
	static protected $instance;
	
	protected $config;

	protected function __construct() { }
		
	public static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new homeHelper();
		}
		
		return self::$instance;
	}

	public function getItems($extenderVigencia = 0)
	{
		$items = array();

		// Campanas
	    $campanas = campanaTable::getInstance()->listVigentes($extenderVigencia);

	    $index = 0;
	    foreach ($campanas as $campana) {
	    	if ( $extenderVigencia === 0 && strtotime( $campana->getFechaFin() ) < time() ) continue;
	    	if ( !$campana->getMostrarBanner() ) continue;

	    	$orden = (int) is_numeric( $campana->getOrden() ) ? $campana->getOrden() : 999;
	    	$items[ sprintf( "%'.03d", $orden ) . '_' . $index ] = array('tipo' => 'campana', 'item' => $campana, 'id' => $campana->getIdCampana() );
	    	$index++;
	    }

	    // Banner Principales
	    $bannersPrincipales = bannerPrincipalTable::getInstance()->listVigentes($extenderVigencia);

	    foreach ($bannersPrincipales as $bannerPrincipal) {
	    	if ( $extenderVigencia === 0 && strtotime( $bannerPrincipal->getFechaHasta() ) < time() ) continue;

	    	$orden = (int) is_numeric( $bannerPrincipal->getOrden() ) ? $bannerPrincipal->getOrden() : 999;
	    	$items[ sprintf( "%'.03d", $orden ) . '_' . $index ] = array('tipo' => 'bannerPrincipal', 'item' => $bannerPrincipal, 'id' => $bannerPrincipal->getIdBannerPrincipal());
	    	$index++;
	    }

		// Outlet
	    $outletData = configuracionTable::getInstance()->getOutlet();
	    $outletData = json_decode($outletData->getValor(), true);
        $outlet = new outlet();
        $outlet->setData($outletData);

	    if ( $outletData['activo'] && $outletData['mostrar_banner'] && strtotime($outletData['fecha_inicio']) < time() &&  time() < strtotime($outletData['fecha_fin']) ) {
	    	$orden = (int) is_numeric( $outletData['orden'] ) ? $outletData['orden'] : 999; 
	    	$items[  sprintf( "%'.03d", $orden ) . '_' . $index ] = array('tipo' => 'outlet', 'item' => $outlet, 'id' => 'outlet' );
	    }
        ksort($items);
        $items = array_values($items);

	    return $items;
	}

}



