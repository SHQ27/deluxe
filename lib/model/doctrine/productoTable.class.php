<?php

class productoTable extends Doctrine_Table
{
	/**
	* Retorna una instancia de productoTable;
	* 
	* @return productoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('producto');
    }
    
	/**
	* Retorna un producto a partir de su id
	* 
	* @param integer $idProducto
	* 
	* @return producto
	*/
    public function getById($idProducto)
    {
		return $this->createQuery('p')
    			    ->where('p.id_producto  = ?', $idProducto)
    			    ->fetchOne();
    }
    
    /**
     * Retorna un producto a partir de su id e id de marca
     *
     * @param string $idProducto
     * @param integer $idMarca
     *
     * @return producto
     */
    public function getByIdAndMarca($idProducto, $idMarca)
    {
        return $this->createQuery('p')
                    ->addWhere('p.id_producto  = ?', $idProducto)
                    ->addWhere('p.id_marca = ?', $idMarca)
                    ->fetchOne();
    }
    
    /**
     * Retorna el listado de productos asignados y activos en outlet
     *
     * @return Doctrine_Collection
     */
    public function listActivosEnOutlet()
    {
    	return $this->createQuery('p')
			    	->addWhere('p.es_outlet = ?', true)
			    	->addWhere('p.activo = ?', true)
			    	->execute();
    }
    
	/**
	* Retorna el proximo id disponible en DB
	*  
	* @return integer
	*/
    public function nextId()
    {
		$sequence = new Doctrine_Sequence_Mysql();
    	return $sequence->nextId('id_producto');
    }
    

    
	/**
	* Retorna  todos los productos que contengan el términos de búsqueda y la marca
	* 
	* @param string $term
	* 
	* @return producto
	*/
    public function buscarProductosDeMarca($term, $idmarca)
    {
		return $this->createQuery('p')
    			    ->addWhere('p.denominacion like ?', "%$term%")
    			    ->addWhere('m.id_marca = ?', $idmarca)
    			    ->addWhere('p.activo = ?', true)
    			    ->innerJoin('p.marca m')
    			    ->orderBy('p.denominacion')
    			    ->limit(20)
    			    ->execute();
    }
    
	/**
	* Retorna  todos los productos que contengan el términos de búsqueda
	* 
	* @param string $term
	* 
	* @return producto
	*/
    public function buscarProductos($term)
    {
		return $this->createQuery('p')
    			    ->addWhere('p.denominacion like ?', "%$term%")
    			    ->addWhere('p.activo = ?', true)
    			    ->orderBy('p.denominacion')
    			    ->limit(20)
    			    ->execute();
    }

    /**
    * Retorna el listado de productos asignados a una campaña
    * 
    * @param number $idCampana
    * 
    * @return Doctrine_Collection
    */
    public function listByIdCampana($idCampana, $soloActivos = true)
    {
        $q = $this->createQuery('p')
                    ->innerJoin('p.productoItem pi')
                    ->innerJoin('p.productoCategoria pcat')
                    ->leftJoin('p.productoSticker ps')
                    ->innerJoin('p.marca m')
                    ->innerjoin('p.productoCampana pc')
                    ->innerjoin('pc.campana c')
                    ->addwhere('pc.id_campana = ?', $idCampana);
                    
        if ( $soloActivos )
        {
            $q->addWhere('p.activo = ?', true);
        }
        
        return $q->execute();
    }
       


    /**
    * Retorna el listado de productos asignados a una categoria y de una marca en particular
    * 
    * @param number $idCampana
    * @param number $idMarca
    * 
    * @return Doctrine_Collection
    */
    public function listPertenecieronCampana($idCampana, $idMarca)
    {
        return $this->createQuery('p')
                    ->innerjoin('p.productoCampanaFinalizada pcf')
                    ->addwhere('pcf.id_campana = ?', $idCampana)
                    ->addwhere('p.id_marca = ?', $idMarca)
                    ->orderBy('p.denominacion')
                    ->execute();
    }
       
    /**
    * Retorna el listado de productos asignados a una categoria y de una marca en particular
    * 
    * @param number $idProductoCategoria
    * @param number $idMarca
    * 
    * @return Doctrine_Collection
    */
    public function listByCategoriaYMarca($idProductoCategoria, $idMarca)
    {
        return $this->createQuery('p')
                    ->addwhere('p.id_producto_categoria = ?', $idProductoCategoria)
                    ->addwhere('p.id_marca = ?', $idMarca)
                    ->orderBy('p.denominacion')
                    ->execute();
    }

    
	/**
	* Retorna el listado de productos asignados a un tag
	* 
	* @param number $idTag
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdTag($idTag, $soloActivos = true)
    {
		$q = $this->createQuery('p')
					->select('p.*')
					->innerjoin('p.productoTag pt')
				    ->addwhere('pt.id_tag = ?', $idTag);
				    
		if ( $soloActivos )
		{
			$q->addWhere('p.activo = ?', true);
		}
				
		return $q->execute();
    }
    

  /**
  * Retorna el listado de productos asignados a un eshopLookbook
  * 
  * @param number $idEshopLookbook
  * 
  * @return Doctrine_Collection
  */
    public function listByIdEshopLookbook($idEshopLookbook)
    {
    return $this->createQuery('p')
                ->select('p.*')
                ->innerjoin('p.eshopLookbookProducto elp')
                ->addwhere('elp.id_eshop_lookbook = ?', $idEshopLookbook)
                ->execute();
    }


