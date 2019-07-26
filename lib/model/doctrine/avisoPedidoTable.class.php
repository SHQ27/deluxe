<?php


class avisoPedidoTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de avisoPedidoTable;
	* 
	* @return avisoPedidoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('avisoPedido');
    }
    
	/**
	* Retorna un avisoPedido a partir de su hash
	* 
	* @param string $hash
	* 
	* @return avisoPedido
	*/
    public function getByHash($hash)
    {
    	return $this->createQuery('ap')
						->addWhere('ap.hash = ?', $hash)
						->fetchOne();
    }
        
}