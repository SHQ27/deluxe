<?php


class productoCategoriaTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoCategoriaTable;
	* 
	* @return productoCategoriaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoCategoria');
    }
    
	/**
	* Retorna todas las categorias
	* 
	* @return Doctrine_Collection
	*/
	public function listAll()
	{
		return $this->createQuery('c')
		            ->select('*')
		            ->innerJoin('c.productoGenero pg')
		            ->orderBy('pg.denominacion, c.denominacion')
		            ->execute();
	}
	
	/**
	* Dado un productoGenero retorna todas las categorias con
	* al menos un producto activo asociado.
	* 
	* SOLO SE USA PARA DELUXEBUYS / NO SE USA PARA ESHOPS
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProductoGenero($idProductoGenero)
	{
		$query = $this->createQuery('cat')
					  ->select('cat.*')
					  ->innerJoin('cat.producto p')
					  ->leftJoin('p.productoCampana pca')
					  ->leftJoin('pca.campana c')
					  ->addWhere('p.activo = ?', true)
					  ->addWhere('cat.id_producto_genero = ?', $idProductoGenero)
					  ->addWhere('p.es_outlet = ?', false)
					  ->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
					  ->addWhere('p.id_eshop IS NULL')
		              ->groupBy('cat.id_producto_categoria, cat.denominacion, cat.id_producto_genero')
		              ->orderBy('cat.denominacion asc');
		
	    $query->useResultCache(true, null, "productoCategoria_listByIdProductoGenero_" . cacheHelper::getInstance()->genKey( $idProductoGenero ) );
	    
		return $query->execute();
	}


	/**
	* Dado un productoGenero retorna todas las categorias con
	* al menos un producto activo asociado.
	* 
	* SOLO SE USA PARA ESHOPS / NO SE USA PARA DELUXEBUYS
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProductoGeneroEshops($idProductoGenero, $idEshop, $tipoPrenda )
	{
		$query = $this->createQuery('pc')
					  ->select('pc.*')
					  ->innerJoin('pc.producto p')
					  ->innerJoin('p.productoItem pi')
					  ->leftJoin('pc.productoCategoriaEshop pce ON ( pc.id_producto_categoria = pce.id_producto_categoria AND pce.id_eshop = ? )', $idEshop)
					  ->addWhere('p.activo = ?', true)
					  ->addWhere('p.es_outlet = ?', false)
					  ->addWhere('p.id_eshop = ?', $idEshop)
					  ->addWhere('pc.id_producto_genero = ?', $idProductoGenero);


		  if ( $tipoPrenda  == productoCategoriaEshop::TIPO_PRENDA_PRENDA ) {
		  	$query->addWhere('( pce.tipo_prenda IS NULL OR pce.tipo_prenda = ? )', $tipoPrenda);
		  } else {
		  	$query->addWhere('pce.tipo_prenda = ?', $tipoPrenda);
		  }


		$query->groupBy('pc.id_producto_categoria, pc.denominacion, pc.id_producto_genero')
			  ->having('SUM(pi.stock) > 0')
			  ->orderBy('COALESCE(pce.orden, 999) ASC, pc.denominacion ASC');

		
	    $query->useResultCache(true, null, "productoCategoria_listByIdProductoGeneroEshops_" . cacheHelper::getInstance()->genKey( $idProductoGenero  . '_' . $idEshop . '_' . $tipoPrenda ) );
	    
		return $query->execute();
	}
	
	
	/**
	* Retorna la categoria que coincide con el slug de categoria y genero
	* y con al menos un producto activo asociado
	* 
	* @return productoCategoria
	*/
	public function getBySlug($slugProductoCategoria, $idProductoGenero)
	{
		$query = $this->createQuery('c')
					->select('c.*')
					->distinct()
					->innerJoin('c.producto p')
					->addWhere('c.slug = ?', $slugProductoCategoria)
					->addWhere('c.id_producto_genero = ?', $idProductoGenero)
					->addWhere('p.activo = ?', true);
					
		
		$query->useResultCache(true, 3600, cacheHelper::getInstance()->genKey("productoCategoria_getBySlug_" . $slugProductoCategoria . "_" . $idProductoGenero) );
		
		return $query->fetchOne();
		
	}
	
	/**
	 * Retorna la categoria que coincide $idProductoCategoria enviado por parametro
	 *
	 * @return productoCategoria
	 */
	public function getById($idProductoCategoria)
	{
	    return $this->createQuery('c')
            	    ->select('c.*, cg.*')
            	    ->addWhere('c.id_producto_categoria = ?', $idProductoCategoria)
            	    ->fetchOne();
	}
	
	/**
	 * Retorna la categoria que coincide con la denominacion de categoria y genero
	 *
	 * @return productoCategoria
	 */
	public function getByDenominacion($denominacionProductoCategoria, $denominacionProductoGenero)
	{
		return $this->createQuery('c')
		->select('c.*')
		->innerJoin('c.productoGenero pg')
		->addWhere('c.denominacion = ?', $denominacionProductoCategoria)
		->addWhere('pg.denominacion = ?', $denominacionProductoGenero)
		->fetchOne();
	}
		
	/**
	* Retorna todas las categorias que coinciden con el slug de categoria
	* 
	* @return productoCategoria
	*/
	public function listBySlug($slugProductoCategoria)
	{
		return $this->createQuery('c')
					->select('c.*')
					->addWhere('c.slug = ?', $slugProductoCategoria)
					->execute();
	}
    
	/**
	* Trae las marcas de los productos buscados
	* @param string $term
	* 
	* @return Doctrine_Collection
	*/
    public function listarProductoCategoriasDeBusqueda($term)
    {
		$q = $this->createQuery('pc')
    			    ->select('pc.*')
    			    ->distinct()
    			    ->innerJoin('pc.producto p')
    			    ->innerJoin('p.marca m')
    			    ->leftJoin('p.productoTag pt')
    			    ->leftJoin('pt.tag t')
					->leftJoin('p.productoCampana pca')
					->leftJoin('pca.campana c')
					->addWhere('p.activo = 1')
					->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)');
					
        $q->addWhere('p.denominacion like ? or p.descripcion like ? or m.nombre like ? or t.denominacion like ?',
        array("%$term%","%$term%","%$term%","%$term%"));
        
    	return $q->execute();
    }
    
	/**
	* Retorna todas las categorias con al menos un producto activo asociado
	* 
	* @return Doctrine_Collection
	*/
	public function listActivas()
	{
		return $this->createQuery('c')
					->select('c.*')
					->distinct()
					->innerJoin('c.producto p')
					->addWhere('p.activo = ?', true)
					->useResultCache(true, 86400, cacheHelper::getInstance()->genKey("productoCategoria_listActivas") )
					->execute();
	}
	
	
	/**
	 * Dado un $idCampana retorna todas las categorias con al menos un producto activo asociado
	 *
	 * @param int $idCampana
	 *
	 * @return array
	 */
	public function listKeysByIdCampana($idCampana)
	{
	    return $this->createQuery('c')
	    ->select('c.slug, c.denominacion')
	    ->distinct()
	    ->innerJoin('c.producto p')
	    ->innerJoin('p.productoCampana pc')
	    ->addWhere('p.activo = ?', true)
	    ->addWhere('pc.id_campana = ?', $idCampana)
	    ->orderBy('c.denominacion asc')
	    ->useResultCache(true, null, cacheHelper::getInstance()->genKey("productoCategoria_listKeysByIdCampana_" . $idCampana) )
	    ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
	}
	
	/**
	 * Retorna todas las categorias con al menos un producto activo en outlet
	 *
	 * @return array
	 */
	public function listKeysForOutlet()
	{
	    return $this->createQuery('c')
	    ->select('c.slug, c.denominacion')
	    ->distinct()
	    ->innerJoin('c.producto p')
	    ->innerJoin('p.productoItem pi')
	    ->addWhere('p.activo = ?', true)
	    ->addWhere('p.es_outlet = ?', true)
	    ->addWhere('pi.stock > 0')
	    ->orderBy('c.denominacion asc')
	    ->useResultCache(true, null, cacheHelper::getInstance()->genKey("productoCategoria_listKeysForOutlet") )
	    ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
	}
	
	/**
	 * Retorna todas las categorias con al menos un producto asociado a cualquier campaña con id enviado en $idsCampana
	 *
	 * @param int $idCampana
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIdsCampana($idsCampana)
	{
	    return $this->createQuery('c')
	    ->innerJoin('c.productoGenero pg')
	    ->innerJoin('c.producto p')
	    ->innerJoin('p.productoCampana pc')
	    ->andWhereIn('pc.id_campana', $idsCampana)
	    ->orderBy('pg.denominacion asc, c.denominacion asc')
	    ->execute();
	}
	
	public function filter($filters = array())
	{	    	    	    
        $cache = array();
        $esOutlet = (isset( $filters['esOutlet'] ) && $filters['esOutlet'] === true );
        $cache['esOutlet'] = ( $esOutlet ) ? 1 : 0;
	    
		$q = $this->createQuery('pcat')
				    ->select('pcat.denominacion, group_concat(DISTINCT pcat.id_producto_categoria) as id_producto_categoria')
				    ->innerJoin('pcat.producto p')
				    ->leftJoin('p.productoCampana pc')
				    ->leftJoin('p.productoItem pi')
				    ->leftJoin('pc.campana c')
				    ->addwhere('p.activo = ?', true)
				    ->addWhere('p.es_outlet = ?', $esOutlet)
				    ->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
					->groupBy('pcat.denominacion');
			
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
    	
		$q->innerJoin('p.productoCategoria pct')
		  ->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)');
	
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

    	$cache['marcas'] = "";
    	if (!empty($filters['marcas']))
    	{
    		$q->addWhere('p.id_marca = ?',$filters['marcas'])
    		  ->addWhere('pc.id_campana IS NULL');
    		$cache['marcas'] = $filters['marcas'];
    	}
    	
	    $q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("productoCategoria_filter_" . implode("_", $cache)) );

		return $q->execute();
	}
    
    
}