	/**
	* Retorna el listado de productos asignados a un cupon
	* 
	* @param number $idCupon
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdCupon($idCupon)
    {
		return $this->createQuery('p')
					->select('p.*')
					->innerjoin('p.cuponProducto cp')
				    ->addwhere('cp.id_cupon = ?', $idCupon)
				    ->execute();
    }
    
	/**
	* Retorna el listado de productos asignados a un descuento
	* 
	* @param number $idDescuento
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdDescuento($idDescuento)
    {
        
        
		return $this->createQuery('p')
					->select('p.*')
					->addwhere('p.id_producto IN (SELECT dr.valor FROM descuentoRestriccion dr WHERE dr.id_descuento = ? AND dr.tipo = ?)', array( $idDescuento, descuentoRestriccion::PRODUCTOS ))
				    ->execute();
    }
    
	/**
	* Retorna el listado de productos pertenecientes a una marca
	* 
	* @param number $idMarca
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdMarca($idMarca, $activo = null)
    {
		$q = $this->createQuery('p')
				  ->addWhere('p.id_marca = ?', $idMarca);

        if ( $action !== null ) {
            $q->addwhere('p.activo = ?', $activo);
        }

 
    	return $q->execute();
    }
    
	/**
	* Retorna los X productos relacionados a una lista de tags
	* 
	* @param array $tags
	* 
	* @return Doctrine_Collection
	*/
    public function listRelatedByTagList($tags, $idSession, $limit = 5)
    {    	
		$q = $this->createQuery('p')
					->select('p.id_producto')
					->innerJoin('p.productoTag pt')
					->innerJoin('pt.tag t')
					->leftJoin('p.productoCampana pc')
					->leftJoin('pc.campana c')
				    ->whereIn('t.denominacion', $tags)
				    ->addWhere('p.activo = ?', true)
				    ->addWhere('(c.activo IS NULL OR c.activo = ?)', true)
				    ->groupBy('p.id_producto')
				    ->orderBy('COUNT(p.id_producto) DESC')
				    ->limit($limit);
				    
		$subQuery = $q->createSubquery()
		    ->select('p2.id_producto')
		    ->from('producto p2')
		    ->innerJoin('p2.productoItem pi2')
		    ->innerJoin('pi2.carritoProductoItem cpi2')
		    ->addWhere('cpi2.id_session = ?');
				    
		$q->addWhere('p.id_producto NOT IN (' . $subQuery->getDql() . ')', $idSession);	    
		    
		return $q->execute();
    }
        
    
    /**
     * Retorna un producto a partir de su id para mostrarse en el detalle de producto
     *
     * @param integer $idProducto
     *
     * @return producto
     */
    public function getForDetalle($idProducto)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $q = $this->createQuery('p')
                  ->select('p.*, m.*, pc.*, c.*, pt.*, t.*, pim.*, pcat.*, pg.*, ps.*, ts.*')
                  ->innerJoin('p.productoItem pi')
                  ->innerJoin('p.productoCategoria pcat')
                  ->innerJoin('pcat.productoGenero pg')
                  ->innerJoin('p.marca m')
                  ->leftJoin('p.productoCampana pc')
                  ->leftJoin('pc.campana c')
                  ->leftJoin('p.productoTag pt')
                  ->leftJoin('pt.tag t')
                  ->leftJoin('p.productoImagen pim')
                  ->leftJoin('p.productoSticker ps')
                  ->leftJoin('p.talleSet ts')
                  ->where('p.id_producto  = ?', $idProducto);

        if ( $idEshop ) {
            $q->addwhere('p.id_eshop = ?', $idEshop );
        } else {
            $q->addwhere('p.id_eshop IS NULL');
        }
                 
