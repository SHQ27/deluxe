<?php


class talleZonaTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de talleZonaTable;
     *
     * @return talleZonaTable
     */    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('talleZona');
    }
        
    /**
     * Retorna el listado ordenado con todos los talleZona
     *
     * @return Doctrine_Collection
     */
    public function listAll()
    {
        return $this->createQuery('tz')
        ->orderBy('tz.denominacion asc')
        ->execute();
    }
    
    /**
     * Retorna un TalleZona a partir de su id
     *
     * @param integer $idTalleZona
     *
     * @return talleZona
     */
    public function getById($idTalleZona)
    {
        return $this->createQuery('tz')
        ->where('tz.id_talle_zona = ?', $idTalleZona)
        ->useResultCache(true, null, cacheHelper::getInstance()->genKey('talleZona_getById_' . $idTalleZona) )
        ->fetchOne();
    }
    
}