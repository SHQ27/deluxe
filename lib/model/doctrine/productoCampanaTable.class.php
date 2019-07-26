<?php


class productoCampanaTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoCampanaTable;
	* 
	* @return productoCampanaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoCampana');
    }
        
	/**
	* Retorna true si existe alguna campaña asociada al producto
	* 
	* @param int $idProducto
	* 
	* @return boolean
	*/
    public function exist($idProducto)
    {    
		$query = $this->createQuery('pc')
				      ->addwhere('pc.id_producto = ?', $idProducto);
						    
		return (bool) $query->count();
    }
    
	/**
	* Retorna un objeto productoCampana para ser eliminado 
	* 
	* @param int $idProducto
	* @param int $idCampana
	* 
	* @return productoCampana
	*/
    public function getOne($idProducto, $idCampana)
    {    
		return $this->createQuery('pc')
				    ->addwhere('pc.id_producto = ?', $idProducto)  
				    ->addwhere('pc.id_campana = ?', $idCampana)
					->fetchOne();
    }
    
	/**
	* Retorna todos los productoCampana asociados a un producto
	* 
	* @param int $idProducto
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdProducto($idProducto)
    {    
		return $this->createQuery('pc')
				    ->addwhere('pc.id_producto = ?', $idProducto)  
					->execute();
    }
    
    /**
     * Retorna todos los productoCampana de campañas activas asociados a un producto
     *
     * @param int $idProducto
     *
     * @return Doctrine_Collection
     */
    public function listActivasByIdProducto($idProducto)
    {
        return $this->createQuery('pc')
        ->innerJoin('pc.campana c')
        ->addwhere('pc.id_producto = ?', $idProducto)
        ->addwhere('c.activo = ?', true)
        ->execute();
    }
    
	/**
	* Retorna todos los productoCampana asociados a una campaña
	* 
	* @param int $idCampana
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdCampana($idCampana)
    {    
		return $this->createQuery('pc')
				    ->addwhere('pc.id_campana = ?', $idCampana)  
					->execute();
    }
    
    /**
     * Retorna true si algun producto de la marca esta asignado a la campaña
     *
     * @param int $idCampana
     * @param int $idMarca
     *
     * @return bool
     */
    public function existByMarca($idCampana, $idMarca)
    {
        return (bool) $this->createQuery('pc')
                    ->innerJoin('pc.producto p')
                    ->addwhere('pc.id_campana = ?', $idCampana)
                    ->addwhere('p.id_marca = ?', $idMarca)
                    ->count();
    }
    
    /**
     * Elimina todos los productos de una marca, siempre que el id de producto este el array de $idProductos
     *
     * @param int $idCampana
     * @param int $idProductos
     *
     * @return productoCampana
     */
    public function delete($idCampana, $idProductos)
    {
        return $this->createQuery('pc')
                    ->delete()
                    ->addwhere('pc.id_campana = ?', $idCampana)
                    ->andwhereIn('pc.id_producto', $idProductos)
                    ->execute();
    }
    
            
}