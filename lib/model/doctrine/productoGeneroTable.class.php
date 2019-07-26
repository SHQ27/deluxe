<?php


class productoGeneroTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoGeneroTable;
	* 
	* @return productoGeneroTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoGenero');
    }
    
	/**
	* Retorna un productoGenero
	* 
	* @return productoGenero
	*/
	public function getByIdProductoGenero($idProductoGenero)
	{
		return $this   ->createQuery('pc')
                        ->where('pc.id_producto_genero = ?', $idProductoGenero)
                        ->useResultCache(true, null, cacheHelper::getInstance()->genKey("productoGenero_getByIdProductoGenero_" . $idProductoGenero) )
                        ->fetchOne();
	}
	
	/**
	* Retorna un productoGenero
	* 
	* @return productoGenero
	*/
	public function getBySlug($slugProductoGenero)
	{
		return $this->createQuery('pc')
					->where('pc.slug = ?', $slugProductoGenero)
					->fetchOne();
	}
    
}