<?php


class pedidoDescuentoTable extends Doctrine_Table
{
    
    /**
     * Retorna una instancia de pedidoDescuentoTable;
     *
     * @return pedidoDescuentoTable
     */
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('pedidoDescuento');
    }
    
    public function listIdsDescuentos()
    {
        return $this   ->createQuery('pd')
                        ->select('pd.id_descuento')
                        ->distinct()
                        ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }
    
    /**
     * Retorna un pedidoDescuento a partir de un idPedido
     *
     * @param integer $idPedido
     *
     * @return pedidoDescuento
     */
    public function getByIdPedido( $idPedido )
    {
        return $this->createQuery('pd')
                    ->addWhere('pd.id_pedido = ?', $idPedido )
                    ->fetchOne();
    }

    /**
     * Retorna la cantidad de descuentos utilizados para un idDescuento
     *
     * @param integer $idDescuento
     *
     * @return integer
     */
    public function contarUtilizados( $idDescuento )
    {
        return $this->createQuery('pd')
                    ->innerJoin('pd.pedido p')
                    ->addWhere('pd.id_descuento = ?', $idDescuento )
                    ->addWhere('p.fecha_baja is null')
                    ->count();
    }
    
}