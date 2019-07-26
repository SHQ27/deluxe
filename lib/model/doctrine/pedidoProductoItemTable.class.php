<?php


class pedidoProductoItemTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de pedidoProductoItemTable;
	* 
	* @return pedidoProductoItemTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('pedidoProductoItem');
    }
    
	/**
	* Retorna true si para un mismo $idPedido existen productos de distintas campañas / stock permanente
	*  
	* @return boolean
	*/
    public function hayMezcla($idPedido)
    {
    	$cantidad = $this->createQuery('ppi')
    					->select('ppi.id_pedido, ppic.id_campana')
    					->leftJoin('ppi.pedidoProductoItemCampana ppic')
    					->addWhere('ppi.id_pedido = ? ', $idPedido)
    					->groupBy('ppi.id_pedido, ppic.id_campana')
						->count();
						
		return $cantidad != 1;  
    }  
    
	/**
	* Retorna true si el pedido tiene algun producto perteneciente a una campaña. 
	*  
	* @return boolean
	*/
    public function tieneOfertas($idPedido)
    {
    	return (bool) $this->createQuery('ppi')
    					->innerJoin('ppi.pedidoProductoItemCampana ppic')
    					->addWhere('ppi.id_pedido = ? ', $idPedido)
						->count();  
    }
    
    /**
     * Retorna true si el pedido tiene algun producto perteneciente a outlet
     *
     * @return boolean
     */
    public function tieneOutlet($idPedido)
    {
    	return (bool) $this->createQuery('ppi')
    	->addWhere('ppi.id_pedido = ? ', $idPedido)
    	->addWhere('ppi.origen = ?', producto::ORIGEN_OUTLET)
    	->count();
    }
    
	/**
	* Retorna true si el pedido tiene solo productos pertenecientes a campañas 
	*  
	* @return boolean
	*/
    public function tieneSoloOfertas($idPedido)
    {
    	$response =  $this->createQuery('ppi')
    					->leftJoin('ppi.pedidoProductoItemCampana ppic')
    					->addWhere('ppic.id_pedido_producto_item_campana IS NULL')
    					->addWhere('ppi.id_pedido = ?', array( $idPedido ) )
						->count();
						
		return !$response;
    }  
    
	/**
	* Retorna el peso total de todos los productos de un pedido
	* 
	* @param integer $idPedido
	* 
	* @return float
	*/
	public function getPesoByIdPedido( $idPedido )
	{
		return (float)$this->createQuery('ppi')
					->select( 'sum(ppi.cantidad * p.peso)' )
					->innerJoin('ppi.productoItem pi ')
					->innerJoin('pi.producto p')
    			    ->addWhere('ppi.id_pedido = ?', array( $idPedido ) )
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	* Retorna un pedidoProductoItem a partir de su clave secundaria
	* 
	* @param integer $idPedido
	* @param integer $idProductoItem
	* 
	* @return pedidoProductoItem
	*/
	public function getByCompoundKey( $idPedido, $idProductoItem )
	{
		return $this->createQuery('ppi')
    			    ->addWhere('ppi.id_pedido = ?', array( $idPedido ) )
    			    ->addWhere('ppi.id_producto_item = ?', array( $idProductoItem ) )
    			    ->fetchOne();
	}
	
	
	/**
	* Retorna true si el $idProductoItem esta asociado a algun pedido
	* 
	* @param integer $idProductoItem
	* 
	* @return bool
	*/
	public function exist( $idProductoItem )
	{
		return (bool) $this->createQuery('ppi')
    			    ->addWhere('ppi.id_producto_item = ?', array( $idProductoItem ) )
    			    ->count();
	}
	
	/**
	* Retorna todos los pedidoProductoItem para obtener la orden de compra de una marca en stock permanente
	* 
	* @param date $fechaDesde
	* @param date $fechaHasta
	* @param integer $idMarca
	* @param mixed $origenStock
	* 
	* @return pedidoProductoItem
	*/
	public function ordenDeCompraByIdMarca( $idEshop, $fechaDesde, $fechaHasta, $idMarca, $origenStock = false, $exist = false)
	{
		$q = $this->createQuery('ppi')
            	  ->select('ppi.*, pe.*, pe.*, pi.*, pr.*, pt.*, pc.*, m.*, pim.*, s.*')
            	  ->innerJoin('ppi.pedido pe ')
            	  ->innerJoin('ppi.productoItem pi ')
            	  ->innerJoin('pi.producto pr')
            	  ->leftJoin('pr.productoImagen pim')
            	  ->innerJoin('ppi.productoTalle pt')
            	  ->innerJoin('ppi.productoColor pc')
				  ->leftJoin('ppi.pedidoProductoItemCampana ppic')
				  ->innerJoin('pr.marca m')
				  ->innerJoin('ppi.stock s')
				  ->addWhere('(? <= pe.fecha_pago AND  pe.fecha_pago <= ?)', array($fechaDesde, $fechaHasta))
				  ->addWhere('pe.fecha_baja IS NULL')
				  ->addWhere('pr.id_marca = ?', array( $idMarca ) )
				  ->addWhere('ppic.id_campana IS NULL')
				  ->orderby('pr.denominacion ASC');
		
	    if ($origenStock) {
	        $q->addWhere('s.origen = ?', $origenStock);
	    }
	    
	    if ( $idEshop ) {
	        $q->addwhere('pe.id_eshop = ?', $idEshop );
	    } else {
	        $q->addwhere('pe.id_eshop IS NULL');
	    }

		if ( $exist ) {
		    return (bool) $q->count();
		} else {
		    return $q->execute();
		}		
	}
	
	/**
	* Retorna todos los pedidoProductoItem para obtener la orden de compra de una campaña
	* 
	* @param date $fechaDesde
	* @param date $fechaHasta
	* @param integer $idCampana
	* @param integer $idMarca
	* @param mixed $origenStock
	* @param bool $exist
	* 
	* @return pedidoProductoItem
	*/
	public function ordenDeCompraByIdCampana( $fechaDesde, $fechaHasta, $idCampana, $idMarca = null, $origenStock = false, $exist = false)
	{
		$q = $this->createQuery('ppi')
		            ->select('ppi.*, pe.*, ppic.*, pe.*, pi.*, pr.*, pt.*, pc.*, m.*, pim.*, s.*')
		            ->distinct()
					->innerJoin('ppi.pedido pe ')
					->innerJoin('ppi.pedidoProductoItemCampana ppic')
					->innerJoin('ppic.campana c')
					->innerJoin('ppi.productoItem pi ')
					->innerJoin('pi.producto pr')
					->leftJoin('pr.productoImagen pim')
					->innerJoin('ppi.productoTalle pt')
					->innerJoin('ppi.productoColor pc')
					->innerJoin('pr.marca m')
					->innerJoin('ppi.stock s')
					->addWhere('pe.id_eshop IS NULL')
    			    ->addWhere('pe.fecha_pago IS NOT NULL')
    			    ->addWhere('ppic.id_campana = ?', array( $idCampana ))
		            ->addWhere('(pe.fecha_baja IS NULL OR date(pe.fecha_baja) > date(c.fecha_fin))');
		
		if ($fechaDesde && $fechaHasta)
		{
		    $q->addWhere('(? <= pe.fecha_pago AND  pe.fecha_pago <= ?)', array($fechaDesde, $fechaHasta));
		}
    			    
		if ($idMarca)
		{
			$q->addWhere('pr.id_marca = ?', array( $idMarca ) );
		}
				

	    if ($origenStock)
	    {
	        $q->addWhere('s.origen = ?', $origenStock);
	    }
		
		$q->orderby('pr.denominacion ASC');
		
		if ( $exist ) {
		    return (bool) $q->count();
		} else {
		    return $q->execute();
		}
	}
	
	
	/**
	 * Retorna un array de dos posiciones con la informacion de cantidad de unidades y pedidos vendidos para una marca en una campaña.
	 *
	 * @param integer $idCampana
	 * @param integer $idMarca
	 *
	 * @return pedidoProductoItem
	 */
	public function getCantidades( $idCampana, $idMarca = null)
	{
	    $q = $this->createQuery('ppi')
	              ->addSelect('COUNT( DISTINCT(pe.id_pedido) ) as cantidad_pedidos')
	              ->addSelect('SUM( ppi.cantidad ) as unidades')
	              ->addSelect('SUM( ppi.costo * ppi.cantidad ) as costo_total')
           	      ->innerJoin('ppi.pedido pe ')
           	      ->innerJoin('ppi.pedidoProductoItemCampana ppic')
           	      ->innerJoin('ppi.productoItem pi ')
           	      ->innerJoin('pi.producto pr')
           	      ->innerJoin('ppic.campana campana')
          	      ->addWhere('(pe.fecha_baja IS NULL OR date(pe.fecha_baja) > date(campana.fecha_fin)) ')
                  ->addWhere('pe.fecha_pago IS NOT NULL')
            	  ->addWhere('ppic.id_campana = ?', $idCampana );
	    
	    if ( $idMarca )
	    {
	        $q->addWhere('pr.id_marca = ?', $idMarca );
	    }
	    
	    $result = $q->fetchOne(null, Doctrine::HYDRATE_SCALAR );
	    
	    return array(
	            'cantidad_pedidos' => $result['pe_cantidad_pedidos'],
	            'unidades' => $result['ppi_unidades'],
	            'costo_total' => $result['ppi_costo_total']
            ); 
	}
	
	/**
	* Retorna la cantidad de un productoItem en pedidos vigentes y no pagados
	* 
	* @param integer $idProductoItem
	* 
	* @return integer
	*/
	public function getCantidadNoPagadosByIdProductoItem( $idProductoItem )
	{
		return (int) $this->createQuery('ppi')
					->select( 'sum(ppi.cantidad)' )
					->innerJoin('ppi.pedido p')
    			    ->addWhere('ppi.id_producto_item= ?', array( $idProductoItem ) )
    			    ->addWhere('p.fecha_baja IS NULL')
					->addWhere('p.fecha_pago IS NULL')    			    
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	* Retorna la cantidad de un productoItem en pedidos vigentes y pagados
	* 
	* @param integer $idProductoItem
	* 
	* @return integer
	*/
	public function getCantidadPagadosByIdProductoItem( $idProductoItem )
	{
		return (int) $this->createQuery('ppi')
					->select( 'sum(ppi.cantidad)' )
					->innerJoin('ppi.pedido p')
    			    ->addWhere('ppi.id_producto_item= ?', array( $idProductoItem ) )
    			    ->addWhere('p.fecha_baja IS NULL')
					->addWhere('p.fecha_pago IS NOT NULL')
					->addWhere('p.fecha_envio IS NULL')		    
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	* Retorna la cantidad de un productoItem en pedidos vigentes y enviados
	* 
	* @param integer $idProductoItem
	* 
	* @return integer
	*/
	public function getCantidadEntregadosByIdProductoItem( $idProductoItem )
	{
		return (int) $this->createQuery('ppi')
					->select( 'sum(ppi.cantidad)' )
					->innerJoin('ppi.pedido p')
    			    ->addWhere('ppi.id_producto_item = ?', array( $idProductoItem ) )
    			    ->addWhere('p.fecha_baja IS NULL')
					->addWhere('p.fecha_envio IS NOT NULL')    			    
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	 * Retorna la cantidad de un productoItem en un pedido
	 *
	 * @param integer $idProductoItem
	 * @param integer $idPedido
	 *
	 * @return integer
	 */
	public function getCantidadDeProductoItemEnPedido( $idPedido, $idProductoItem )
	{
		return (int) $this->createQuery('ppi')
		->select( 'sum(ppi.cantidad)' )
		->addWhere('ppi.id_producto_item = ?', array( $idProductoItem ) )
		->addWhere('ppi.id_pedido = ?', array( $idPedido ) )
		->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	 * Retorna el listado de los pedidoProductoItem que son pausibles de devolucion
	 *
	 * @param integer $idUsuario
	 *
	 * @return pedido
	 */
	public function listParaDevolucion($idUsuario, $limiteDevolucion)
	{	    
		return $this->createQuery('ppi')
		->addSelect('ppi.*, pi.*, pt.*, pc.*, pr.*, p.*')
		->innerJoin('ppi.pedido p')
		->innerJoin('ppi.productoItem pi')
		->innerJoin('pi.productoTalle pt')
		->innerJoin('pi.productoColor pc')
		->innerJoin('pi.producto pr')
		->leftJoin('ppi.devolucionProductoItem dpi')
		->leftJoin('p.faltante f ON (f.id_pedido = p.id_pedido AND f.id_producto_item = pi.id_producto_item)')
		->addWhere('p.id_usuario = ?', $idUsuario)
		->addWhere('p.fecha_baja IS NULL')
		->addWhere('p.fecha_pago IS NOT NULL')
		->addWhere('dpi.id_pedido_producto_item IS NULL')
		->addWhere('f.id_faltante IS NULL')
		->addWhere('DATE_SUB(CURDATE(),INTERVAL ? DAY) < p.fecha_envio', $limiteDevolucion)
		->execute();
	}
	
	/**
	 * Retorna la cantidad de productoItems en un pedido
	 *
	 * @param integer $idPedido
	 *
	 * @return integer
	 */
	public function countByIdPedido( $idPedido )
	{
	    return (int) $this->createQuery('ppi')
	    ->select( 'sum(ppi.cantidad)' )
	    ->addWhere('ppi.id_pedido = ?', array( $idPedido ) )
	    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	 * Retorna true si existe alguna pedido asociado al producto
	 *
	 * @param number $idProducto
	 *
	 * @return boolean
	 */
	public function existProducto($idProducto)
	{
	    $query = $this->createQuery('ppi')
	    ->innerJoin('ppi.productoItem pi')
	    ->addwhere('pi.id_producto = ?', $idProducto);
	
	    return (bool) $query->count();
	}

    /*
     * Retorna la lista de pedidos de una campaña que ya fueron enviados
    *
    * @param integer $idCampana
    *
    * @return Doctrine_Collection
    */
    public function conteoProductosEnviadosByIdCampana($idCampana)
    {
    
        return $this->createQuery('ppi')
        ->select('ppi.id_producto_item, sum(ppi.cantidad)')        
        ->innerJoin('ppi.pedido p')
        ->innerJoin('ppi.pedidoProductoItemCampana ppic')
        ->addWhere('p.fecha_envio IS NOT NULL AND p.fecha_envio > ?', '2015-05-22 13:00:00')
        ->addWhere('p.codigo_envio IS NOT NULL')
        ->addWhere('p.fecha_pago IS NOT NULL')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('p.tipo_producto = ?', pedido::PRODUCTO_TIPO_OFERTA)
        ->addWhere('ppic.id_campana = ?', $idCampana)
        ->groupBy('ppi.id_producto_item')
        ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
    }
	
}