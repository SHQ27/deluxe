<?php


class productoTagTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoTagTable;
	* 
	* @return productoTagTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoTag');
    }
    
    
	/**
	* Elimina todos los tags asociados a un producto
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
	* Elimina todos los tags asociados a un tags
	* 
	* @param integer $idProducto
	* 
	*/
	public function deleteByIdTag( $idTag )
	{
		$this->createQuery('t')
					->delete()
    			    ->addWhere('t.id_tag= ?', array( $idTag ) )
    			    ->execute();
	}
	
	/**
	* Retorna todos los tags asociados a un producto
	* 
	* @param integer $idProducto
	*
	* @return Doctrine_Collection
	*/
	public function tagsByIdProducto( $idProducto )
	{
		return $this->createQuery('pt')
		             ->select('pt.*, t.*')
		             ->innerJoin('pt.tag t')
    			     ->addWhere('pt.id_producto= ?', array( $idProducto ) )
				     ->execute();
	}
	
	/**
	* Procesa y guarda un string de tags separados por coma asignandolos a un producto
	* 
	* @param string $tags
	* @param integer $idProducto
	*
	* @return Doctrine_Collection
	*/
	public function addTagsByIdProducto( $idProducto, $tags )
	{
	  	$tags = explode(',', $tags);
	  	
	  	$aux = array();
	  	foreach ($tags as $denominacion) if (trim($denominacion)) $aux[trim($denominacion)] = null;
	  	$tags = array_keys($aux);	  	
	  	
	  	foreach( $tags as $denominacion )
	  	{
			$tag = tagTable::getInstance()->getTag($denominacion);
					
	  		$productoTag = new productoTag();
	  		$productoTag->setIdProducto( $idProducto );
	  		$productoTag->setIdTag( $tag->getIdTag() );
	  		$productoTag->save();
	  	}
	}
	
	/**
	* Retorna un objeto productoTag para ser eliminado 
	* 
	* @param number $idProducto
	* @param number $idTag
	* 
	* @return productoTag
	*/
    public function getOne($idProducto, $idTag)
    {    
		return $this->createQuery('pt')
				    ->addwhere('pt.id_producto = ?', $idProducto)  
				    ->addwhere('pt.id_tag = ?', $idTag)
					->fetchOne();
    }

	
	
}