        return $q->fetchOne();
    }
        
	/**
	* Retorna la query para el listado de productos para la pagina de productos por productoGenero, teniendo en cuenta los distintos tipos de filtros y ordenes 
	* 
	* @param Array $filtros
	* 
	* @return Doctrine_Collection
	*/
    public function queryFilterBy( $filtros = array(), $page, $useCache = true)
    {                        
        $q = $this->createQuery('p')
                  ->select('p.id_producto, p.denominacion, p.precio_lista, p.precio_deluxe, p.mostrar_precio_lista, p.es_outlet, p.id_producto_sticker, p.id_eshop')
                  ->addSelect('m.*')
                  ->addSelect('ps.*')
                  ->addSelect('pc.*, pca.*, c.*, pcat.*');
        
        $q->addSelect('SUM(pi.stock)  as stock_calculado');
        
        $q->addSelect('COALESCE( SUM( cpi.cantidad ), 0 ) as cantidad_en_carrito_calculado');
        
        $subQ = $q  ->createSubquery()
        ->select('s1_pi.id_producto_imagen')
        ->from('productoImagen s1_pi')
        ->addWhere('s1_pi.id_producto = p.id_producto')
        ->orderBy('s1_pi.orden')
        ->limit(1);
        
        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );

        $subQ = $q->createSubquery()
                  ->select('s2_pi.id_producto_imagen')
                  ->from('productoImagen s2_pi')
                  ->addWhere('s2_pi.id_producto = p.id_producto')
                  ->orderBy('s2_pi.orden DESC')
                  ->limit(1);

        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_hover_calculado');
        
        $subQ = $q  ->createSubquery()
        ->select('COUNT(s3_pc.id_campana)')
        ->from('productoCampana s3_pc')
        ->addWhere('s3_pc.id_producto = p.id_producto');
        
        $q->addSelect('(' . $subQ->getDql() . ') as es_oferta_calculado' );
        
        $response = $this->whereFilter($q, $filtros);
         
        $q = $response['query'];
        $cacheFilters = $response['cacheKey'];
        
        if ( $useCache ) {
          $q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("producto_queryFilterBy_" . $cacheFilters . "_" . $page) );  
        }
        
        
        return $q;
    }

    /**
     * Retorna la query para el listado de productos para una campaña en particular
     *
     * @param int $page
     * @param array $filtros
     *
     * @return Doctrine_Collection
     */
    public function queryActivosByIdCampana( $page = 1, $filtros = array() )
    {
    	$q = $this->createQuery('p')
    	          ->select('p.id_producto, p.denominacion, p.precio_lista, p.precio_deluxe, p.mostrar_precio_lista, p.es_outlet, p.id_producto_sticker, p.id_eshop')
    	          ->addSelect('pcat.*')
    	          ->addSelect('ps.*')
    	          ->addSelect('m.*');
    	
    	
    	$q->addSelect('SUM(pi.stock)  as stock_calculado');
    	
    	$q->addSelect('COALESCE( SUM( cpi.cantidad ), 0 ) as cantidad_en_carrito_calculado');
    	
    	$subQ = $q  ->createSubquery()
                	->select('s1_pi.id_producto_imagen')
                	->from('productoImagen s1_pi')
                	->addWhere('s1_pi.id_producto = p.id_producto')
                	->orderBy('s1_pi.orden')
                	->limit(1);
    	
    	$q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );
    	
    	$subQ = $q  ->createSubquery()
    	->select('COUNT(s2_pc.id_campana)')
    	->from('productoCampana s2_pc')
    	->addWhere('s2_pc.id_producto = p.id_producto');
    	
    	$q->addSelect('(' . $subQ->getDql() . ') as es_oferta_calculado' );
	   	
    	$response = $this->whereFilter($q, $filtros);
    	$q = $response['query'];
    	$cacheFilters = $response['cacheKey'];
		
		  $q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("producto_queryActivosByIdCampana_" . $cacheFilters . '_' . $page) );
    	
    	return $q;
    }
        
    
    protected function whereFilter($query, $filtros = array() )
    {        
        $cache = array();
        $esOutlet = (isset( $filtros['esOutlet'] ) && $filtros['esOutlet'] === true );
        $cache['esOutlet'] = ( $esOutlet ) ? 1 : 0;
        
        $query->innerJoin('p.productoCategoria pcat')
              ->innerJoin('p.marca m')
              ->innerJoin('p.productoItem pi')
              ->leftJoin('p.productoCampana pc')
              ->leftJoin('pc.campana c')
              ->leftJoin('pi.carritoProductoItem cpi')
              ->leftJoin('p.productoSticker ps')
              ->addwhere('p.activo = ?', true)
              ->addWhere('p.es_outlet = ?', $esOutlet)
              ->addWhere('(c.id_campana is null) or (c.activo AND c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
              ->groupBy('p.id_producto, p.denominacion, p.descripcion, p.info_adicional, p.id_marca, p.id_producto_categoria, p.fecha_modificacion, p.precio_lista, p.mostrar_precio_lista, p.precio_deluxe, p.costo, p.peso, p.destacar, p.activo, p.vendidos, p.visitas, p.id_producto_sticker');
        
           
        if ($esOutlet)
        {
        	$query->having('SUM(pi.stock) > 0');
        }
        
        $cache['idEshop'] = "";
        if ( !empty($filtros['idEshop']) )
        {
            $query->addwhere('p.id_eshop = ?', $filtros['idEshop']);
            $query->addwhere('c.id_campana IS NULL');
            $query->having('SUM(pi.stock) > 0');
            $cache['idEshop'] = $filtros['idEshop'];
        } else {
            $query->addwhere('p.id_eshop IS NULL');
            $cache['idEshop'] = '0';
        }
        
        $cache['idCampana'] = "";
        if (!empty($filtros['idCampana']))
        {
            $query->addwhere('c.id_campana = ?', $filtros['idCampana']);
            $cache['idCampana'] = $filtros['idCampana'];
        }
        
        $cache['idProductoGenero'] = "";
        if ( !empty($filtros['idProductoGenero']) )
        {
        	$query->addWhere('pcat.id_producto_genero = ?', $filtros['idProductoGenero']);
        	$cache['idProductoGenero'] = $filtros['idProductoGenero'];
        }
        
        $cache['idProductoCategoria'] = "";
        if ( !empty($filtros['idProductoCategoria']) )
        {
        	$query->addWhere('p.id_producto_categoria = ?', $filtros['idProductoCategoria']);
        	$cache['idProductoCategoria'] = $filtros['idProductoCategoria'];
        }
    
        $cache['marcas'] = "";
        if (!empty($filtros['marcas']))
        {
        	if (is_array(($filtros['marcas'])))
        	{
        		$query->addWhere('p.id_marca = ?', $filtros['marcas'][0]);
        		$cache['marcas'] = $filtros['marcas'][0];
        	} 
        	else 
        	{
	            $idMarcas = explode(",", $filtros['marcas']);
	            $query->addWhere('p.id_marca IN ?', array($idMarcas));
	            $cache['marcas'] = $filtros['marcas'];
        	}
        }
    
        $cache['categorias'] = "";
        if (!empty($filtros['categorias']))
        {
            $idCategorias = explode(",", $filtros['categorias']);
            $query->addWhere('pcat.id_producto_categoria IN ?', array($idCategorias));
            $cache['categorias'] = $filtros['categorias'];
        }
    
        $cache['talles'] = "";
        if (!empty($filtros['talles']))
        {
            $idTalles = explode(",", $filtros['talles']);
            $query->addWhere('pi.id_producto_talle IN ?', array($idTalles));
            $cache['talles'] = $filtros['talles'];
        }
    
        $cache['colores'] = "";
        if (!empty($filtros['colores']))
        {
            $idColores = explode(",", $filtros['colores']);
            $query->innerJoin('pi.productoColor pcol');
            $query->innerJoin('pcol.familiaColor fc');
            $query->addWhere('fc.id_familia_color IN ?', array($idColores));
            $cache['colores'] = $filtros['colores'];
        }
                
        $cache['tag'] = "";
    	if (!empty($filtros['tag']))
    	{
    	    $tag = $filtros['tag'];
    	    
            $query->innerJoin('p.productoTag pTag')
                  ->innerJoin('pTag.tag tag')
                  ->addWhere('tag.denominacion like ?', array("%$tag%"));
            
    	    $cache['tag'] = $filtros['tag'];
    	}
    
        $cache['rango'] = "";
        if (!empty($filtros['rango']))
        {
            $rango = explode(",", $filtros['rango']);
            $query->addWhere('p.precio_deluxe >= ?', $rango[2])  // min
            	  ->addWhere('p.precio_deluxe <= ?', $rango[3]); // max
            $cache['rango'] = $filtros['rango'];
        }
        
        $cache['idProductoSticker'] = "";
        if (!empty($filtros['idProductoSticker']))
        {        
            $query->addWhere('p.id_producto_sticker = ?', $filtros['idProductoSticker']);
        
            $cache['idProductoSticker'] = $filtros['idProductoSticker'];
        }
        
        
    
        $cache['order'] = "";
        $filtros['order'] = ( isset( $filtros['order'] ) ) ? $filtros['order'] : null;
        if ( $filtros['order'] != 'NO-ORDER' )
        {
            if ( !empty($filtros['order']) )
            {
                $ordenamientos = array
                (
                    'PRECIO_ASC'    => 'p.precio_deluxe ASC',
                    'PRECIO_DESC'   => 'p.precio_deluxe DESC',
                    'MAS_VISITADOS' => 'p.visitas DESC',
                    'MAS_VENDIDOS'  => 'p.vendidos DESC'
                );
            
                $query->orderBy($ordenamientos[$filtros['order']]);
                $cache['order'] = $filtros['order'];
            }
            else
            {
                if ( !empty($filtros['idEshop']) ) {
                  $query->orderBy('IF(SUM(pi.stock) > 0, 1, 0) DESC, COALESCE(p.orden_eshop, 9999) ASC, p.destacar DESC, md5(p.denominacion) ASC');
                } else {
                  $query->orderBy('IF(SUM(pi.stock) > 0, 1, 0) DESC, p.destacar DESC, md5(p.denominacion) ASC');                  
                }                
            }   
        } else {
            $cache['order'] = $filtros['order'];
        }
        
        return array('cacheKey' => implode('_', $cache), 'query' => $query);
    }
    
    
    public function queryRangeFilter($filtros = array(), $type)
    {        
        if ( isset($filtros['esOutlet']) && $filtros['esOutlet'] )
        {
            $field = 'p.precio_outlet';
        }
        else
        {
            $field = 'p.precio_deluxe';
        }
        
        $q = $this->createQuery('p')
                  ->select( $field );
        
        $filtros['order'] = 'NO-ORDER';
        
        $response = $this->whereFilter($q, $filtros);
     
        $q = $response['query'];
                
        if ( $type == 'MIN' ) {
            $q->orderBy( $field . ' ASC' );
        } else {
            $q->orderBy( $field . ' DESC' );
        }
        
        $q->limit(1);        
        
        $cacheFilters = $response['cacheKey'];
    	
    	$q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("producto_queryRangeFilter_" . $cacheFilters . "_" . $type) );

    	return $q->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }

    
	/**
	* Retorna el listado de productos de una campana, pudiendo ademas filtrar por un array con $idProductoCategorias  
	*  
	* @return Doctrine_Collection
	*/
    public function listOfertaLimitadaByIdCampana($idCampana, $idMarca, $slugProductoCategoria)
    {
        
        $q = $this  ->createQuery('p')
                    ->select('p.id_producto, p.denominacion, p.precio_lista, p.precio_deluxe, p.mostrar_precio_lista, p.es_outlet')
                    ->addSelect('pcat.*');
        
        $q->addSelect('SUM(pi.stock)  as stock_calculado');
        
        $q->addSelect('COALESCE( SUM( cpi.cantidad ), 0 ) as cantidad_en_carrito_calculado');
        
        $subQ = $q  ->createSubquery()
        ->select('s1_pi.id_producto_imagen')
        ->from('productoImagen s1_pi')
        ->addWhere('s1_pi.id_producto = p.id_producto')
        ->orderBy('s1_pi.orden')
        ->limit(1);
        
        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );        
        
        $subQ = $q  ->createSubquery()
        ->select('COUNT(s3_pc.id_campana)')
        ->from('productoCampana s3_pc')
        ->addWhere('s3_pc.id_producto = p.id_producto');
        
        $q->addSelect('(' . $subQ->getDql() . ') as es_oferta_calculado' );
        
        
		$q  ->innerjoin('p.productoCampana pc')
            ->innerjoin('pc.campana c')
			->innerjoin('c.campanaMarca cm')
			->innerJoin('p.productoItem pi')
			->innerJoin('p.productoCategoria pcat')
			->leftJoin('pi.carritoProductoItem cpi')
		    ->addwhere('pc.id_campana = ?', $idCampana)
		    ->addwhere('cm.id_marca = ?', $idMarca)
		    ->addWhere('p.es_outlet = ?', false)
		    ->addWhere('p.activo = ?', true)
		    ->groupBy('p.id_producto, pi.codigo, p.denominacion, p.descripcion, p.info_adicional, p.id_marca, p.id_producto_categoria, p.fecha_modificacion, p.precio_lista, p.mostrar_precio_lista, p.precio_deluxe, p.costo, p.peso, p.destacar, p.activo, p.vendidos, p.visitas');
					
    	if ( $slugProductoCategoria )
		{
		    $q->innerJoin('p.productoCategoria pc')->addWhere('pc.slug = ?', $slugProductoCategoria);
		}
		
		$q->orderBy('IF(SUM(pi.stock) > 0, 1, 0) DESC, p.destacar DESC, p.precio_deluxe ASC');
		
		$q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("producto_listOfertaLimitadaByIdCampana_" . $idCampana . "_" . $idMarca . "_" . $slugProductoCategoria) );
					
		return $q->execute();
    }
    
    /**
     * Retorna si hay productos de la marca ingresada por parametro
     *
     * @param $idMarca
     *
     * @return boolean
     */
    public function hayProductosDeMarca($idMarca)
    {
    	return (bool) $this->createQuery('p')
    				->addwhere('p.id_marca = ?',$idMarca)
    				->count();
    }
    
    /**
     * Retorna si hay productos de la categoria ingresada por parametro
     *
     * @param $idCategoria
     *
     * @return boolean
     */
    public function hayProductosDeCategoria($idCategoria)
    {
    	return (bool) $this->createQuery('p')
    				->addwhere('p.id_producto_categoria = ?',$idCategoria)
    				->count();
    }
    
	/**
	* Arma la query para la busqueda de productos
	* 
	* @param string $term
	* 
	* @return query
	*/
    public function queryBusquedaProductos($term, $idGenero, $idProductoCategoria, $idMarcas,  $orderBy = 'PRECIO_ASC')
    {
    	$q = $this->createQuery('p')
    			    ->select('p.*')
    			    ->distinct()
    			    ->innerJoin('p.marca m')
    			    ->innerJoin('p.productoCategoria pc')
    			    ->innerJoin('p.productoItem pi')
    			    ->leftJoin('p.productoTag pt')
    			    ->leftJoin('pt.tag t')
					->leftJoin('p.productoCampana pca')
					->leftJoin('pca.campana c')
					->addWhere('((c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin))')
    			    ->addWhere('p.activo = ?', true)
    			    ->groupBy('p.id_producto, pi.codigo, p.denominacion, p.descripcion, p.info_adicional, p.id_marca, p.id_producto_categoria, p.fecha_modificacion, p.precio_lista, p.mostrar_precio_lista, p.precio_deluxe, p.costo, p.peso, p.destacar, p.activo, p.vendidos, p.visitas');
    			    

        if ($idGenero)
    	{
    		$q->addWhere('pc.id_producto_genero = ?', $idGenero);
    	}    
    			    
    	if ($idProductoCategoria)
    	{
    		$q->addWhere('p.id_producto_categoria = ?', $idProductoCategoria);
    	}
    	  		
        if ($idMarcas)
    	{
    		$q->addWhere('p.id_marca IN ?', array($idMarcas));
    	}
    	  
        $q->addWhere('p.denominacion like ? or p.descripcion like ? or m.nombre like ? or t.denominacion like ?',
        array("%$term%","%$term%","%$term%","%$term%"));
        
		$ordenamientos = array
						 (
							'PRECIO_ASC' => 'p.precio_deluxe ASC',
							'PRECIO_DESC' => 'p.precio_deluxe DESC',
							'MAS_VISITADO' => 'p.visitas DESC',
						 	'MAS_VENDIDOS' => 'p.vendidos DESC'
						 );
		
		$q->orderBy('IF(SUM(pi.stock) > 0, 1, 0) DESC, p.destacar DESC,' . $ordenamientos[$orderBy]);

		return $q;

    }
    
	
	/** 
	* Retorna todos los productos que coinciden con los ids pasados por parametro
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProductos($idProductos)
	{
		return $this->createQuery('p')
					->addWhere('p.id_producto IN ?', array( $idProductos ) )
					->execute();
	}
	
    /**
     * Retorna todos los productos activos
     *
     * @return Doctrine_Collection
     */
    public function listActivos()
    {
    	return $this->createQuery('p')
		    	->select('p.*')
		    	->addwhere('p.activo = ?', true)
		    	->addwhere('p.id_eshop IS NULL')
		    	->useResultCache(true, 86400, cacheHelper::getInstance()->genKey("producto_listActivos") )
		    	->execute();
    }
    
    /**
     * Retorna todos los productos activos
     *
     * @return Doctrine_Collection
     */
    public function listXml($idEshop = null)
    {
    	$q = $this->createQuery('p')
            	  ->innerJoin('p.productoCategoria pc')
            	  ->innerJoin('pc.productoGenero pg')
            	  ->innerJoin('p.productoImagen pi')
            	  ->innerJoin('p.marca m')
            	  ->addwhere('p.activo = ?', true);

        if ($idEshop) {
            $q->addwhere('p.id_eshop = ?', $idEshop);
        } else {
            $q->addwhere('p.id_eshop IS NULL');
        }
        

    	return $q->execute();
    }
    
    /**
     * Suma $cantidad vendidas al producto 
     *
     * @param $idProducto
     * @param $cantidad
     *
     */
    public function sumaVenta($idProducto, $cantidad)
    {
		$this->createQuery('p')
    			    ->update()
    			    ->set('vendidos', 'vendidos + ?', $cantidad)
				    ->addwhere('p.id_producto = ?', $idProducto)  
    			    ->execute();
    }
    
    /**
     * Resta $cantidad vendidas al producto 
     *
     * @param $idProducto
     * @param $cantidad
     *
     */
    public function restaVenta($idProducto, $cantidad)
    {
		$this->createQuery('p')
    			    ->update()
    			    ->set('vendidos', 'vendidos - ?', $cantidad)
				    ->addwhere('p.id_producto = ?', $idProducto)  
    			    ->execute();
    }
    
    /**
     * Suma una visita al producto 
     *
     * @param $idProducto
     *
     */
    public function sumarVisita($idProducto)
    {
		$this->createQuery('p')
    			    ->update()
    			    ->set('visitas', 'visitas + 1')
				    ->addwhere('p.id_producto = ?', $idProducto)  
    			    ->execute();
    }
    
    /**
     * Lista todos los productos 
     *
     */
    public function controlNivelesStock()
    {
		return $this->createQuery('p')
					->innerJoin('p.marca m')
					->innerJoin('p.productoItem pi')
					->innerJoin('pi.productoTalle t')
					->innerJoin('pi.productoColor c')
					->orderBy( 'm.nombre ASC' )
					->where('p.id_marca = ?', 2)
					->execute();
    }
    
	/**
	* Retorna la cantidad vendida (con o sin pago realizado) durante el dia en curso.
	* 
	* @param int $idProducto
	* 
	* @return int
	*/
    public function getVendidosHoy($idProducto)
    {
		return $this->createQuery('p')
					->select('sum(ppi.cantidad)')
					->innerJoin('p.productoItem pi')
					->innerJoin('pi.pedidoProductoItem ppi')
					->innerJoin('ppi.pedido ped')
					->addWhere('DATE_FORMAT(ped.fecha_alta, \'%Y-%m-%d\')  = DATE_FORMAT(now(), \'%Y-%m-%d\')')
					->addWhere('ped.fecha_baja IS NULL')
					->addWhere('p.id_producto = ?', $idProducto)
					->fetchOne( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }
        
    /**
     * Retorna el listado de productos vendidos en una campaña
     *
     * @param int $idEshop
     * @param int $idCampana
     *
     * @return Doctrine_Collection
     */
    public function listVendidosEnCampana($idEshop, $idMarca, $idCampana)
    {
    	 $q = $this->createQuery('p')
        	       ->select('p.*')
        	       ->innerJoin('p.productoItem pi')
        	       ->innerJoin('pi.pedidoProductoItem ppi')
        	       ->innerJoin('ppi.pedidoProductoItemCampana ppic')
        	       ->innerJoin('ppi.pedido pe')
        	       ->addWhere('ppic.id_campana = ?', $idCampana);
    	
      if ( $idMarca ) {
          $q->addWhere('p.id_marca = ?', $idMarca);
      }

    	if ( $idEshop ) {
    	    $q->addwhere('pe.id_eshop = ?', $idEshop );
    	} else {
    	    $q->addwhere('pe.id_eshop IS NULL');
    	}
    	
	    return $q->orderBy('p.denominacion ASC')
	    	     ->execute();
    }
    
    /**
     * Retorna el listado de productos vendidos como stock permanente
     *
     * @param int $idEshop
     * @param bool $esOutlet
     *
     * @return Doctrine_Collection
     */
    public function listVendidosEnStockPermanente($idEshop, $idMarca, $esOutlet)
    {
        $origen = ( $esOutlet ) ? producto::ORIGEN_OUTLET : producto::ORIGEN_STOCK_PERMANENTE;
        
        $q = $this->createQuery('p')
                  ->select('p.*')
                  ->innerJoin('p.productoItem pi')
                  ->innerJoin('pi.pedidoProductoItem ppi')
                  ->leftJoin('ppi.pedidoProductoItemCampana ppic')
                  ->innerJoin('ppi.pedido pe')
                  ->addWhere('ppic.id_campana IS NULL')
                  ->addWhere('ppi.origen = ?', $origen);

        if ( $idMarca ) {
            $q->addWhere('p.id_marca = ?', $idMarca);
        }
        
        if ( $idEshop ) {
            $q->addwhere('pe.id_eshop = ?', $idEshop );
        } else {
            $q->addwhere('pe.id_eshop IS NULL');
        }
        
	    return $q->orderBy('p.denominacion ASC')
	    	     ->execute();
    }
    
    /**
     * Retorna el listado de productos para onSale
     *
     * @return Doctrine_Collection
     */
    public function queryOutlet( $page = 1, $filtros = array() )
    {                
        $q = $this  ->createQuery('p')
                    ->select('p.id_producto, p.denominacion, p.precio_lista, p.precio_deluxe, p.mostrar_precio_lista')
                    ->addSelect('pcat.*, m.nombre');
        
        $q->addSelect('SUM(pi.stock)  as stock_calculado');
        
        $q->addSelect('COALESCE( SUM( cpi.cantidad ), 0 ) as cantidad_en_carrito_calculado');
        
        
        $subQ = $q  ->createSubquery()
        ->select('s1_pi.id_producto_imagen')
        ->from('productoImagen s1_pi')
        ->addWhere('s1_pi.id_producto = p.id_producto')
        ->orderBy('s1_pi.orden')
        ->limit(1);
        
        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );

        $subQ = $q->createSubquery()
                  ->select('s2_pi.id_producto_imagen')
                  ->from('productoImagen s2_pi')
                  ->addWhere('s2_pi.id_producto = p.id_producto')
                  ->orderBy('s2_pi.orden DESC')
                  ->limit(1);

        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_hover_calculado');
        

        $response = $this->whereFilter($q, $filtros);
        
        $q = $response['query'];
        $cacheFilters = $response['cacheKey'];
        
        $q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("producto_queryOutlet_" . $cacheFilters . "_" . $page) );
        
        return $q;
    }
    
    
    /**
     * Actualiza el precio Deluxe en la base de datos segun el origen actual del producto.
     *
     *@param producto $producto
     * 
     */
    public function updatePrecioDeluxe($producto)
    {    
        $precioDeluxe = ($producto->getOrigen() != producto::ORIGEN_OUTLET) ? $producto->getPrecioNormal() : $producto->getPrecioOutlet();
        $producto->setPrecioDeluxe( $precioDeluxe );
        
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("UPDATE producto SET precio_deluxe = ? WHERE id_producto = ?;", array($precioDeluxe, $producto->getIdProducto() ));
    }
    
    /**
     * Retorna las ventas totales del producto (si esta asignado a un campaña, solo en la campaña asignada sino de la historia completa )
     *
     *@param int $idProducto
     *
     */
    public function getVentasTotales($producto)
    {
        
        $campana = $producto->getCampana();
        
        if ( $campana )
        {
            return $this->createQuery('p')
                        ->select('COALESCE(SUM(ppi.cantidad),0)')
                        ->innerJoin('p.productoItem pi')
                        ->innerJoin('pi.pedidoProductoItem ppi')
                        ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                        ->innerJoin('ppi.pedido ped')
                        ->addWhere('ped.fecha_pago IS NOT NULL')
                        ->addWhere('ped.fecha_baja IS NULL')
                        ->addWhere('p.id_producto = ?', $producto->getIdProducto() )
                        ->addWhere('ppic.id_campana = ?', $campana->getIdCampana() )
                        ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
        }
        else
        {
            return $this->createQuery('p')
                        ->select('COALESCE(SUM(ppi.cantidad),0)')
                        ->innerJoin('p.productoItem pi')
                        ->innerJoin('pi.pedidoProductoItem ppi')
                        ->innerJoin('ppi.pedido ped')
                        ->addWhere('ped.fecha_pago IS NOT NULL')
                        ->addWhere('ped.fecha_baja IS NULL')
                        ->addWhere('p.id_producto = ?', $producto->getIdProducto() )
                        ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
        }
    }
    
    
    /**
     * Retorna la estadistica de productos en lista de espera
     *
     * @return array
     */
    public function queryWaitingListStatics($params)
    {
        $q = $this  ->createQuery('p')
                    ->select('p.*')
                    ->addSelect('sum(w.cantidad) AS get cant_waiting_list')
                    ->innerJoin('p.productoItem pi')
                    ->innerJoin('pi.waitingList w')
                    ->groupBy('p.id_producto')
                    ->orderBy('sum(w.cantidad) DESC');
    
        if ( isset( $params['marca'] ) && $params['marca'] )
        {
            $q->innerJoin('p.marca m');
            $q->addWhere('m.id_marca = ?', $params['marca'] );
        }
    
        if ( isset( $params['stock_campana'] ) && $params['stock_campana'] )
        {
            $stockCampana = $params['stock_campana'];
    
            $idCampana = ($stockCampana == 'STKPER')? null : $stockCampana;
    
            if ( $idCampana )
            {
                $q->innerJoin( 'p.productoCampana pc');
                $q->addWhere( 'pc.id_campana = ?', $idCampana );
            }
            else
            {
                $q->leftJoin( 'p.productoCampana pc');
                $q->addWhere( 'pc.id_campana IS NULL ' );
            }
        }
    
        if ( isset( $params['productos_activos'] ) && $params['productos_activos'] <> '' )
        {
            $q->addWhere('p.activo = ?', $params['productos_activos'] );
        }
    
        return $q;
    }
    
    /**
     * Retorna el listado de productos para el asignador de productos en backend
     *
     * @param number $idMarca
     *
     * @return Doctrine_Collection
     */
    public function listForProductAssign($idMarca, $idCampana, $activo, $idProductoCategoria, $idEshop)
    {
        $q = $this->createQuery('p')
                  ->select('p.*, pc.*, pg.*')
                  ->innerJoin('p.productoCategoria pc')
                  ->innerJoin('pc.productoGenero pg');

        
        if ($idMarca)
        {
            $q->addWhere('p.id_marca = ?', $idMarca);
        }


        if ($idEshop)
        {
            if ( $idEshop == eshop::ESHOP_DELUXE ) {
              $q->addWhere('p.id_eshop IS NULL');  
            } else {
              $q->addWhere('p.id_eshop = ?', $idEshop);
            }
            
        }
        
        if ($idCampana)
        {
            $q->leftJoin('p.productoCampana pcam');
            
            if ($idCampana == 'STKPER')
            {
                $q->addWhere( 'pcam.id_campana IS NULL' );
            }   
            else
            {
                $q->addWhere('pcam.id_campana = ?', $idCampana);
            } 
        }

        
        if ( $activo != '' )
        {
            $q->addWhere('p.activo = ?', $activo);
        }
        
        if ( $idProductoCategoria )
        {
            $q->addWhere('p.id_producto_categoria = ?', $idProductoCategoria);
        }
                  
        return $q->execute();
    }    
    
    /**
     * Retorna el mayor descuento de la campaña
     *
     * @param int $idCampana
     *
     * @return int
     */
    public function getMaxDiscountPercentage($idCampana)
    {
        $percentage = $this->createQuery('p')
                           ->select('max(1-(precio_deluxe/precio_lista))')
                           ->innerJoin('p.productoCampana pc')
                           ->addWhere('p.activo = true')
                           ->addWhere('pc.id_campana = ?', $idCampana)
                           ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
       
        
        $percentage = floor($percentage * 100);
         
        return ($percentage % 5 === 0) ? $percentage : $percentage - ( $percentage % 5 );
    }
    
    /**
     * Retorna el menor precio de la campaña
     *
     * @param int $idCampana
     *
     * @return int
     */
    public function getMinPrice($idCampana)
    {
        return $this->createQuery('p')
                    ->select('min(p.precio_deluxe)')
                    ->innerJoin('p.productoCampana pc')
                    ->addWhere('p.activo = true')
                    ->addWhere('pc.id_campana = ?', $idCampana)
                    ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }
    
    /**
     * Retorna el listado de productos destacados en Home para un $idEshop
     *
     * @param int $idEshop
     *
     * @return Doctrine_Collection
     */
    public function listDestacadosEnHomeByIdEshop( $idEshop )
    {
        $query = $this->createQuery('p')
                      ->select('p.*, pcat.*')
                      ->innerJoin('p.productoCategoria pcat')
                      ->innerJoin('p.productoItem pi')
                      ->leftJoin('p.productoSticker ps')
                      ->addwhere('p.activo = ?', true)
                      ->addwhere('p.id_eshop = ?', $idEshop)
                      ->addwhere('p.destacar = ?', producto::DESTACAR_HOME_ESHOP )
                      ->having('SUM(pi.stock) > 0');
        
        
        $subQ  = $query->createSubquery()
                       ->select('s1_pi.id_producto_imagen')
                       ->from('productoImagen s1_pi')
                       ->addWhere('s1_pi.id_producto = p.id_producto')
                       ->orderBy('s1_pi.orden')
                       ->limit(1);
    
        $query->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );

        $subQ = $query->createSubquery()
                  ->select('s2_pi.id_producto_imagen')
                  ->from('productoImagen s2_pi')
                  ->addWhere('s2_pi.id_producto = p.id_producto')
                  ->orderBy('s2_pi.orden DESC')
                  ->limit(1);

        $query->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_hover_calculado');

        $query->groupBy('p.id_producto, pi.codigo, p.denominacion, p.descripcion, p.info_adicional, p.id_marca, p.id_producto_categoria, p.fecha_modificacion, p.precio_lista, p.mostrar_precio_lista, p.precio_deluxe, p.costo, p.peso, p.destacar, p.activo, p.vendidos, p.visitas, p.id_producto_sticker');
        $query->orderBy('p.precio_deluxe ASC');
        
        $query->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("listDestacadosEnHomeByIdEshop_" . $idEshop ) );

        return $query->execute();
    }

    /**
     * Retorna el listado de productos de campañas que
     * finalizan en la fecha enviada por parametro
     *
     * @param string $fecha
     *
     * @return Doctrine_Collection
     */
    public function listByCampanaFinalizada($fecha)
    {
        return $this->createQuery('p')
                    ->select('p.*')
                    ->innerJoin('p.productoCampanaFinalizada pcf')
                    ->addWhere('date(pcf.fecha) = ?', $fecha)
                    ->execute();
    }

    
    /**
     * Update del ordenEshop de un producto 
     *
     * @param $idProducto
     * @param $orden
     *
     */
    public function updateOrdenEshop($idProducto, $ordenEshop)
    {
      $this->createQuery('p')
           ->update()
           ->set('orden_eshop', $ordenEshop)
           ->addwhere('p.id_producto = ?', $idProducto)  
           ->execute();
    }

    public function listForRemarkety($desde, $hasta, $limit, $page){
        
        $q = $this->createQuery('p')
                  ->select('p.id_producto, p.fecha_modificacion, p.denominacion, m.nombre, pcat.denominacion, pg.denominacion');

        $subQ = $q->createSubquery()
                  ->select('s1_pi.id_producto_imagen')
                  ->from('productoImagen s1_pi')
                  ->addWhere('s1_pi.id_producto = p.id_producto')
                  ->orderBy('s1_pi.orden')
                  ->limit(1);

        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado' );

        $q->innerJoin('p.productoCategoria pcat')
          ->innerJoin('pcat.productoGenero pg')
          ->innerJoin('p.marca m');

        $q->addWhere('p.activo = ?', true);
        $q->addWhere('p.id_eshop IS NULL');

        if ( $desde ) {
          $q->addWhere('p.fecha_modificacion >= ?', $desde);  
        }
        
        if ( $hasta ) {
          $q->addWhere('p.fecha_modificacion <= ?', $hasta);
        }

        $q->orderBy('p.fecha_modificacion asc');

      return $q->limit($limit)
               ->offset($limit * $page)
               ->execute();
    }

    public function countForRemarkety($desde, $hasta) {

        $q = $this->createQuery('p')
                  ->addWhere('p.activo = ?', true)
                  ->addWhere('p.id_eshop IS NULL');

        if ( $desde ) {
          $q->addWhere('p.fecha_modificacion >= ?', $desde);  
        }
        
        if ( $hasta ) {
          $q->addWhere('p.fecha_modificacion <= ?', $hasta);
        }

      return $q->count();
    }
    
}