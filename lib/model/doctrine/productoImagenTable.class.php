<?php


class productoImagenTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoImagenTable;
	* 
	* @return productoImagenTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoImagen');
    }
    
 
	/**
	* Elimina todas las imagenes asociadas a un producto
	* 
	* @param integer $idProducto
	* 
	*/
	public function deleteByIdProducto( $idProducto )
	{
		$this->createQuery('t')
					->delete()
    			    ->addWhere('t.id_producto= ?', array( $idProducto ) )
    			    ->execute();
	}    
    
    
	/**
	* Arma el listado para el backend a partir del id_producto pasado por GET 
	* @return Doctrine_Query
	*/
	public function retrieveBackendList(Doctrine_Query $q)
	{    	
		$rootAlias = $q->getRootAlias();		
		$idProducto = sfContext::getInstance()->getRequest()->getParameter("id_producto");
		$q->andWhere('id_producto = ?', array( $idProducto ) );
		$q->orderBy($rootAlias . '.orden ASC' );
		return $q;
	}
	
	
	/**
	* Retorna todos los productoImagen que coinciden con el array de ids enviado por parametro
	*  
	* @return Doctrine_Collection
	*/
	public function listForBatchDelete( $ids )
	{    	
    	return $this->createQuery('pi')
						->whereIn('pi.id_producto_imagen', $ids)
						->execute();
	}
	
	/**
	* Retorna todos los productoImagen de un producto
	*  
	* @return Doctrine_Collection
	*/
	public function listByIdProducto( $idProducto )
	{    	
    	return $this->createQuery('pi')
						->where('pi.id_producto = ?', $idProducto)
						->orderBy('pi.orden ASC' )
						->execute();
	}
	
	/**
	* Retorna el productoImagen con orden mas bajo para un $idProducto
	* 
	* @return productoImagen
	*/
	public function getFirst( $idProducto )
	{    	
    	return $this   ->createQuery('pi')
                        ->where('pi.id_producto = ?', array( $idProducto ) )
                        ->orderBy('pi.orden asc')
                        ->limit(1)
                        ->fetchOne();
	}
	
	/**
	* Retorna el productoImagen con orden mas alto para un $idProducto
	* 
	* @return productoImagen
	*/
	public function getLast( $idProducto )
	{    	
    	return $this->createQuery('pi')
						->where('pi.id_producto = ?', array( $idProducto ) )
						->orderBy('pi.orden desc')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el anterior productoImagen en para un $idProducto y un $orden
	* 
	* @return productoImagen
	*/
	public function getPrev( $idProducto, $orden )
	{    	
    	return $this->createQuery('pi')
						->where('pi.id_producto = ?', array( $idProducto ) )
						->andwhere('pi.orden < ?', array( $orden ) )
						->orderBy('pi.orden desc')
						->limit(1)
						->fetchOne();
	}
	
	/**
	* Retorna el productoImagen con orden mas bajo para un $idProducto
	* 
	* @return productoImagen
	*/
	public function getNext( $idProducto, $orden )
	{    	
    	return $this->createQuery('pi')
						->where('pi.id_producto = ?', array( $idProducto ) )
						->andwhere('pi.orden > ?', array( $orden ) )
						->orderBy('pi.orden asc')
						->limit(1)
						->fetchOne();
	}
    
}