<?php


class remitoPedidoTable extends Doctrine_Table
{
	/**
	 * Retorna una instancia de remitoPedidoTable;
	 *
	 * @return remitoPedidoTable
	 */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('remitoPedido');
    }
    
    /**
     * Retorna todos los remitoPedido asociados a un idRemito
     *
     * @param integer $idRemito
     *
     * @return Doctrine_Collection
     */
    public function listByIdRemito($idRemito)
    {
    	return $this->createQuery('rp')
			    	->addWhere('rp.id_remito= ?', $idRemito)
			    	->execute();
    }
    
    /**
     * Retorna el remitoPedido asociado a un idPedido
     *
     * @param integer $idPedido
     *
     * @return remitoPedido
     */
    public function getByIdPedido($idPedido)
    {
    	return $this->createQuery('rp')
    	->addWhere('rp.id_pedido = ?', $idPedido)
    	->fetchOne();
    }
        
}