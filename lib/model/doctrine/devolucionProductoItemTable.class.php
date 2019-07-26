<?php


class devolucionProductoItemTable extends Doctrine_Table
{
    
    /**
     * Retorna una instancia de devolucionProductoItemTable;
     *
     * @return devolucionProductoItemTable
     */
    public static function getInstance()
    {
    	return Doctrine_Core::getTable('devolucionProductoItem');
    }
    
    /**
     * Retorna una devolucionProductoItem por su clave compuesta
     *
     * @param integer $idDevolucion
     * @param integer $idPedidoProductoItem
     * 
     *
     * @return devolucionProductoItem
     */
    public function getByCompoundKey( $idDevolucion, $idPedidoProductoItem)
    {
        return $this->createQuery('dpi')
        ->addWhere('dpi.id_devolucion = ?', array( $idDevolucion ) )
        ->addWhere('dpi.id_pedido_producto_item = ?', array( $idPedidoProductoItem ) )
        ->fetchOne();
    }
    
    
    /**
     * Retorna el peso total de todos los productos de una devolucion
     *
     * @param integer $idDevolucion
     *
     * @return float
     */
    public function getPesoByIdDevolucion( $idDevolucion )
    {
    	return (float)$this->createQuery('dpi')
    	->select( 'sum(dpi.cantidad * p.peso)' )
    	->innerJoin('dpi.pedidoProductoItem ppi ')
    	->innerJoin('ppi.productoItem pi ')    	
    	->innerJoin('pi.producto p')
    	->addWhere('dpi.id_devolucion = ?', array( $idDevolucion ) )
    	->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
    }
    
    /**
     * Dado un productoItem devuelve su cantidad en el historico de devoluciones
     *
     * @param integer $idProductoItem
     *
     * @return producto
     */
    public function getCantidadByIdProductoItem($idProductoItem)
    {
    	return (int) $this->createQuery('dpi')
    	->select('SUM(dpi.cantidad)')
    	->innerJoin('dpi.pedidoProductoItem ppi ')
    	->innerJoin('dpi.devolucion d')
    	->addWhere('ppi.id_producto_item  = ?', $idProductoItem)
    	->addWhere('d.fecha_recibido IS NOT NULL')
    	->fetchOne( array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR );
    }
        
    /**
     * Elimina todos los devolucionProductoItem asociados a una devolucion
     *
     * @param number $idDevolucion
     *
     */
    public function deleteByIdDevolucion($idDevolucion)
    {
        $this->createQuery('dpi')
        ->delete()
        ->addwhere('dpi.id_devolucion = ?', $idDevolucion)
        ->execute();
    }

    /**
     * Lista todos los devolucionProductoItem asociados a un pedido
     *
     * @param number $idPedido
     *
     * @return Doctrine_Collection
     */
    public function listByIdPedido($idPedido)
    {
        return $this->createQuery('dpi')
                    ->innerJoin('dpi.pedidoProductoItem ppi')
                    ->innerJoin('ppi.productoItem pi')
                    ->innerJoin('pi.productoTalle pt')
                    ->innerJoin('pi.productoColor pc')
                    ->innerJoin('pi.producto p')
                    ->innerJoin('dpi.devolucion d')
                    ->addwhere('ppi.id_pedido = ?', $idPedido)
                    ->execute();
    }
    
}