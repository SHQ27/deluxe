<?php


class familiaColorTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('familiaColor');
    }

	public function filter($filters = array())
	{
        $cache = array();
        $esOutlet = (isset( $filters['esOutlet'] ) && $filters['esOutlet'] === true );
        $cache['esOutlet'] = ( $esOutlet ) ? 1 : 0;
	    
		$q =   $this->createQuery('fc')
					->select('fc.id_familia_color, fc.denominacion as color')
					->innerJoin('fc.productoColor pcol')
					->innerJoin('pcol.productoItem pi')
					->innerJoin('pi.producto p')
					->innerJoin('p.productoCategoria pct')
					->leftJoin('p.productoCampana pc')
					->leftJoin('pc.campana c')
					->addwhere('p.activo = ?', true)
					->addWhere('p.es_outlet = ?', $esOutlet)
					->addWhere('(c.id_campana is null) or (c.fecha_inicio < NOW() AND NOW() < c.fecha_fin and c.activo)')
					->groupBy('pcol.id_familia_color, fc.denominacion')
					->orderBy('pcol.id_familia_color ASC, pcol.denominacion ASC');
		
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
    	    $q->addWhere('pc.id_campana IS NULL');
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
		
		$q->useResultCache(true, null, sfConfig::get('app_cache_listadosPrefix') . cacheHelper::getInstance()->genKey("familiaColor_filter_" . implode("_", $cache)) );
		
		return $q->execute();
	}
}