<?php


class campanaTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de campanaTable;
	* 
	* @return campanaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('campana');
    }

    
	/**
	* Retorna las campañas activas y vigentes;
	* 
	* @return Doctrine_Collection
	*/
	public function listVigentes($extenderVigencia = 0)
	{	    


		$query =  $this->createQuery('c')
		            ->addSelect('c.id_campana, c.denominacion, c.texto_promocion, c.fecha_inicio, c.fecha_fin, c.mostrar_descripcion, c.mostrar_banner, c.orden, c.slug, c.activo')
    			    ->addWhere('DATE_SUB(c.fecha_inicio, INTERVAL ? DAY) < NOW() AND NOW() < c.fecha_fin', array( $extenderVigencia ))
    			    ->addWhere('c.activo = ?', true)
    			    ->orderBy('c.orden ASC');
		
		$query->useResultCache(true, null, 'campana_listVigentes_' . cacheHelper::getInstance()->genKey($extenderVigencia) );
		
    	$campanas = $query->execute();
    			    
		foreach ($campanas as $key => $campana)
		{
			if ( strtotime($campana->getFechaFin()) <= strtotime('now') ) $campanas->remove($key);
		}    			    
    			    
		return $campanas;
	}
	
	/**
	* Retorna las campañas activas y vigentes;
	* 
	* @return Doctrine_Collection
	*/
	public function getVigenteByIdMarca($idMarca)
	{
		return $this->createQuery('c')
					->innerJoin('c.campanaMarca cm')
    			    ->addWhere('c.fecha_inicio < NOW() AND NOW() < c.fecha_fin ')
    			    ->addWhere('c.activo = ?', true)
    			    ->addWhere('cm.id_marca = ?', $idMarca)	
    			    ->fetchOne();
	}
	
	/**
	 * Retorna el listado de campañas asociadas a una marca
	 *
	 * @return Doctrine_Collection
	 */
	public function getByIdMarca($idMarca)
	{
	    return $this->createQuery('c')
	    ->innerJoin('c.campanaMarca cm')
	    ->addWhere('cm.id_marca = ?', $idMarca)
	    ->execute();
	}
	
	/**
	 * Retorna las campañas a las que es posible restaurar su stock
	 *
	 * @return Doctrine_Collection
	 */
	public function listPosiblesRestaurarStock()
	{
	    $data =  $this  ->createQuery('c')
                	    ->select('c.id_campana, c.denominacion, c.fecha_inicio, c.fecha_fin, m.id_marca, m.nombre, pc.id_producto_categoria, pc.denominacion, pg.denominacion')
                	    ->innerJoin('c.productoCampanaFinalizada pcf')
                	    ->innerJoin('pcf.producto p')
                	    ->innerJoin('p.productoCategoria pc')
                	    ->innerJoin('pc.productoGenero pg')
                	    ->innerJoin('p.marca m')
                	    ->addWhere('DATE_SUB(CURDATE(),INTERVAL 12 MONTH) <= c.fecha_inicio')
                	    ->addWhere('pcf.fue_restaurada = false')                	    
                	    ->orderBy('c.denominacion, m.nombre, pg.denominacion, pc.denominacion')
                	    ->execute( null, Doctrine::HYDRATE_SCALAR);

	    $response = array();
	    foreach( $data as $row )
	    {
	        $idCampana             = $row['c_id_campana'];
	        $idMarca               = $row['m_id_marca'];
	        $idProductoCategoria   = $row['pc_id_producto_categoria'];

	        if ( !isset($response[ $idCampana ]) )
	        {
	            $response[ $idCampana ]['id_campana'] = $idCampana;
	            $response[ $idCampana ]['denominacion'] = $row['c_denominacion'];
	            $response[ $idCampana ]['fecha_inicio'] = $row['c_fecha_inicio'];
	            $response[ $idCampana ]['fecha_fin'] = $row['c_fecha_fin'];
	            $response[ $idCampana ]['marcas'] = array();
	            $response[ $idCampana ]['categorias'] = array();
	        }
	        
	        $response[ $idCampana ]['marcas'][$idMarca] = array('id_marca' => $idMarca, 'nombre' => $row['m_nombre'] );
	        $response[ $idCampana ]['categorias'][$idProductoCategoria] = array('id_producto_categoria' => $idProductoCategoria, 'denominacion' => $row['pg_denominacion'] . ' :: ' . $row['pc_denominacion'] );
	    }

	    return $response;
	}
	
	/**
	 * Retorna las campañas que terminan en la fecha y hora enviada como parametro
	 *
	 * @param string $fechaFin
	 *
	 * @return Doctrine_Collection
	 */
	public function listByFechaHoraFin($fechaFin)
	{
	    return $this->createQuery('c')
	    ->addWhere('DATE_FORMAT(c.fecha_fin,\'%Y-%m-%d %H:%i\') = ?', $fechaFin)
	    ->execute();
	}
	
	/**
	 * Retorna las campañas que terminan en la fecha enviada como parametro
	 *
	 * @param string $fechaFin
	 *
	 * @return Doctrine_Collection
	 */
	public function listByFechaFin($fechaFin)
	{
	    return $this->createQuery('c')
	    ->addWhere('date(c.fecha_fin) = ?', $fechaFin)
	    ->execute();
	}
	
	/**
	 * Retorna las campañas que inician en la fecha enviada como parametro
	 *
	 * @param string $fechaInicio
	 *
	 * @return Doctrine_Collection
	 */
	public function listByFechaInicio($fechaInicio)
	{
	    return $this->createQuery('c')
	    ->addWhere('date(c.fecha_inicio) = ?', $fechaInicio)
	    ->execute();
	}

	
	/**
	 * Retorna las campañas que finalizaron desde una fecha determinada
	 *
	 * @param string $fechaFin
	 *
	 * @return Doctrine_Collection
	 */
	public function finalizadasDesde($fechaFin)
	{
	    return $this->createQuery('c')
	    			->addWhere('date(c.fecha_fin) >= ?', $fechaFin)
	    			->addWhere('c.fecha_fin <= NOW()')
	    			->orderBy('c.fecha_fin ASC')
	    			->execute();
	}
	

	
	/**
	 * Retorna las campañas que iniciaron en los ultimos x meses
	 *
	 * @param int $meses
	 *
	 * @return Doctrine_Collection
	 */
	public function listUltimas($dias = 240)
	{
	    return $this->createQuery('c')
	    ->addWhere('DATE_SUB(CURDATE(),INTERVAL ? DAY) < c.fecha_inicio', $dias)
	    ->orderBy('c.denominacion ASC, c.fecha_inicio ASC, c.fecha_fin ASC')
	    ->execute();
	}
	
	/**
	* Retorna todas las proximas campañas activas;
	* 
	* @return Doctrine_Collection
	*/
	public function listProximas()
	{
		return $this->createQuery('c')
    			    ->addWhere('c.fecha_inicio > now()')
    			    ->addWhere('c.activo = ?', true)
    			    ->orderBy('c.fecha_inicio ASC')
					->useResultCache(true, null, cacheHelper::getInstance()->genKey('campana_listProximas') )
					->execute();
	}
	
	/**
	 * Retorna las proximas campañas activas del primer dia con proxima campaña;
	 *
	 * @return Doctrine_Collection
	 */
	public function listProximasFecha()
	{
		return $this->createQuery('c')
					->addWhere('date(c.fecha_inicio) = (SELECT DATE(c2.fecha_inicio) FROM campana c2 WHERE c2.activo = true and date(c2.fecha_inicio) > date(now()) order by c2.fecha_inicio LIMIT 1 )')
					->addWhere('c.activo = ?', true)
					->orderBy('c.fecha_inicio ASC')
					->useResultCache(true, null, cacheHelper::getInstance()->genKey('campana_listProximasFecha') )
					->execute();
	}
	
	/**
	 * Retorna las campañas finalizadas y desactivadas;
	 *
	 * @return Doctrine_Collection
	 */
	public function listFinalizadasYDesactivadas($num = null)
	{
	    $fechaAyer = date( 'Y-m-d', strtotime('-' . sfConfig::get('app_campana_diasReseteo') . ' days') );

	    
	    return $this->createQuery('c')
                    ->addWhere('date(c.fecha_fin) < ?', $fechaAyer)
                    ->addWhere('c.activo = ?', false)
                    ->orderBy('c.denominacion, c.fecha_fin')
                    ->execute();
	}
	
	/**
	* Agrupa una coleccion de campañas por fecha
	* 
	* @return array
	*/
	public function groupByFechaInicio($campanas)
	{
	  	$campanasVigentes = array();
	  	
	  	$dateFormat = new sfDateFormat( sfContext::getInstance()->getUser()->getCulture() );
	  	
	  	foreach($campanas as $campana)
	  	{
	  		$campanasVigentes[ $dateFormat->format($campana->getFechaInicio(), 'yyyy-MM-dd') ][] = $campana; 
	  	}
	  	return $campanasVigentes;
	}
	
	/**
	* Retorna la campaña a partir de un slug
	* 
	* @return campana
	*/
	public function getBySlug($slug)
	{
		return $this->createQuery('c')
		            ->select('c.*, cm.*, m.*')
		            ->innerJoin('c.campanaMarca cm')
		            ->innerJoin('cm.marca m')
    			    ->addWhere('c.slug = ?', $slug)
    			    ->addWhere('c.activo = ?', true)
    			    ->orderBy('c.id_campana desc')
    			    ->fetchOne();
	}
	
	/**
	* Retorna la campaña a partir su id
	* 
	* @param integer $idCampana
	* 
	* @return campana
	*/
	public function getById($idCampana)
	{
		return $this->createQuery('c')
    			    ->addWhere('c.id_campana = ?', $idCampana)
    			    ->fetchOne();
	}
	

	public function getFirstByIdProducto($idProducto)
	{
		$query = $this->createQuery('c')
					  ->select('c.*')
					  ->innerJoin('c.productoCampana pc')
					  ->addWhere('pc.id_producto = ?', $idProducto)
					  ->orderBy('c.id_campana desc')
					  ->useResultCache(true, null, cacheHelper::getInstance()->genKey( 'campana_getFirstByIdProducto_' . $idProducto) )					  
					  ->limit(1);
		
		return $query->fetchOne();
	}
	
	
	/**
	* Retorna la fecha en que finaliza la primera campaña, si existe, de lo contrario retorna false
	* 
	* @param integer $idPedido
	* 
	* @return timestamp
	*/
    public function getFechaPrimeraCampanaByIdPedido($idPedido)
    {
		return $this->createQuery('c')
							->select('c.fecha_fin')
							->innerJoin('c.pedidoProductoItemCampana ppic')
							->innerJoin('ppic.pedidoProductoItem ppi')
							->addWhere('ppi.id_pedido = ?', $idPedido)
							->addWhere('c.mostrar_reloj = ?', true)
							->orderBy('c.fecha_fin asc')
							->limit(1)
							->fetchOne( array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR );							
    }
    
	/**
	* Retorna la fecha en que finaliza la ultima campaña, si existe, de lo contrario retorna false
	* 
	* @param integer $idPedido
	* 
	* @return timestamp
	*/
    public function getFechaUltimaCampanaByIdPedido($idPedido)
    {
		return $this->createQuery('c')
							->select('c.fecha_fin')
							->innerJoin('c.pedidoProductoItemCampana ppic')
							->innerJoin('ppic.pedidoProductoItem ppi')
							->addWhere('ppi.id_pedido = ?', $idPedido)
							->orderBy('c.fecha_fin desc')
							->limit(1)
							->fetchOne( array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR );							
    }
    
    /**
     * Retorna la fecha en que finaliza la ultima campaña, si existe, de lo contrario retorna false
     *
     * @param integer $idPedido
     *
     * @return timestamp
     */
    public function getCampanaEstimacionEntregaByIdPedido($idPedido)
    {
    	return $this->createQuery('c')
    	->select('c.*')
    	->innerJoin('c.pedidoProductoItemCampana ppic')
    	->innerJoin('ppic.pedidoProductoItem ppi')
    	->addWhere('ppi.id_pedido = ?', $idPedido)
    	->orderBy('c.estimacion_envio_fecha desc')
    	->limit(1)
    	->fetchOne();
    }
    
    
	/**
	* Retorna la fecha en que finaliza la primera campaña, si existe, de lo contrario retorna false
	* 
	* @param array
	* 
	* @return timestamp
	*/
    public function getFechaPrimeraCampanaByIdProductos($idProductos)
    {
		return $this->createQuery('c')
							->select('c.fecha_fin')
							->innerJoin('c.productoCampana pc')
							->whereIn('pc.id_producto', $idProductos)
							->addWhere('c.mostrar_reloj = ?', true)
							->orderBy('c.fecha_fin asc')
							->limit(1)
							->fetchOne( array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR );							
    }
    
    /**
     * Retorna la primera campaña, si existe, de lo contrario retorna false
     *
     * @param array
     *
     * @return campana
     */
    public function getPrimeraCampanaByIdProductos($idProductos)
    {
        return $this->createQuery('c')
        ->select('c.*')
        ->innerJoin('c.productoCampana pc')
        ->whereIn('pc.id_producto', $idProductos)
        ->addWhere('c.mostrar_reloj = ?', true)
        ->orderBy('c.fecha_fin asc')
        ->limit(1)
        ->fetchOne();
    }
    
	/**
	* Retorna todas las campañas
	* 
	* @return Doctrine_Collection
	*/
	public function listAll()
	{
		return $this->createQuery('c')
    			    ->orderBy('c.denominacion ASC, c.fecha_inicio ASC, c.fecha_fin ASC')
    			    ->execute();
	}
	
	/**
	* Retorna la campaña que primero vence que tiene el id de producto enviado por parametro 
	* 
    * @param producto $producto
	* 
	* @return campana
	*/
    public function getFirstFinishedByIdProducto($idProducto)
    {    
		return $this->createQuery('c')
				    ->innerJoin('c.productoCampana pc')
		            ->addwhere('pc.id_producto = ?', $idProducto)
				    ->orderBy('c.fecha_fin ASC')
				    ->fetchOne();
    }
    
    /**
     * Retorna la campaña asociada a un pedido
     *
     * @param int $idPedido
     *
     * @return campana
     */
    public function getByIdPedido($idPedido)
    {
        return $this->createQuery('c')
                    ->select('c.*')
                    ->innerJoin('c.pedidoProductoItemCampana ppic')
                    ->innerJoin('ppic.pedidoProductoItem ppi')
                    ->addwhere('ppi.id_pedido = ?', $idPedido)
                    ->fetchOne();        
    }
    
    /**
     * Reporte de Venta de la campaña
     *
     * @param $idCampana
     *
     * @return array
     */
    public function getReporteVenta($idCampana)
    {
    	$result = $this->createQuery('c')
    	->select('c.id_campana, DATE(p.fecha_pago), ppi.id_producto_item, sum(ppi.cantidad)')
    	->innerJoin('c.pedidoProductoItemCampana ppic')
    	->innerJoin('ppic.pedidoProductoItem ppi')
    	->innerJoin('ppi.pedido p')
    	->addwhere('p.id_eshop IS NULL')
    	->addwhere('p.fecha_pago IS NOT NULL')
    	->addwhere('c.id_campana = ?', $idCampana)
    	->groupBy('c.id_campana, ppi.id_producto_item, DATE(p.fecha_pago)')
    	->execute(array(), Doctrine::HYDRATE_SCALAR);
    	   	
    	$return = array();
    	foreach($result as $row)
    	{ 
    		if ( !isset( $return[ $row['p_DATE'] ][ $row['ppi_id_producto_item'] ] ) )
    		{
    			$return[ $row['p_DATE'] ][ $row['ppi_id_producto_item'] ] = $row['ppi_sum'];
    		}
    		else
    		{
    			$return[ $row['p_DATE'] ][ $row['ppi_id_producto_item'] ] += $row['ppi_sum'];
    		}
    	}
    	return $return;
    }
    
    
    /**
     * Reporte de campañas
     *
     * @param $idCampanas
     *
     * @return array
     */
    public function getReporteCampana($idCampana)
    {        
        $dataCampana = $this->createQuery('c')
                            ->select('c.id_campana, c.denominacion, c.fecha_inicio, c.fecha_fin, c.objetivo_facturacion, c.total_stock')
                            ->addSelect('SUM(ppi.cantidad) AS unidades_vendidas')
                            ->addSelect('SUM(ppi.cantidad * ppi.precio_deluxe) AS precio_deluxe')
                            ->addSelect('SUM(ppi.cantidad * ppi.costo) AS costo')
                            ->innerJoin('c.pedidoProductoItemCampana ppic')
                            ->innerJoin('ppic.pedidoProductoItem ppi')
                            ->innerJoin('ppi.pedido p')
                            ->innerJoin('p.usuario u')
                            ->addWhere('p.id_eshop IS NULL')
            			    ->addWhere('(c.fecha_inicio <= p.fecha_pago AND  p.fecha_pago <= c.fecha_fin)')
            			    ->addWhere('p.fecha_baja IS NULL')
                            ->addWhere('c.id_campana = ?', $idCampana)
                            ->fetchArray();
        
        $dataCampana = current($dataCampana);
                
        $dataPedido = $this ->createQuery('p')
                            ->select('SUM(p.monto_total) AS total_facturado')
                            ->addSelect("SUM( IF(u.sexo = 'h', 1, 0) ) AS hombres")
                            ->addSelect("SUM( IF(u.sexo = 'm', 1, 0) ) AS mujeres")
                            ->addSelect("COUNT(*) AS total_pedidos")
                            ->from('pedido p')
                            ->innerJoin('p.usuario u')
                            ->addWhere('p.id_eshop IS NULL')
            			    ->addWhere('(? <= p.fecha_pago AND  p.fecha_pago <= ?)', array( $dataCampana["fecha_inicio"], $dataCampana["fecha_fin"] ) )
            			    ->addWhere('p.fecha_baja IS NULL')
                            ->addWhere('p.id_pedido IN (SELECT ppi.id_pedido FROM pedidoProductoItem ppi INNER JOIN ppi.pedidoProductoItemCampana ppic ON ppi.id_pedido_producto_item = ppic.id_pedido_producto_item WHERE ppic.id_campana = ?)', $idCampana )
                            ->fetchArray();
        
        $dataPedido = current($dataPedido);
        
        $topProductos = $this ->createQuery('ppic')
                            ->select('pr.denominacion, SUM(ppi.cantidad) AS cantidad')
                            ->from('producto pr')
                            ->innerJoin('pr.productoItem pi')
                            ->innerJoin('pi.pedidoProductoItem ppi')
                            ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                            ->innerJoin('ppi.pedido p')
                            ->groupBy('pr.denominacion')
                            ->addWhere('p.id_eshop IS NULL')
                            ->addWhere('ppic.id_campana = ?', $idCampana)
                            ->addWhere('(? <= p.fecha_pago AND  p.fecha_pago <= ?)', array( $dataCampana["fecha_inicio"], $dataCampana["fecha_fin"] ) )
                            ->addWhere('p.fecha_baja IS NULL')
                            ->orderBy('SUM(ppi.cantidad) DESC')
                            ->limit(5)
                            ->fetchArray();
                
        $unidadesVendidasXDia = $this->createQuery('c')
                                     ->select('DATE(p.fecha_pago)')
                                     ->addSelect('SUM(ppi.cantidad) AS unidades_vendidas')
                                     ->innerJoin('c.pedidoProductoItemCampana ppic')
                                     ->innerJoin('ppic.pedidoProductoItem ppi')
                                     ->innerJoin('ppi.pedido p')
                                     ->addWhere('p.id_eshop IS NULL')
                                     ->addWhere('(c.fecha_inicio <= p.fecha_pago AND  p.fecha_pago <= c.fecha_fin)')
                                     ->addWhere('p.fecha_baja IS NULL')
                                     ->addWhere('c.id_campana = ?', $idCampana)
                                     ->groupBy('c.id_campana, DATE(p.fecha_pago)')
                                     ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
                
        $ejecucionXDia = array();
        
        $fecha = date("Y-m-d", strtotime($dataCampana["fecha_inicio"])); 
        
        while($fecha <= $dataCampana["fecha_fin"])
        {
            $cantidad = 0;
            
            if ( isset( $unidadesVendidasXDia[$fecha] ) )
            {
                $cantidad = $unidadesVendidasXDia[$fecha];
            }            
            $ejecucionXDia[$fecha] = ($dataCampana['unidades_vendidas']) ? sprintf("%0.2f", ($cantidad/$dataCampana['unidades_vendidas']) * 100) : 0;
            $fecha = date("Y-m-d", strtotime($fecha . " +1 day"));
        }
        
                                        
        $campanaMarcas = campanaMarcaTable::getInstance()->listByIdCampana($idCampana);
        if ( count($campanaMarcas) > 1 )
        {
            $condicionFiscal = '';
            $rubro = '';
        }
        else
       {
           $condicionFiscal = $campanaMarcas[0]->getMarca()->getCondicionFiscal();
           $rubro = $campanaMarcas[0]->getMarca()->getMarcaRubro()->getDenominacion();
        }
        
        
        $calculados = array();
        $calculados['unidades_promedio_por_pedido'] = ( $dataPedido['total_pedidos'] ) ? sprintf('%0.2f', $dataCampana['unidades_vendidas'] / $dataPedido['total_pedidos'] ) : 0;
        $calculados['margen_bruto'] = $dataCampana['precio_deluxe'] - $dataCampana['costo'];
        $calculados['margen_promedio'] = ( $dataCampana['costo'] ) ? sprintf('%d', ( ($dataCampana['precio_deluxe'] / $dataCampana['costo'] ) - 1 ) * 100 ) : 0;
        $calculados['ejecucion_stock'] = ( $dataCampana['total_stock'] ) ? sprintf('%d', ($dataCampana['unidades_vendidas'] / $dataCampana['total_stock']) * 100 ) : 0;
        $calculados['ticket_promedio'] = ($dataPedido['total_pedidos']) ? sprintf('%0.2f', $dataPedido['total_facturado'] / $dataPedido['total_pedidos'] ) : '0,00';
        
        
        $calculados['objetivo_resultado'] = '';
        if ( $dataCampana['objetivo_facturacion'] )
        {
            $calculados['objetivo_resultado'] = ($dataCampana['objetivo_facturacion'] <= $dataPedido['total_facturado']) ? 'Cumplido' : 'No Cumplido';
            $dataCampana['objetivo_facturacion'] = '$' . $dataCampana['objetivo_facturacion'];
        }
        
        return array_merge( $dataCampana, $dataPedido, array('topProductos' => $topProductos, 'condicion_fiscal' => $condicionFiscal, 'rubro' => $rubro, 'ejecucionXDia' => $ejecucionXDia), $calculados );
    }
    
    /**
     * Reporte por comercial
     *
     * @param $idComercial
     *
     * @return array
     */
    public function getReporteByComercial($idComercial, $fechaDesde, $fechaHasta)
    {
        $dataCampana = $this->createQuery('c')
        ->addSelect('SUM(ppi.cantidad) AS unidades_vendidas')
        ->addSelect('SUM(ppi.cantidad * ppi.precio_deluxe) AS precio_deluxe')
        ->addSelect('SUM( ppi.cantidad * ppi.costo ) AS costo')
        ->addSelect('SUM(IF (condicion_fiscal = \'RIN\' , ppi.cantidad * ppi.costo, 0 ) ) AS costo_ri')
        ->addSelect('SUM(IF (condicion_fiscal = \'MON\' , ppi.cantidad * ppi.costo, 0 ) ) AS costo_monotributo')
        ->addSelect('COUNT(DISTINCT c.id_campana) AS cantidad_campanas')
        ->addSelect('SUM( ( (ppi.cantidad * ppi.precio_deluxe) - (ppi.cantidad * ppi.costo) ) * cm.comision_comercial ) AS comision')
        ->innerJoin('c.pedidoProductoItemCampana ppic')
        ->innerJoin('ppic.pedidoProductoItem ppi')
        ->innerJoin('ppi.productoItem pi')
        ->innerJoin('pi.producto pr')
        ->innerJoin('pr.marca m')
        ->innerJoin('ppi.pedido p')
        ->innerJoin('p.usuario u')
        ->innerJoin('c.campanaMarca cm')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('cm.id_comercial = ?', $idComercial)
        ->addWhere('ppic.id_marca = cm.id_marca')
        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
        ->fetchArray();
        
        $dataCampana = current($dataCampana);
                        
        $dataPedido = $this ->createQuery('p')
        ->addSelect('SUM(p.monto_envio) AS envio')
        ->from('pedido p')
        ->innerJoin('p.usuario u')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('p.id_pedido IN (SELECT ppi.id_pedido FROM pedidoProductoItem ppi INNER JOIN ppi.pedidoProductoItemCampana ppic ON ppi.id_pedido_producto_item = ppic.id_pedido_producto_item INNER JOIN ppic.campana m ON m.id_campana = ppic.id_campana INNER JOIN m.campanaMarca cm ON cm.id_campana = m.id_campana WHERE cm.id_comercial = ?)', $idComercial )
        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
        ->fetchArray();
        
        $dataPedido = current($dataPedido);
        
        $dataPedidoBis = $this ->createQuery('p')
        ->addSelect("COUNT(DISTINCT(id_pedido)) AS cant_pedidos")
        ->from('pedido p')
        ->innerJoin('p.pedidoProductoItem ppi')
        ->innerJoin('ppi.productoItem pi')
        ->innerJoin('pi.producto pr')
        ->innerJoin('p.usuario u')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('pr.id_marca IN (SELECT s1_cm.id_marca FROM pedidoProductoItem s1_ppi INNER JOIN s1_ppi.pedidoProductoItemCampana s1_ppic ON s1_ppi.id_pedido_producto_item = s1_ppic.id_pedido_producto_item INNER JOIN s1_ppic.campana s1_m ON s1_m.id_campana = s1_ppic.id_campana INNER JOIN s1_m.campanaMarca s1_cm ON s1_cm.id_campana = s1_m.id_campana WHERE s1_cm.id_comercial = ?)', $idComercial )
        ->addWhere('p.id_pedido IN (SELECT s2_ppi.id_pedido FROM pedidoProductoItem s2_ppi INNER JOIN s2_ppi.pedidoProductoItemCampana s2_ppic ON s2_ppi.id_pedido_producto_item = s2_ppic.id_pedido_producto_item INNER JOIN s2_ppic.campana s2_m ON s2_m.id_campana = s2_ppic.id_campana INNER JOIN s2_m.campanaMarca s2_cm ON s2_cm.id_campana = s2_m.id_campana WHERE s2_cm.id_comercial = ?)', $idComercial )
        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
        ->fetchArray();
        
        $dataPedidoBis = current($dataPedidoBis);
        $dataPedido['cant_pedidos'] = $dataPedidoBis['cant_pedidos'];
        
        $campanasApertura = $this->createQuery('c')
                                 ->addSelect('c.id_campana, m.nombre, cm.apertura_marca')
                                 ->innerJoin('c.campanaMarca cm')
                                 ->innerJoin('cm.marca m')
                                 ->addWhere('? <= DATE(c.fecha_inicio) AND DATE(c.fecha_inicio) <= ?', array($fechaDesde, $fechaHasta))
                                 ->addWhere('cm.id_comercial = ?', $idComercial)
                                 ->addWhere('cm.apertura_marca > 0')
                                 ->execute( array(), Doctrine::HYDRATE_SCALAR );
        
                
        $apertura = array();
        foreach($campanasApertura as $campana) $apertura[ $campana['m_nombre'] ] = $campana['cm_apertura_marca'];
        
        $desgloseCampana = $this->createQuery('c')
        ->select('c.id_campana, c.denominacion, c.fecha_inicio, c.fecha_fin')
        ->addSelect('SUM(ppi.cantidad * ppi.precio_deluxe) AS precio_deluxe')
        ->addSelect('SUM( ppi.cantidad * ppi.costo ) AS costo')
        ->addSelect('SUM( ( (ppi.cantidad * ppi.precio_deluxe) - (ppi.cantidad * ppi.costo) ) * cm.comision_comercial ) AS comision')
        ->innerJoin('c.pedidoProductoItemCampana ppic')
        ->innerJoin('ppic.pedidoProductoItem ppi')
        ->innerJoin('ppi.pedido p')
        ->innerJoin('p.usuario u')
        ->innerJoin('c.campanaMarca cm')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('cm.id_comercial = ?', $idComercial)
        ->addWhere('ppic.id_marca = cm.id_marca')
        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
        ->groupBy('c.id_campana, c.denominacion, c.fecha_inicio, c.fecha_fin')
        ->fetchArray( );
                
        $response = array();
        $response['cant_pedidos']       = $dataPedido['cant_pedidos'];
        $response['unidades_vendidas']  = $dataCampana['unidades_vendidas'];
        
        $response['envio']              = $dataPedido['envio'];
        
        $response['costo_ri']           = $dataCampana['costo_ri'];
        $response['costo_monotributo']  = $dataCampana['costo_monotributo'];
        $response['costo']              = $dataCampana['costo'];
        $response['cantidad_campanas']  = $dataCampana['cantidad_campanas'];
        $response['comision']           = $dataCampana['comision'];
        $response['precio_deluxe']      = $dataCampana['precio_deluxe'];
                
        $response['unidades_promedio']  = ( $dataPedido['cant_pedidos'] ) ? $dataCampana['unidades_vendidas'] / $dataPedido['cant_pedidos'] : 0;
        $response['ticket_promedio']    = ( $dataPedido['cant_pedidos'] ) ? $dataCampana['precio_deluxe'] / $dataPedido['cant_pedidos'] : 0;
        $response['margen_promedio']    = ( $dataCampana['costo'] ) ? sprintf('%d', ( ($dataCampana['precio_deluxe'] / $dataCampana['costo'] ) - 1 ) * 100 ) : 0;
        $response['margen_bruto']       = $dataCampana['precio_deluxe'] - $dataCampana['costo'];
        $response['apertura']           = $apertura;
        $response['desglose']           = $desgloseCampana;
        
        return $response;
    }
    
    /**
     * Reporte por comercial
     *
     *
     * @return Doctrine_Collection
     */
    public function getReporteComercialDesgloseTotal($fechaDesde, $fechaHasta)
    {
        return $this   ->createQuery('c')
                        ->select('c.id_campana, c.denominacion, c.fecha_inicio, c.fecha_fin')
                        ->addSelect('SUM(ppi.cantidad * ppi.precio_deluxe) AS precio_deluxe')
                        ->addSelect('SUM( ppi.cantidad * ppi.costo ) AS costo')
                        ->innerJoin('c.pedidoProductoItemCampana ppic')
                        ->innerJoin('ppic.pedidoProductoItem ppi')
                        ->innerJoin('ppi.pedido p')
                        ->innerJoin('p.usuario u')
                        ->innerJoin('c.campanaMarca cm')
                        ->addWhere('p.fecha_baja IS NULL')
                        ->addWhere('ppic.id_marca = cm.id_marca')
                        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
                        ->groupBy('c.id_campana, c.denominacion, c.fecha_inicio, c.fecha_fin')
                        ->execute( );
    }
    
    /**
     * Reporte por comercial
     *
     * @param $idComercial
     *
     * @return array
     */
    public function getReporteComercialTotales($fechaDesde, $fechaHasta)
    {
        $dataCampana = $this->createQuery('c')
        ->addSelect('COUNT(DISTINCT c.id_campana) AS cantidad_campanas')
        ->innerJoin('c.pedidoProductoItemCampana ppic')
        ->innerJoin('ppic.pedidoProductoItem ppi')
        ->innerJoin('ppi.productoItem pi')
        ->innerJoin('pi.producto pr')
        ->innerJoin('pr.marca m')
        ->innerJoin('ppi.pedido p')
        ->innerJoin('p.usuario u')
        ->innerJoin('c.campanaMarca cm')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('ppic.id_marca = cm.id_marca')
        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
        ->fetchArray();
    
        $dataCampana = current($dataCampana);
        
        $dataPedido = $this ->createQuery('p')
        ->addSelect("COUNT(DISTINCT(id_pedido)) AS cant_pedidos")
        ->from('pedido p')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
        ->fetchArray();
        
        $dataPedido = current($dataPedido);
        
        $envio = $this  ->createQuery('p')
                        ->addSelect('SUM(p.monto_envio) AS envio')
                        ->from('pedido p')
                        ->addWhere('p.fecha_baja IS NULL')
                        ->addWhere('p.id_pedido IN (SELECT ppi.id_pedido FROM pedidoProductoItem ppi INNER JOIN ppi.pedidoProductoItemCampana ppic ON ppi.id_pedido_producto_item = ppic.id_pedido_producto_item INNER JOIN ppic.campana m ON m.id_campana = ppic.id_campana INNER JOIN m.campanaMarca cm ON cm.id_campana = m.id_campana)' )
                        ->addWhere('? <= DATE(p.fecha_pago) AND DATE(p.fecha_pago) <= ?', array($fechaDesde, $fechaHasta))
                        ->fetchOne( array(), doctrine::HYDRATE_SINGLE_SCALAR );
    
        $response = array();
        $response['cant_pedidos']       = $dataPedido['cant_pedidos'];
        $response['cantidad_campanas']  = $dataCampana['cantidad_campanas'];
        $response['envio']  = $envio;
    
        return $response;
    }
    
    /**
     * Retorna un array de id de camapañas despachadas
     *
     * @return array
     */
    public function getIdsCampanasDespachadas()
    {
	    return $this->createQuery('c')
	                ->select('c.id_campana')
	                ->distinct()
                    ->innerJoin('c.pedidoProductoItemCampana ppic')
                    ->innerJoin('ppic.pedidoProductoItem ppi')
                    ->innerJoin('ppi.pedido p')
            	    ->addWhere('p.codigo_envio IS NOT NULL')
            	    ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }
    
	/**
	 * Retorna la campaña asociada a algun producto del carrito. Si es que la hay, de lo contrario retorna null.
	 * Al metodo le basta con revisar la campaña de un solo producto del carrito pues, existe una regla prexistente
	 * que no permite agregar al carrito productos de distintas campañas.
	 *
	 * @return campana
	 */
    public function getCampanaEnCarrito( $idSession )
    {        
        return $this->createQuery('c')
                    ->select('c.*')
                    ->distinct()
                    ->leftJoin('c.productoCampana pc')
                    ->innerJoin('pc.producto p')
                    ->innerJoin('p.productoItem pi')
                    ->innerJoin('pi.carritoProductoItem cpi')
                    ->addWhere('cpi.id_session= ?', array( $idSession ) )
                    ->fetchOne();       
        
    }

    /**
     * Update del orden de una campaña
     *
     * @param $idCampana
     * @param $orden
     *
     */
    public function updateOrden($idCampana, $orden)
    {
      $this->createQuery('c')
           ->update()
           ->set('c.orden', $orden)
           ->addwhere('c.id_campana = ?', $idCampana)
           ->execute();
    }

    /**
     * Devuelve true si la campaña tiene ventas con stock de refuerzo en una marca determinada
     *
     * @return Doctrine_Collection
     */
    public function vendioStockRefuerzo($idCampana, $idMarca = null)
    {
        $q = $this->createQuery('c')
                  ->innerJoin('c.campanaMarca cm')
                  ->innerJoin('c.pedidoProductoItemCampana ppic')
                  ->innerJoin('ppic.pedidoProductoItem ppi')
                  ->innerJoin('ppi.pedido p')
                  ->innerJoin('ppi.stock s')
                  ->addWhere('p.id_eshop IS NULL')
                  ->addWhere('ppic.id_campana = ?', $idCampana )
                  ->addWhere('p.fecha_pago IS NOT NULL')
                  ->addWhere('(p.fecha_baja IS NULL OR date(p.fecha_baja) > date(c.fecha_fin))')
                  ->addWhere('s.origen = ?', Producto::ORIGEN_REFUERZO);

        if ( $idMarca ) {
            $q->addWhere('ppic.id_marca = ?', $idMarca );
        }

        return (bool) $q->count();
    }
	
}