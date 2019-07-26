<?php


class talleSetTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de talleSetTable;
     *
     * @return talleSetTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('talleSet');
    }
    
    /**
     * Retorna un producto a partir de su id
     *
     * @param integer $idMarca
     * @param string $denominacion
     *
     * @return talleSet
     */
    public function getByCompoundKey($idMarca, $denominacion)
    {
        return $this->createQuery('ts')
        ->addWhere('ts.id_marca  = ?', $idMarca)
        ->addWhere('LOWER(ts.denominacion) = LOWER(?)', $denominacion)
        ->fetchOne();
    }
    
    /**
     * Retorna todos los talleSet de una marca
     *
     * @param integer $idMarca
     *
     * @return talleSet
     */
    public function listByIdMarca($idMarca)
    {
        return $this->createQuery('ts')
                     ->select('ts.id_talle_set, ts.denominacion')
                     ->addWhere('ts.id_marca  = ?', $idMarca)
                     ->execute();
    }
    
}