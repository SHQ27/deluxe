<?php


class pedidoProductoItemCampanaTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de pedidoProductoItemCampanaTable;
	* 
	* @return pedidoProductoItemCampanaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('pedidoProductoItemCampana');
    }
    
	/**
	* Retorna true si la campaña enviada por parametro esta asociada a algun pedido
	*  
	* @param integer $idCampana
	*  
	* @return bool
	*/
	public function exists( $idCampana )
	{    	
    	return (bool) $this->createQuery('ppic')
						->addWhere('ppic.id_campana = ?', $idCampana)
						->count();
	}
	
}