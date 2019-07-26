<?php


class productoTalleTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoTalleTable;
	* 
	* @return productoTalleTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoTalle');
    }
    
	/**
	* Retorna el productoTalle con orden mas bajo
	* 
	* @return marca
	*/
	public function getFirst()
	{    	
    	return $this->createQuery('pt')
						->orderBy('pt.orden asc')
						->limit(1)
						->fetchOne();
	}
	
    
	/**
	* Retorna el productoTalle con orden mas alto
	* 
	* @return productoTalle
	*/
	public function getLast()
	{    	
    	return $this->createQuery('pt')
						->orderBy('pt.orden desc')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el anterior productoTalle para un $orden
	* 
	* @return productoTalle
	*/
	public function getPrev( $orden )
	{    	
    	return $this->createQuery('pt')
						->where('pt.orden < ?', array( $orden ) )
						->orderBy('pt.orden desc')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el siguiente productoTalle para un $orden
	* 
	* @return marca
	*/
	public function getNext( $orden )
	{    	
    	return $this->createQuery('pt')
						->where('pt.orden > ?', array( $orden ) )
						->orderBy('pt.orden asc')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el productoTalle que coincide con su denominacion
	* 
	* @return productoTalle
	*/
	public function getByDenominacion($denominacion)
	{
		return $this->createQuery('pt')
					->addWhere('pt.denominacion = ?', $denominacion)
					->fetchOne();
	}		
	
	/**
	 * Retorna el listado ordenado con todos los productoTalle
	 *
	 * @return Doctrine_Collection
	 */
	public function listAll()
	{
	    return $this->createQuery('pt')
	    ->select('pt.*, ft.*')
	    ->innerJoin('pt.familiaTalle ft')
	    ->orderBy('ft.denominacion, pt.orden asc')
	    ->execute();
	}
	
	public function filter($filters = array())
	{	    
        $cache = array();
        $esOutlet = (isset( $filters['esOutlet'] ) && $filters['esOutlet'] === true );
        $cache['esOutlet'] = ( $esOutlet ) ? 1 : 0;
	    
		$q = $this->createQuery('pt')
					->select('pt.denominacion, ft.denominacion as family')
					->innerJoin('pt.productoItem pi')
					->innerJoin('pt.familiaTalle ft')
					->innerJoin('pi.producto p')
					->innerJoin('p.productoCategoria pct')
					->leftJoin('p.productoCampana pc')
					->leftJoin('pc.campana c')
					->addwhere('p.activo = ?', true)
					->addWhere('p.es_outlet = ?', $esOutlet)
					->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
					->groupBy('pt.denominacion, ft.denominacion')
					->orderBy('pt.id_familia_talle ASC, pt.orden ASC');
					
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
		if (!empty($filters['idProductoCategoria'])) {
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
		if (!empty($filters['idProductoGenero'])) {
		    $q->addWhere('pct.id_producto_genero = ?', $filters['idProductoGenero']);
			$cache['idProductoGenero'] = $filters['idProductoGenero'];
		}
		
		$cache['marcas'] = "";
    	if (!empty($filters['marcas']))
    	{
    		$q->leftJoin('p.productoCampana pc')
    		  ->addWhere('p.id_marca = ?',$filters['marcas'])
    		  ->addWhere('pc.id_campana IS NULL');
    		$cache['marcas'] = $filters['marcas'];
    		
    	}
		
		$q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("productoTalle_filter_" . implode("_", $cache)) );
		
		return $q->execute();
	}
    
}