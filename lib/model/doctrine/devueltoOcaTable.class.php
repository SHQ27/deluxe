<?php


class devueltoOcaTable extends Doctrine_Table
{
	/**
	 * Retorna una instancia de devueltoOcaTable;
	 *
	 * @return devueltoOcaTable
	 */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('devueltoOca');
    }
    
    /**
     * Marca a todos los idDevueltoOca en el array pasado como parametro como retirado
     *
     * @param integer $idsDevueltoOca
     *
     */
    public function marcarComoRetirados($idsDevueltoOca)
    {
    	return $this->createQuery('do')	
    	->update('devueltoOca')
    	->set('fecha_retirado',  new Doctrine_Expression('now()') )
    	->whereIn('id_devuelto_oca', $idsDevueltoOca)
    	->execute();
    }
    
    public function listByIds($ids)
    {
        return $this->createQuery('do')
        ->whereIn('id_devuelto_oca', $ids)
        ->execute();
    }
    
}