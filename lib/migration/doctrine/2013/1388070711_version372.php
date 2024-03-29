<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version372 extends Doctrine_Migration_Base
{
    public function up()
    {
        $faltantes = faltanteTable::getInstance()->createQuery('f')->addWhere('f.fecha_procesado IS NOT NULL')->execute();
                
        foreach( $faltantes as $faltante )
        {
            $pedido = $faltante->getPedido();
            $productoItem = $faltante->getProductoItem();
            $pedidoProductoItem = pedidoProductoItemTable::getInstance()->getByCompoundKey($pedido->getIdPedido(), $productoItem->getIdProductoItem() );
            
            $valorProducto = $pedidoProductoItem->getPrecioDeluxe() * $faltante->getCantidad();
            
            $pedidoDescuento =  pedidoDescuentoTable::getInstance()->getByIdPedido( $pedido->getIdPedido() );
            
            $montoDescuento = 0;
            if ( $pedidoDescuento && $pedidoDescuento->getIdTipoDescuento() != tipoDescuento::FREESHIPPING )
            {
                $montoDescuento = $valorProducto * ($pedido->getMontoDescuento() / $pedido->getMontoProductos() );
            }
            
            $valor = $valorProducto - $montoDescuento;
    
            if ( count( $pedido->getPedidoProductoItem() ) == 1 && $pedidoProductoItem->getCantidad() == $faltante->getCantidad() )
            {
                $valor += $pedido->getMontoEnvio();
            }
                                    
            $faltante->setMontoDevuelto( $valor );
            $faltante->save();
        }
    }

    public function down()
    {
    }
}