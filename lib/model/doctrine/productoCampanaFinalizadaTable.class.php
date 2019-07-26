<?php


class productoCampanaFinalizadaTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de productoCampanaFinalizadaTable;
     *
     * @return productoCampanaFinalizadaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoCampanaFinalizada');
    }
    
	
	/**
	 * Marca como restaurado un objeto productoCampana de la base de datos
	 *
	 * @param number $idProducto
	 * @param number $idCampana
	 *
	 */
	public function updateRestaurada($idProducto, $idCampana)
	{
	    return $this->createQuery('pcf')
            	    ->update()
            	    ->set('fue_restaurada', true)
            	    ->addwhere('pcf.id_producto = ?', $idProducto)
            	    ->addwhere('pcf.id_campana = ?', $idCampana)
            	    ->execute();	    
	}
    
}