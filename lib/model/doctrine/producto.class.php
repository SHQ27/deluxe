<?php

/**
 * producto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class producto extends Baseproducto
{
    CONST DESTACAR_HOME_ESHOP     = 4;
    CONST DESTACAR_ARRIBA         = 3;
    CONST DESTACAR_MEDIO          = 2;
    CONST DESTACAR_BAJO           = 1;
    
    CONST ORIGEN_STOCK_PERMANENTE = 'STKPER';
    CONST ORIGEN_OUTLET           = 'OUTLET';
    CONST ORIGEN_OFERTA           = 'OFERTA';
    CONST ORIGEN_REFUERZO         = 'REFUER';
    
    CONST POST_ACTION_UPDATE_OCA    		= 'updateOCA';
    CONST POST_ACTION_UPDATE_PRECIO 		= 'updatePrecio';
    CONST POST_ACTION_UPDATE_STOCK   		= 'updateStock';
    CONST POST_ACTION_UPDATE_ML 			= 'updateML';
    CONST POST_ACTION_CERRAR_PUBLICACION_ML = 'cerrarPublicacionML';
    
	protected $esOferta;
	protected $estaAgotado;
	
	protected $doUpdatePrecio = true;
	protected $doUpdateStock = true;
	protected $doCerrarPublicacionML = true;
	protected $doUpdateML = true;
        
	public function serializeReferences($bool=null)
	{
	    return true;
	}
	
	public function preSave($event)   {	    
	    $this->clearCache($event);
	}
	
	public function preDelete($event) {
	    $this->clearCache($event);
	}
	
	public function postUpdate($event)
	{	    	    
	    if ( $this->doCerrarPublicacionML) {
	    	MercadoLibre::getInstance()->cerrarPublicacion($this);
	    }
	    
	    if ( $this->doUpdatePrecio )  {
	        productoTable::getInstance()->updatePrecioDeluxe( $this );
	    }
	     
	    if ( $this->doUpdateStock ) {
	        $this->updateStock();
	    }
	    
	    if ( $this->doUpdateML ) {
	        MercadoLibre::getInstance()->actualizarProducto($this);
	        MercadoLibre::getInstance()->actualizarDescripcion($this);
	    }	    
	    
	}
	
	public function postSave($event)
	{
	    $this->postUpdate($event);
	}
	
	public function doNotPostActions( $notPostActions )
	{
		foreach( $notPostActions as $notPostAction )
		{
			$action = 'do' . ucfirst($notPostAction);
			$this->$action = false;
		}
	}
	
	/*
		Al cambiar el eshop se deben realizar algunas acciones adicionales
	*/
	public function setIdEShop($idEshop)
	{
	    if ( $this->id_eshop != $idEshop ) {

	    	// Se resetea el stock de refuerzo
	    	$observacion = ( $idEshop ) ? 'Asignacion al eShop de la marca' : 'Asignacion al eShop de Deluxe Buys';
	    	$productoItems = $this->getProductoItem();
	    	foreach ($productoItems as $productoItem) {
	    		$productoItem->restaStock( $productoItem->getStockRefuerzo(), producto::ORIGEN_REFUERZO, stockTipo::SISTEMA_RESETEO_REFUERZO, null, $observacion );
	    	}

	    	// Si tiene, se cierra la publicacion en Mercado libre
	    	MercadoLibre::getInstance()->cerrarPublicacion($this, true);
	    }

	    $this->_set('id_eshop', $idEshop);

	    return $this;
	}
	
	
	public function clearCache($event)
	{
	}
	
	public function __toString()
	{
		return $this->getDenominacion();
	}
	
	public function getImageFilename()
	{
	    if ( isset($this->id_producto_imagen_calculado) )
	    {
	        return $this->getIdProductoImagenCalculado() . '.jpg';
	    }
	    else
       {
           $productoImagen = productoImagenTable::getInstance()->getFirst( $this->getIdProducto() );
           return ($productoImagen)? $productoImagen->getIdProductoImagen() . '.jpg' : '';
        }
	}

	public function getProductoImagenHover()
	{
	    if ( isset($this->id_producto_imagen_hover_calculado) )
	    {
	        $productoImagen = new productoImagen();
			$productoImagen->setIdProductoImagen( $this->getIdProductoImagenHoverCalculado() );
			$productoImagen->setIdProducto( $this->getIdProducto() );
			return $productoImagen;
	    }
	    else
        {
           return  productoImagenTable::getInstance()->getLast( $this->getIdProducto() );
        }
	}
	
	public function esOferta()
	{
	    if ( isset($this->es_oferta_calculado) )
	    {
	        return $this->getEsOfertaCalculado();
	    }
	    else
	    {
	        $this->esOferta = productoCampanaTable::getInstance()->exist( $this->getIdProducto() );
	    }
	    
		return $this->esOferta;
	}
	
	public function tieneOfertaOnline()
	{
		$productoCampanas = productoCampanaTable::getInstance()->listByIdProducto( $this->getIdProducto() );
		if ( count($productoCampanas) == 0 ) return false;
		
		$tieneOfertaOnline = false;
		$now = strtotime('now');
		foreach ($productoCampanas as $productoCampana)
		{
			$campana = $productoCampana->getCampana();
			$inicio = (int) strtotime( $campana->getFechaInicio() );
			$fin = (int) strtotime( $campana->getFechaFin() );
			
			if ( $inicio < $now && $now < $fin ) $tieneOfertaOnline = true;
		}
		
		return $tieneOfertaOnline;
	}
	
	public function estaHabilitado()
	{
	    if (!$this->getActivo()) return false;
	    
	    $productoCampanas = productoCampanaTable::getInstance()->listByIdProducto( $this->getIdProducto() );
	    
	    $estaHabilitado = count($productoCampanas) == 0;
	
	    $now = strtotime('now');
	    foreach ($productoCampanas as $productoCampana)
	    {
	        $campana = $productoCampana->getCampana();
	
	        $inicio = (int) strtotime( $campana->getFechaInicio() );
	        $fin = (int) strtotime( $campana->getFechaFin() );
	
	        if ( $inicio < $now && $now < $fin && $campana->getActivo() ) $estaHabilitado = true;
	    }
	
	    return $estaHabilitado;
	}
	
	
	public function hasProbador()
	{
	    if ( !$this->getIdTalleSet() || $this->getProductoCategoria()->getIdProductoGenero() == productoGenero::NINOS ) {
	        return false;
	    }
	    
	    $categoriasSinProbador = array(2,21,22,16,48,66,69,71,72,79,81,73,28,11,24,25,26,29,38,44,49,50,51,52,53,55,58,64,70,74,80, 32);
	    
	    return !in_array( $this->getIdProductoCategoria() , $categoriasSinProbador);
	}
		

	public function getStock()
	{
	    
	    if ( isset( $this->stock_calculado ) )
	    {
	        return $this->getStockCalculado();
	    }
        else
       {
	        $productoItems = $this->getProductoItem();
	        
	        $stock = 0;
	        foreach ($productoItems as $productoItem)
	        {
	            $stock += $productoItem->getStock();
	        }
	    }		
		
		return $stock;
	}
	
	public function getCurrentStock()
	{	    
	    if ( isset( $this->stock_calculado) && isset($this->cantidad_en_carrito_calculado) )
	    {
	        return $this->getStockCalculado() - $this->getCantidadEnCarritoCalculado();
	    }
	    else
	   {
    		$productoItems = $this->getProductoItem();
    		
    		$stock = 0;
    		foreach ($productoItems as $productoItem)
    		{
    			$stock += $productoItem->getCurrentStock();
    		}
    		
    		return $stock;
	   }
	}
	
	public function getStockPermanente()
	{
	    if ( isset( $this->stock_permanente_calculado) )
	    {
	        $stock = $this->getStockPermanenteCalculado();
	    }
	    else
	    {
            $productoItems = $this->getProductoItem();
            
            $stock = 0;
            foreach ($productoItems as $productoItem) $stock += $productoItem->getStockPermanente();
	    }
        
	    return $stock;
	}
	
	public function getStockOutlet()
	{
	    if ( isset( $this->stock_outlet_calculado) )
	    {
	        $stock = $this->getStockOutletCalculado();
	    }
	    else
	    {
    	    $productoItems = $this->getProductoItem();
    	
    	    $stock = 0;
    	    foreach ($productoItems as $productoItem) $stock += $productoItem->getStockOutlet();
	    }

	    return $stock;
	}
	
	public function getStockCampana()
	{
	    if ( isset( $this->stock_campana_calculado) )
	    {
	        $stock = $this->getStockCampanaCalculado();
	    }
	    else
	    {
    	    $productoItems = $this->getProductoItem();
    	
    	    $stock = 0;
    	    foreach ($productoItems as $productoItem) $stock += $productoItem->getStockCampana();
	    }
	
	    return $stock;
	}
			
	public function getVendidosHoy()
	{
		return (int) productoTable::getInstance()->getVendidosHoy( $this->getIdProducto() );
	}	
	
	public function estaAgotado()
	{	    
		if (!$this->estaAgotado)
		{			
			$stock = $this->getCurrentStock();
			$this->estaAgotado = $stock < 1;
		}
				
		return $this->estaAgotado;
	}
	
	public function listTags()
	{
	    $productoTags = $this->getProductoTag();
		
		$tags = array();
		foreach( $productoTags as $productoTag )
		{
			$tags[] = $productoTag->getTag();
		}
		
		return $tags;
	}
	
	public function getSlug()
	{				
	    if ( $this->getIdEshop() ) {
	        return $this->getIdProducto() . '-' . stringHelper::getInstance()->slug($this->getDenominacion());
	    } else {
	        return $this->getIdProducto() . '-' . stringHelper::getInstance()->slug($this->getMarca()->getNombre()) . '-' . stringHelper::getInstance()->slug($this->getDenominacion());
	    }
		
	}
	
	public function getDescripcionCorta($length = 100)
	{
		return truncate_text(strip_tags($this->getDescripcion(ESC_RAW)), $length, '...', ' ');
	}	
	
	public function sumaVenta($cantidad)
	{				
		productoTable::getInstance()->sumaVenta($this->getIdProducto(), $cantidad);
	}
	
	public function restaVenta($cantidad)
	{				
		productoTable::getInstance()->restaVenta($this->getIdProducto(), $cantidad);
	}
	
	public function sumaVisita()
	{				
		productoTable::getInstance()->sumarVisita($this->getIdProducto());
	}
	
	public function getCampana()
	{
	    return campanaTable::getInstance()->getFirstByIdProducto($this->getIdProducto());
	}
			
	public function getDefaultInfoAdicional()
	{				
		return 
    		'
				<ul>
					<li>Disfrutá de nuestra Política de Garantía, si no te queda bien o no te gustó lo que compraste lo podés devolver dentro de los 5 días de recibido.</li>
					<li>Podés abonar con todos los medios de Pago, incluyendo Pagofacil y Rapipago.</li>
					<li>Las entregas se realizan a las 72 hs una vez finalizada la campaña.</li>
					<li>Los cambios se realizan dentro de los 5 días de recibido por intermedio de Deluxe Buys.</li>
				</ul>
    		';
	}
	
    public function getDiversidad($separator = '<br/>')
    {
        $productoCampanas = $this->getProductoCampana();
        
        if (count($productoCampanas))
        {
        	$response = array();
        	foreach ($productoCampanas as $productoCampana)
        	{
        		$response[] = $productoCampana->getCampana()->getDenominacion();
        	}
        	
        	return implode($separator, $response);
        }
        else 
        {
        	return 'Stock Permanente';
        }
    }
        
    public function setEsOutlet($esOutlet)
    {        
    	$this->_set('es_outlet', $esOutlet);
    	
    	if ($esOutlet)
    	{    		
    		// Se elimina la relacion con las campañas asignadas al producto y se anota en el log de producto
    		$productoCampanas = productoCampanaTable::getInstance()->listByIdProducto( $this->getIdProducto() );
    		foreach( $productoCampanas as $productoCampana )
    		{
    		    productoLogTable::getInstance()->generate($this->getIdProducto(), 'Se quita de la Campaña #' . $productoCampana->getIdCampana() . ' dado que el producto se paso a outlet.');
    		    $productoCampana->delete();
    		}
    	}
    	
    	return $this;
    }
    
    public function getDetalleUrl( $absolute = false )
    {
        if ( $this->getIdEshop() ) {
            
            return sfContext::getInstance()->getController()->genUrl(
                array(
                    'sf_route' => 'producto_detalle',
                    'slugProductoCategoria' => $this->getProductoCategoria(true)->getSlug(),
                    'slugProducto' => $this->getSlug()
                ),
                $absolute
            );
            
        } else {

            return sfContext::getInstance()->getController()->genUrl(
                array(
                    'sf_route' => 'producto_detalle',
                    'slugProductoGenero' => $this->getProductoCategoria(true)->getProductoGenero()->getSlug(),
                    'slugProductoCategoria' => $this->getProductoCategoria(true)->getSlug(),
                    'slugProducto' => $this->getSlug()
                ),
                $absolute
            );
            
        }
        
    }
    
    public function getOrigen()
    {
        if ( $this->esOferta() ) return producto::ORIGEN_OFERTA;
        if ( $this->getEsOutlet() ) return producto::ORIGEN_OUTLET;
        return producto::ORIGEN_STOCK_PERMANENTE;
    }
    
    public function getOrigenDenominacion()
    {
        switch ($this->getOrigen())
        {
            case producto::ORIGEN_OFERTA: return 'Campaña';
            case producto::ORIGEN_STOCK_PERMANENTE: return 'Stk. Perm.';
            case producto::ORIGEN_OUTLET: return 'Outlet';
        }
    }
    
    public function updateStock()
    {
        $productoItems = $this->getProductoItem();
        foreach ($productoItems as $productoItem) {
            $productoItem->updateStock();
        }
    }
    
    /**
     * Retorna la informacion sobre la fecha estimada de entrega y su observacion adjunta
     *
     * @return Array
     */
    public function getEstimacionEntrega()
    {
    	if ( $this->getIdEshop() ) {
    		return 'Envío en 96hs Hábiles';
    	}

        $campana =  campanaTable::getInstance()->getFirstByIdProducto( $this->getIdProducto() );
    
		if ( $campana )
        {            

        	if ( $campana->getIdCampana() == 2776 ) {
	    		return 'FECHA ESTIMADA DE ENVÍO ENTRE EL 06 DE NOVIEMBRE Y EL 14 DE NOVIEMBRE.';
	    	}

            if ( $campana && $campana->getIdCampana() == 2798 ) {
                return 'FECHA ESTIMADA DE ENVÍO ENTRE EL 13 DE NOVIEMBRE Y EL 21 DE NOVIEMBRE.';
            }


            if ( $campana->getEstimacionEnvioFecha() )
            {
                return 'Fecha estimada de envío: ' . strftime('%e de %B', strtotime($campana->getEstimacionEnvioFecha()));
            }
            elseif ( $campana->getEstimacionEnvioHoras() )
            {
                return 'Envío en ' . $campana->getEstimacionEnvioHoras() . 'hs Hábiles';
            }
            else
            {
                $timestampFechaFinCampana = strtotime($campana->getFechaFin());
                
                $desde = pmDateHelper::getInstance()->sumarDiasHabiles( 5, 'Y-m-d',  $timestampFechaFinCampana);
                $hasta = pmDateHelper::getInstance()->sumarDiasHabiles( 10, 'Y-m-d', $timestampFechaFinCampana );
                
                return 'Fecha estimada de envío entre el ' . strftime('%e de %B', strtotime($desde)) . ' y el ' . strftime('%e de %B', strtotime($hasta)) . '.';
            }
        }
        
        if ( $this->getEsOutlet() )
        {
            $outletData = configuracionTable::getInstance()->getOutlet();
            $outletData = json_decode($outletData->getValor(), true);
                
            if ( $outletData['estimacion_envio_fecha'] )
            {
                return 'Fecha estimada de envío: ' . strftime('%e de %B', strtotime( $outletData['estimacion_envio_fecha'] ));
            }
            elseif ( $outletData['estimacion_envio_horas'] )
            {
                return 'Envío en ' . $outletData['estimacion_envio_horas'] . 'hs Hábiles';
            }
            else
            {
                $timestampFechaFin = strtotime( $outletData['fecha_fin'] );
                
                $desde = pmDateHelper::getInstance()->sumarDiasHabiles( 5, 'Y-m-d',  $timestampFechaFin);
                $hasta = pmDateHelper::getInstance()->sumarDiasHabiles( 10, 'Y-m-d', $timestampFechaFin );
                
                return 'Fecha estimada de envío entre el ' . strftime('%e de %B', strtotime($desde)) . ' y el ' . strftime('%e de %B', strtotime($hasta)) . '.';
            }            
        }
        
        $timestampFecha = time();
        $desde = pmDateHelper::getInstance()->sumarDiasHabiles( 5, 'Y-m-d', $timestampFecha );
        $hasta = pmDateHelper::getInstance()->sumarDiasHabiles( 10, 'Y-m-d', $timestampFecha );
        
        return 'Fecha estimada de envío entre el ' . strftime('%e de %B', strtotime($desde)) . ' y el ' . strftime('%e de %B', strtotime($hasta)) . '.';
    }
    
    public function getPorcentajeDescuento()
    {
        if ( intval( $this->getPrecioLista() ) ) {
            $percentage = floor( ( 1 - $this->getPrecioDeluxe() / $this->getPrecioLista() ) * 100 );
            return ($percentage % 5 === 0) ? $percentage : $percentage - ( $percentage % 5 );
        }
        
        return null;
    }    
    
    public function getDescripcionML()
    {        
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        
        $estimacionEntrega = $this->getEstimacionEntrega();
        $estimacionEntrega = str_replace('Fecha estimada de envío ', '', $estimacionEntrega);
        
        $campana = $this->getCampana();
        $productoImagenes = $this->getProductoImagen();
        
        
        if ( $this->hasProbador() )
        {
            $usaProbadorDefault = false;
            
            $talleSet = $this->getTalleSet();
            if ( !$talleSet ) {
                $usaProbadorDefault = true;
            };
            
            if ( !$usaProbadorDefault ) {
                $talleSetZonas = talleSetZonaTable::getInstance()->listByIdTalleSet( $talleSet->getIdTalleSet() );
                if ( !count($talleSetZonas) ) {
                    $usaProbadorDefault = true;
                };
            }
            
            // Verifica si tiene que cargar los valores de probador por default
            if ( $usaProbadorDefault )
            {
              $method = 'getDefault' . $this->getProductoCategoria()->getIdProductoGenero();
              $talleSetZonas = talleSetZonaTable::getInstance()->$method();    
            }

            if ( count($talleSetZonas) )
            {
                $zonas = array();
                $talles = array();
                foreach ($talleSetZonas as $talleSetZona)
                {
                    $talleZona = $talleSetZona->getTalleZona();
                    $productoTalle = $talleSetZona->getProductoTalle();;
        
                    $zonas[ $talleZona->getIdTalleZona() ] = $talleZona->getDenominacion();
                    $talles[ $talleSetZona->getIdProductoTalle() ]['talle'] = $productoTalle->getDenominacion();
                    $talles[ $talleSetZona->getIdProductoTalle() ]['data'][ $talleSetZona->getIdTalleZona() ]['desde'] = $talleSetZona->getDesde();
                    $talles[ $talleSetZona->getIdProductoTalle() ]['data'][ $talleSetZona->getIdTalleZona() ]['hasta'] = $talleSetZona->getHasta();
                }
        
                $tablaTalles = array('zonas' => $zonas, 'talles' => $talles);
            }
            else
            {
                $tablaTalles = false;
            }
        }
        else
        {
            $tablaTalles = false;
        }
        
        $partialName = ( $this->getIdEshop() ) ? 'descripcion_ml_eshop' : 'descripcion_ml'; 
        
        
        return get_partial('productos/' . $partialName,
            array(
                'producto' => $this,
                'productoImagenes' => $productoImagenes,
                'marca' => $this->getMarca(),
                'estimacionEntrega' => $estimacionEntrega,
                'campana' => $campana,
                'tablaTalles' => $tablaTalles,
                'idEshop' => $this->getIdEshop()
            )
        );
    }

    public function getCodigos()
    {
    	$codigos = array();
		$productoItems = $this->getProductoItem();
		foreach ($productoItems as $productoItem) {
			$codigos[] = $productoItem->getCodigo();
		}
		
		return array_unique($codigos);
    }
    
}