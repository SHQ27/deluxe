<?php


class provinciaTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de provinciaTable;
	* 
	* @return provinciaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('provincia');
    }
    
	/**
	* Retorna una provincia por su id
	* 
	* @param integer $idProvincia
	* 
	* @return marca
	*/
    public function getById($idProvincia)
    {
		return $this->createQuery('p')
	                ->addWhere('p.id_provincia = ?', $idProvincia )
	                ->useResultCache(true, null, cacheHelper::getInstance()->genKey("provincia_getById_" . $idProvincia) )
	                ->fetchOne();
    }

	/**
	* Retorna todas las provincias
	*  
	* @return Doctrine_Collection
	*/
	public function listAll()
	{    	
    	return $this->createQuery('p')
					->addWhere('p.activa = true')
					->orderBy('p.nombre ASC')
					->useResultCache(true, null, cacheHelper::getInstance()->genKey('provincia_listAll') )
					->execute();
	}
    /**
     * 
     * @return provincia
     */
    public function getProvinciaDefault()
    {
    	return $this->createQuery('p')
					->addWhere('p.activa = true')
					->orderBy('p.nombre ASC')
					->useResultCache(true, null, cacheHelper::getInstance()->genKey('provincia_getProvinciaDefault') )
					->fetchOne();
    }
}