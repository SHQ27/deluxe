<?php


class facturaWsRequestTable extends Doctrine_Table
{
	/**
	* Retorna una instancia de facturaWsRequestTable;
	* 
	* @return facturaWsRequestTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('facturaWsRequest');
    }
    
	/**
	* Retorna la ultima ejecucion de un WS para un $idFactura
	* 
	* @param int  $idFactura
	* 
	* @return facturaWsRequest
	*/
	public function getLastByIdFactura($idFactura)
	{
		return $this->createQuery('fwr')
						->innerJoin('fwr.facturaWsRequestFactura fwrf')
	    			    ->addWhere('fwrf.id_factura = ?', array( $idFactura ))
	    			    ->orderBy('fwr.fecha DESC')
	    			    ->limit(1)
	    			    ->fetchOne();
	}
}