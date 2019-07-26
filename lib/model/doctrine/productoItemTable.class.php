<?php


class productoItemTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoItemTable;
	* 
	* @return productoItemTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoItem');
    }
    
	/**
	* Retorna todos los productoItem de un producto
	* 
	* @param integer $idProducto
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProducto( $idProducto, $orderBy = false )
	{
		$q = $this->createQuery('pi')
			      ->addWhere('pi.id_producto= ?', array( $idProducto ) );
				
		if ( $orderBy == 'COLOR-TALLE' ) {
		    $q->innerJoin('pi.productoTalle pt');
		    $q->innerJoin('pi.productoColor pc');
		    $q->orderBy( 'pc.denominacion ASC, pt.denominacion ASC' );
		}
		
		return $q->execute();		
	}
	
	/**
	* Retorna todos los productoItem de un producto ordenado por talle y color
	* 
	* @param integer $idProducto
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProductoOrdenado( $idProducto )
	{
		return $this->createQuery('pi')
					->innerJoin('pi.productoTalle pt')
					->innerJoin('pi.productoColor pc')
					->innerJoin('pc.familiaColor fc')
    			    ->addWhere('pi.id_producto = ?', array( $idProducto ) )
    			    ->orderBy('pt.orden ASC, pc.denominacion ASC')    			    
    			    ->execute();
	}	
    
	/**
	* Retorna el productoItem que coincide con la clave compuesta
	* 
	* @param integer $idProducto
	* @param integer $idTalle
	* @param integer $idColor
	* 
	* @return productoItem
	*/
	public function getByCompoundKey( $idProducto, $idTalle, $idColor )
	{
		return $this->createQuery('pi')
    			    ->addWhere('pi.id_producto= ?', array( $idProducto ) )
    			    ->addWhere('pi.id_producto_talle= ?', array( $idTalle ) )
    			    ->addWhere('pi.id_producto_color= ?', array( $idColor ) )
    			    ->fetchOne();
	}
	
	/**
	 * Retorna el productoItem que coincide con los parametros dados
	 *
	 * @param integer $idProducto
	 * @param string $dataMercadoLibre
	 *
	 * @return productoItem
	 */
	public function getByDataMercadoLibre( $idProducto, $dataMercadoLibre )
	{
		return $this->createQuery('pi')
					->addWhere('pi.id_producto = ?', array( $idProducto ) )
					->addWhere('pi.data_mercado_libre = ?', array( $dataMercadoLibre ) )
					->fetchOne();
	}
    
    /**
     * Retorna si hay productos del color ingresado por parametro
     *
     * @param $idColor
     *
     * @return boolean
     */
    public function hayProductosDeColor($idColor)
    {
    	return $this->createQuery('pi')
    	->select('pi.*')
    	->addwhere('pi.id_producto_color = ?',$idColor)
    	->fetchOne();
    }
    
    /**
     * Retorna si hay productos del talle ingresado por parametro
     *
     * @param $idTalle
     *
     * @return boolean
     */
    public function hayProductosDeTalle($idTalle)
    {
    	return $this->createQuery('pi')
    	->select('pi.*')
    	->addwhere('pi.id_producto_talle = ?',$idTalle)
    	->fetchOne();
    }
    
    /**
     * Retorna si hay productos del talle ingresado por parametro
     *
     * @param $idTalle
     *
     */
    public function deleteByIdProducto($idProducto)
    {
		$this->createQuery('pi')
    			    ->delete()
				    ->addwhere('pi.id_producto = ?', $idProducto)  
    			    ->execute();
    }
    
    /**
     * Suma $cantidad unidades al stock del $idProductoItem 
     *
     * @param $idProductoItem
     * @param $cantidad
     *
     */
    public function sumarAStockById($idProductoItem, $cantidad)
    {
		$this->createQuery('pi')
    			    ->update()
    			    ->set('stock', 'stock + ?', $cantidad)
				    ->addwhere('pi.id_producto_item = ?', $idProductoItem)  
    			    ->execute();
    }
    
    /**
     * Resta $cantidad unidades al stock del $idProductoItem 
     *
     * @param $idProductoItem
     * @param $cantidad
     *
     */
    public function restaAStockById($idProductoItem, $cantidad)
    {
		$this->createQuery('pi')
    			    ->update()
    			    ->set('stock', 'stock - ?', $cantidad)
				    ->addwhere('pi.id_producto_item = ?', $idProductoItem)  
    			    ->execute();
    }   
    
    /**
     * Vacia el stock de todos los productoItems de un producto 
     *
     * @param $idProductoItem
     * @param $cantidad
     *
     */
    public function vaciarStock($idProducto)
    {
		$this->createQuery('pi')
    			    ->update()
    			    ->set('stock', 0)
				    ->addwhere('pi.id_producto = ?', $idProducto)  
    			    ->execute();
    }
    
	/**
	* Retorna todos los productoItem que coincidan en id con los enviados por parametro
	* 
	* @param array $idsProductoItem
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdsProductoItem( $idsProductoItem )
	{
		return $this->createQuery('pi')
    			    ->whereIn('pi.id_producto_item', $idsProductoItem )
    			    ->execute();
	}
	
	
	/**
	* Retorna todos los productoItem que pueden haber tenido algun problema de stock duplicado durante el dia
	* 
	* @return Doctrine_Collection
	*/
	public function listAlertaStockDuplicado()
	{
	    return $this->createQuery('pi')
			->innerJoin('pi.stock s')
			->addWhere('s.fecha >= curdate()')
			->addWhere('s.observacion LIKE \'Baja del Pedido %\'')
			->addWhere('s.observacion NOT LIKE \'%,%\'')
			->groupBy('s.observacion, s.id_producto_item')
			->having('count(s.id_producto_item) >= 2')
			->execute();
	}
		
	/**
	 * Retorna el listado de productoItems vendidos en una campaña x producto
	 *
	 * @param int $idEshop
	 * @param int $idCampana
	 * @param int $idProducto
	 *
	 * @return int
	 */
	public function listVendidosEnCampanaXProducto($idEshop, $idCampana, $idProducto)
	{
	    $q = $this->createQuery('pi')
        	 	  ->select('*')
        		  ->innerJoin('pi.pedidoProductoItem ppi')
        		  ->innerJoin('ppi.pedidoProductoItemCampana ppic')
        		  ->innerJoin('ppi.pedido pe')
        		  ->innerJoin('pi.productoTalle pt')
        		  ->innerJoin('pi.productoColor pc')
        		  ->addWhere('ppic.id_campana = ?', $idCampana)
        		  ->addWhere('pi.id_producto = ?', $idProducto);
	     
	    if ( $idEshop ) {
	        $q->addwhere('pe.id_eshop = ?', $idEshop );
	    } else {
	        $q->addwhere('pe.id_eshop IS NULL');
	    }
	     
	    return $q->orderBy('pt.denominacion ASC, pc.denominacion ASC')
		         ->execute();		
	}
	
	/**
	 * Retorna el listado de productoItems vendidos como stock permanente x producto
	 *
	 * @param int $idEshop
	 * @param bool $esOutlet
	 * @param int $idProducto
	 *
	 * @return int
	 */
	public function listVendidosStockPermanente($idEshop, $esOutlet, $idProducto)
	{
	    $origen = ( $esOutlet ) ? producto::ORIGEN_OUTLET : producto::ORIGEN_STOCK_PERMANENTE;
	    
	    $q = $this->createQuery('pi')
        	      ->select('*')
        	      ->innerJoin('pi.pedidoProductoItem ppi')
        	      ->leftJoin('ppi.pedidoProductoItemCampana ppic')
        	      ->innerJoin('ppi.pedido pe')
        	      ->innerJoin('pi.productoTalle pt')
        	      ->innerJoin('pi.productoColor pc')
        	      ->addWhere('ppic.id_campana IS NULL')
        	      ->addWhere('pi.id_producto = ?', $idProducto)
        	      ->addWhere('ppi.origen = ?', $origen);
	    
	    if ( $idEshop ) {
	        $q->addwhere('pe.id_eshop = ?', $idEshop );
	    } else {
	        $q->addwhere('pe.id_eshop IS NULL');
	    }
	    
	    return $q->orderBy('pt.denominacion ASC, pc.denominacion ASC')
	             ->execute();
	}
	
	/**
	 * Retorna productoItem que coincidan en su id con los datos pasados en el array de $ids.
	 *
	 * @param array $ids
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIds($ids)
	{
		return $this->createQuery('pi')
		->innerJoin('pi.producto p')
		->innerJoin('pi.productoTalle pt')
		->innerJoin('pi.productoColor pc')
		->addWhere('pi.id_producto_item IN ?', array( $ids ) )
		->execute();
	}
	
	/**
	 * Retorna el listado de productoItems a los que se le puede restaurar el stock desde una campaña finalizada
	 *
	 * @param int $idCampana
	 *
	 * @return Doctrine_Collection
	 */
	public function listRestaurablesDesdeCampanaFinalizada($idCampana, $idMarca, $idProductoCategoria)
	{	    
	    $query =  $this ->createQuery('pi')
            	        ->select('*')
                	    ->innerJoin('pi.producto p')
                	    ->innerJoin('pi.productoTalle pt')
                	    ->innerJoin('pi.productoColor pc')
                	    ->innerJoin('p.productoCampanaFinalizada pcf')
                	    ->addWhere('pcf.id_campana = ?', $idCampana)
	                    ->addWhere('pcf.fue_restaurada = false');
                	    
	    if ( $idMarca )
	    {
	        $query->addWhere('p.id_marca = ?',  $idMarca);
	    }
	    
	    if ( $idProductoCategoria )
	    {
	        $query->addWhere('p.id_producto_categoria = ?',  $idProductoCategoria);
	    }
	    
	    
	    
        return $query->execute();
	}
	
	
	/**
	 * Retorna el listado de productoItems que pertenecen a una marca determinada
	 *
	 * @param int $idMarca
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIdMarca($idMarca)
	{
	    return $this->createQuery('pi')
	    ->select('*')
	    ->innerJoin('pi.producto p')
	    ->innerJoin('pi.productoTalle pt')
	    ->innerJoin('pi.productoColor pc')
	    ->addWhere('p.id_marca= ?', $idMarca)
	    ->execute();
	}
	
	/**
	 * Devuelve para un conjunto de filtros, todos los productoItem que existan en una devolucion como fallados. 
	 * Esto se utiliza en el listado de productos fallados dentro de la seccion Devoluciones del Backend
	 *
	 * @param array $filters
	 *
	 * @return Doctrine_Collection
	 */
	public function listFallados($filters)
	{
	    $q = $this->createQuery('pi')
        	      ->select('p.denominacion, pi.id_producto_item, pt.denominacion, pc.denominacion, m.nombre')
        	      ->addSelect('SUM(dpi.cantidad) as cantidad_fallada')
        	      ->innerJoin('pi.productoTalle pt')
        	      ->innerJoin('pi.productoColor pc')
        	      ->innerJoin('pi.producto p')
        	      ->innerJoin('p.marca m')
        	      ->innerJoin('pi.devolucionProductoItem dpi')
        	      ->innerJoin('dpi.devolucion d')
        	      ->addWhere('dpi.esta_fallado = ?', true)
	              ->groupBy('p.denominacion, pi.id_producto_item, pt.denominacion, pc.denominacion, m.nombre');
	
	    if ( isset($filters['fecha_devolucion']['from']) && $filters['fecha_devolucion']['from'] )
	    {
	        $q->addWhere('d.fecha >= ?', $filters['fecha_devolucion']['from'] );
	    }
	
	    if ( isset($filters['fecha_devolucion']['to']) && $filters['fecha_devolucion']['to'] )
	    {
	        $q->addWhere('d.fecha <= ?', $filters['fecha_devolucion']['to'] );
	    }
	
	    if ( isset($filters['id_marca']) && $filters['id_marca'] )
	    {
	        $q->addWhere('p.id_marca = ?', $filters['id_marca'] );
	    }
	
	    return $q->execute();
	}
	
	
	/**
	 * Devuelve un array de idProductoItems para aquellos que tuvieron faltante en la campaña
	 *
	 * @param integer $idCampana
	 *
	 * @return Doctrine_Collection
	 */
	public function getFaltantesByIdCampana($idCampana)
	{
	    $arr = $this->createQuery('pi')
                	     ->select('DISTINCT pi.id_producto_item')
                	     ->innerJoin('pi.faltante f')
                	     ->innerJoin('pi.pedidoProductoItem ppi ON (pi.id_producto_item = ppi.id_producto_item and ppi.id_pedido = f.id_pedido)')
                	     ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                	     ->addWhere('ppic.id_campana = ?', $idCampana)
                	     ->execute( array(), doctrine::HYDRATE_ARRAY );
	    
	    $response = array();
	    foreach( $arr as $value ) {
	        $response[] = $value['id_producto_item'];
	    }
	    
	    return $response;
	}

    /**
     * Retorna un array con informacion de la cantidad de faltantes
     * para cada idProductoItem vendido en una campaña y marca
     *
     * @return Doctrine_Collection
     */
    public function getCantidadFaltantesByIdCampana( $idCampana, $idMarca )
    {
        $q = $this->createQuery('pi')
                  ->select('pi.id_producto_item, f.id_faltante, f.cantidad')
                  ->distinct()
                  ->innerJoin('pi.pedidoProductoItem ppi')
                  ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                  ->innerJoin('pi.faltante f on f.id_pedido = ppi.id_pedido and f.id_producto_item = pi.id_producto_item')
                  ->innerJoin('pi.producto p')
                  ->addWhere('ppic.id_campana = ?', array( $idCampana ));
            
        if ($idMarca) {
            $q->addWhere('p.id_marca = ?', array( $idMarca ) );
        }

        $data = $q->execute( array(), Doctrine::HYDRATE_SCALAR );

        $response = array();
        foreach ($data as $row) {
        	$idProductoItem = $row["pi_id_producto_item"];
        	if ( !isset( $response[ $idProductoItem ] ) ) {
        		$response[ $idProductoItem ] = 0;
        	}

        	$response[ $idProductoItem ] += $row["f_cantidad"];
        }
            
        return $response;
    }

    /**
     * Retorna un array con informacion de la cantidad de faltantes
     * para cada idProductoItem vendido dado un set de ids de pedidos
     *
     * @return Doctrine_Collection
     */
    public function getCantidadFaltantesByIdsPedido( $idsPedido )
    {
        $q = $this->createQuery('pi')
                  ->select('pi.id_producto_item, f.id_faltante, f.cantidad')
                  ->distinct()
                  ->innerJoin('pi.pedidoProductoItem ppi')
                  ->innerJoin('pi.faltante f on f.id_pedido = ppi.id_pedido and f.id_producto_item = pi.id_producto_item')
                  ->innerJoin('pi.producto p')
                  ->andWhereIn('ppi.id_pedido', $idsPedido);
            

        $data = $q->execute( array(), Doctrine::HYDRATE_SCALAR );


        $response = array();
        foreach ($data as $row) {
        	$idProductoItem = $row["pi_id_producto_item"];
        	if ( !isset( $response[ $idProductoItem ] ) ) {
        		$response[ $idProductoItem ] = 0;
        	}

        	$response[ $idProductoItem ] += $row["f_cantidad"];
        }
            
        return $response;
    }



		
}