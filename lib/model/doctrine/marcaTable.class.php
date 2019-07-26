<?php


class marcaTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de marcaTable;
	* 
	* @return marcaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('marca');
    }
    
	/**
	* Retorna la marca a partir de su slug
	* 
	* @return marca
	*/
	public function getBySlug($slug)
	{
		return $this->createQuery('m')
					->addWhere('m.slug = ?', $slug)
					->fetchOne();
	}
    				
	/** 
	* Extrae los ids de una colleccion de marcas
	* 
	* @return array
	*/
	public function extractIdMarcas( $marcas )
	{
		$ids = array();
		foreach ($marcas as $marca) $ids[] = $marca->getIdMarca();
		return $ids;
	}
	
	/**
	* Retorna todas las marcas
	* 
	* @return Doctrine_Collection
	*/
	public function listAll()
	{
		return $this->createQuery('m')
    			    ->orderBy('m.nombre ASC')
    			    ->execute();
	}

	/**
	* Trae las marcas de los productos buscados
	* @param string $term
	* 
	* @return marca
	*/
    public function listarMarcasDeBusqueda($term, $idProductoGenero, $idProductoCategoria)
    {    			    
		$q = $this->createQuery('m')
    			    ->select('m.*')
    			    ->distinct()
    			    ->innerJoin('m.producto p')
    			    ->leftJoin('p.productoCategoria pc')
    			    ->leftJoin('pc.productoGenero pg')
    			    ->leftJoin('p.productoTag pt')
    			    ->leftJoin('pt.tag t')
					->leftJoin('p.productoCampana pca')
					->leftJoin('pca.campana c')
					->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
        	        ->addWhere('p.activo = 1');
        	        
    	if ($idProductoGenero)
    	{  
			$q->addWhere('pg.id_producto_genero = ?', $idProductoGenero);
    	}
    	
        if ($idProductoCategoria)
    	{  
			$q->addWhere('pc.id_producto_categoria = ?', $idProductoCategoria);
    	}
    	
        $q->addWhere('p.denominacion like ? or p.descripcion like ? or m.nombre like ? or t.denominacion like ?',
        array("%$term%","%$term%","%$term%","%$term%"));
        
        $q->orderBy('m.nombre ASC');
    	
    	return $q->execute();
    }
    
    /**
     * Trae marcas según el id
     * @param string $term
     *
     * @return marca
     */
    public function getById($idMarcas)
    {
        return $this->createQuery('m')
        ->select('m.*')
        ->addWhere('m.id_marca IN ?', array( $idMarcas ) )
        ->execute();
    }
    
    
    /**
     * Retorna todas las marcas ordenadas por nombre
     *
     * @return Doctrine_Collection
     */
    public function listAllOrdered()
    {
        return $this->createQuery('m')
        ->select('m.*')
        ->addOrderBy('m.nombre')
        ->execute();
    }
    
	/**
	* Trae una marca por su id
	* 
	* @param integer $idMarca
	* 
	* @return marca
	*/
    public function getOneById($idMarca)
    {
		return $this   ->createQuery('m')
                        ->addWhere('m.id_marca = ?', $idMarca )
                        ->useResultCache(true, null, cacheHelper::getInstance()->genKey("marca_getOneById_" . $idMarca) )
                        ->fetchOne();
    }
    
    /**
     * Trae una marca por su nombre
     *
     * @param string $nombre
     *
     * @return marca
     */
    public function getByNombre($nombre)
    {
        return $this->createQuery('m')
                    ->addWhere('m.nombre = ?', $nombre )
                    ->fetchOne();
    }
    
	/**
	* Retorna todas las marcas a las que se le puede obtener una orden de compra por productos de stock permanente entre un rango de fechas
	* 
	* @param date $fechaDesde
	* @param date $fechaHasta
	* 
	* @return Doctrine_Collection
	*/
	public function listMarcasForOrdenDeCompra( $fechaDesde, $fechaHasta )
	{
		return $this->createQuery('m')
					->select('m.*')
					->distinct()
					->innerJoin('m.producto pr')
					->innerJoin('pr.productoItem pi')
					->innerJoin('pi.pedidoProductoItem ppi')
					->innerJoin('ppi.pedido pe')
					->leftJoin('ppi.pedidoProductoItemCampana ppic')
    			    ->addWhere('(? <= pe.fecha_pago AND  pe.fecha_pago <= ?)', array($fechaDesde, $fechaHasta))
    			    ->addWhere('pe.fecha_baja IS NULL')
    			    ->addWhere('ppic.id_campana IS NULL')
    			    ->execute();
	}
	
    /**
     * Retorna si hay marcas del rubro ingresado por parametro
     *
     * @param $idMarcaRubro
     *
     * @return boolean
     */
    public function hayMarcasDelRubro($idMarcaRubro)
    {
    	return (bool) $this->createQuery('m')
    	->addwhere('m.id_marca_rubro = ?',$idMarcaRubro)
    	->count();
    }
    
    /**
     * Retorna todas las marcas que tienen un producto en outlet
     *
     * @return array
     */
    public function listKeysForOutlet()
    {
        return $this   ->createQuery('m')
                        ->select('m.id_marca, m.nombre')
                        ->distinct()
                        ->innerJoin('m.producto p')
                        ->innerJoin('p.productoItem pi')
                        ->addWhere('p.activo = ?', true)
                        ->addWhere('p.es_outlet = ?', true)
                        ->addWhere('pi.stock > 0')
                        ->orderBy('m.nombre ASC')
                        ->useResultCache(true, null, cacheHelper::getInstance()->genKey("marca_listKeysForOutlet") )
                        ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
    }

    /**
     * 
     * Retorna las marcas segun un array de filtros
     * 
     * @param array $filters
     * 
     * @return Doctrine_Collection
     */
    public function filter($filters = array())
    {
        $cache = array();
        $esOutlet = (isset( $filters['esOutlet'] ) && $filters['esOutlet'] === true );
        $cache['esOutlet'] = ( $esOutlet ) ? 1 : 0;
                
    	$q = $this->createQuery('m')
    			  ->select('m.id_marca, m.nombre, m.backstage_url, m.id_marca_rubro')
    			  ->innerJoin('m.producto p')
    			  ->innerJoin('p.productoItem pi')
    			  ->innerJoin('p.productoCategoria pct')
    			  ->leftJoin('p.productoCampana pc')
    			  ->leftJoin('pc.campana c')
		    	  ->addwhere('p.activo = ?', true)
		    	  ->addWhere('p.es_outlet = ?', $esOutlet)
		    	  ->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
		    	  ->groupBy('m.id_marca, m.nombre, m.backstage_url, m.id_marca_rubro')
    			  ->orderby('m.nombre ASC');
    	
    	
    	$cache['idCampana'] = "";    	
    	if (!empty($filters['idCampana']))
    	{
    	    $q->addwhere('c.id_campana = ?', $filters['idCampana']);
			$cache['idCampana'] = $filters['idCampana'];
    	}
    	
    	$cache['idEshop'] = "";
    	if ( !empty($filters['idEshop']) )
    	{
    	    $q->addwhere('p.id_eshop = ?', $filters['idEshop']);
    	    $q->addWhere('c.id_campana is null');
    	    $q->having('SUM(pi.stock) > 0');
    	    $cache['idEshop'] = $filters['idEshop'];
    	} else {
    	    $q->addwhere('p.id_eshop IS NULL');
    	    $cache['idEshop'] = '0';
    	}
    	
    	$cache['tag'] = "";
    	if (!empty($filters['tag']))
    	{
    	    $tag = $filters['tag'];
    	    
            $q->innerJoin('p.productoTag pTag')
                  ->innerJoin('pTag.tag tag')
                  ->addWhere('tag.denominacion like ?', array("%$tag%"));
            
    	    $cache['tag'] = $filters['tag'];
    	}	
	
		$cache['idProductoCategoria'] = "";
		if (!empty($filters['idProductoCategoria'])) 
		{
			$q->addWhere('p.id_producto_categoria = ?', $filters['idProductoCategoria']);
			$cache['idProductoCategoria'] = $filters['idProductoCategoria'];
		}
		
		$cache['idProductoSticker'] = "";
		if (!empty($filters['idProductoSticker']))
		{
		    $q->addWhere('p.id_producto_sticker = ?', $filters['idProductoSticker']);
		    $cache['idProductoSticker'] = $filters['idProductoSticker'];
		}
		
		$cache['idProductoGenero'] = "";
		if (!empty($filters['idProductoGenero'])) 
		{
		    $q->addWhere('pct.id_producto_genero = ?', $filters['idProductoGenero']);
			$cache['idProductoGenero'] = $filters['idProductoGenero'];
		}
		
    	$q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("marca_filter_" . implode('_', $cache)) );
    	
    	return $q->execute();
    }
    
    /**
     * Retorna todas las marcas asignadas a una campaña
     *
     * @param $idCampana
     * 
     * @return Doctrine_Collection
     */
    public function listByIdCampana($idCampana)
    {
        return $this->createQuery('m')
                    ->select('m.*')
                    ->innerJoin('m.campanaMarca cm')
                    ->addWhere('cm.id_campana = ?', $idCampana)
                    ->orderBy('m.nombre asc')
                    ->execute();
    }
    
    /**
     * Retorna todas las marcas con al menos un producto en fallados
     *
     * @return Doctrine_Collection
     */
    public function listWithFallados()
    {
        return $this->createQuery('m')
                   ->select( 'm.*')
                   ->innerJoin( 'm.producto p' )
                   ->innerJoin( 'p.productoItem pi' )
                   ->innerJoin( 'pi.pedidoProductoItem ppi' )
                   ->innerJoin( 'ppi.fallado f' )
                   ->addWhere( 'ppi.costo > 0' )
                   ->addWhere( 'f.recuperado = false' )
                   ->orderBy('m.nombre')
                   ->execute();
    }
    
    /**
     * Retorna todas las marcas con al menos un producto en devueltosMarcas
     *
     * @return Doctrine_Collection
     */
    public function listWithDevueltosMarcas()
    {
        return $this->createQuery('m')
        ->select( 'm.*')
        ->innerJoin( 'm.producto p' )
        ->innerJoin( 'p.productoItem pi' )
        ->innerJoin( 'pi.pedidoProductoItem ppi' )
        ->innerJoin( 'ppi.devueltoMarca dm' )
        ->addWhere( 'ppi.costo > 0' )
        ->addWhere( 'dm.devuelto = false' )
        ->orderBy('m.nombre')
        ->execute();
    }

    /**
    * Retorna todas las marcas que tienen productos en un pedido determinado
    * 
    * @param int $idPedido
    * 
    * @return Doctrine_Collection
    */
    public function listByIdPedido( $idPedido )
    {
        return $this->createQuery('m')
                    ->select('m.*')
                    ->distinct()
                    ->innerJoin('m.producto pr')
                    ->innerJoin('pr.productoItem pi')
                    ->innerJoin('pi.pedidoProductoItem ppi')
                    ->innerJoin('ppi.pedido pe')
                    ->addWhere('pe.id_pedido = ?', $idPedido)
                    ->execute();
    }
    
    
}