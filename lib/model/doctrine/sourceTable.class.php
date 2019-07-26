<?php


class sourceTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de sourceTable;
     *
     * @return sourceTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('source');
    }
    

    public function listAllKeys()
    {
        return $this->createQuery('s')
        ->select('s.codigo, s.denominacion')
        ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
    }
    
    public function getDenominacionByCodigo($codigo)
    {
        return $this->createQuery('s')
        ->select('s.denominacion')
        ->addWhere('s.codigo = ?', $codigo)
        ->execute( array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR );
    }
    
}