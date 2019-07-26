<?php


class waitingListTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de waitingListTable;
	* 
	* @return waitingListTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('waitingList');
    }
    
    
	/**
	* Retorna todos los registros en la tabla
	*  
	* @return Doctrine_Collection
	*/
    public function listAll()
    {
		return $this->createQuery('w')
						->orderBy('w.id_producto_item')
						->execute();				    
    }
    
    /**
     * Retorna todos los registros de productos activos en la tabla
     *
     * @return Doctrine_Collection
     */
    public function listActivos()
    {
    	return $this->createQuery('w')
    	->innerJoin('w.productoItem pi')
    	->innerJoin('pi.producto p')
    	->addWhere('p.activo = true')
    	->addwhere('p.id_eshop IS NULL')
    	->orderBy('w.id_producto_item')
    	->execute();
    }
    
    
	/**
	* Retorna todos los registros que coincidan con un $idProducto
	*  
	* @return Doctrine_Collection
	*/
    public function listByIdProducto($idProducto)
    {
		return $this->createQuery('w')
						->innerJoin('w.productoItem pi')
						->innerJoin('pi.productoTalle pt')
						->innerJoin('pi.productoColor pc')
						->innerJoin('w.usuario u')
						->where('pi.id_producto = ?', $idProducto)
						->orderBy('w.fecha DESC')
						->execute();
    }

    
	/**
	* Retorna true si el producto esta en lista de espera para el usuario logueado. 
	* 
	* @param integer $idProducto
	* 
	* @return boolean
	*/
	public function isWaiting( $idProducto )
	{
		$usuario = sfContext::getInstance()->getUser()->getCurrentUser();
		
		if (!$usuario) return false;
		
		return (bool) $this->createQuery('w')
					->innerJoin('w.productoItem pi')
    			    ->addWhere('pi.id_producto = ?', array( $idProducto ) )
    			    ->addWhere('w.id_usuario = ?', array( $usuario->getIdUsuario() ) )
    			    ->count();
	}
	
	/**
	 * Retorna todos los registros que coincidan con un $idProducto
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIdProductoItem($idProductoItem)
	{
	    return $this   ->createQuery('w')
                	    ->select('COALESCE( SUM(w.cantidad),0 )')
                	    ->where('w.id_producto_item = ?', $idProductoItem)
                	    ->execute( array(), doctrine::HYDRATE_SINGLE_SCALAR );
	}
	
    

    
}