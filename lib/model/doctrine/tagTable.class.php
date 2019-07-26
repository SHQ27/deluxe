<?php


class tagTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de tagTable;
	* 
	* @return tagTable
	*/
	public static function getInstance()
    {
        return Doctrine_Core::getTable('tag');
    }
    
	/**
	* Retorna un tag. Si no existe lo crea.
	* 
	* @param string  $denominacion
	* 
	* @return Doctrine_Collection
	*/
	public function getTag($denominacion)
	{
		$denominacion = trim($denominacion);
		
		$tag =  $this->createQuery('t')
	    			    ->addWhere('t.denominacion = ?', array( $denominacion ))
	    			    ->fetchOne();
	    			    
		if (!$tag && $denominacion)
		{
			$tag = new tag();
			$tag->setDenominacion( $denominacion );
			$tag->save();
		}
		
		return $tag;
	}
	
	/**
	* Busca los tags que empiezan con $term
	* 
	* @param string  $term
	* 
	* @return Doctrine_Collection
	*/
	public function startWith($term)
	{		
		return $this->createQuery('t')
	    		     ->addWhere('t.denominacion like ?', array( "$term%" ))
	    			 ->execute();
	}
	
	/**
	* Pasa una coleccion de tags a string 
	* 
	* @param Doctrine_Collection  $tags
	* 
	* @return string
	*/
	public function toString($tags)
	{
		$arr = array();
		foreach ($tags as $tag)
		{
			$arr[] = $tag->getTag()->getDenominacion();
		}
		return implode(', ', $arr);
	}
	
	
	/**
	* Retorna todos los tags dentro de productos en el carrito
	* 
	* @return Doctrine_Collection
	*/
	public function listTagsRelates($idSession)
	{
		return $this->createQuery('t')
					->select('t.id_tag, t.denominacion')
				    ->leftJoin('t.productoTag pt')
				    ->leftJoin('pt.producto p')
				    ->leftJoin('p.productoItem pi')
				    ->leftJoin('pi.carritoProductoItem cpi')
				    ->addWhere('cpi.id_session = ?', array( $idSession ))
				    ->execute();
	}
    
}