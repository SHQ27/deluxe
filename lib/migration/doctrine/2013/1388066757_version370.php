<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version370 extends Doctrine_Migration_Base
{
    public function up()
    {
        $devoluciones = devolucionTable::getInstance()->createQuery('d')->addWhere('d.fecha_cierre IS NOT NULL')->execute();
                
        foreach( $devoluciones as $devolucion )
        {

            $valor = 0;
            
            $devolucionProductoItems = $devolucion->getDevolucionProductoItem();
            foreach($devolucionProductoItems as $devolucionProductoItem)
            {
                $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem();
            
                $valorProducto = $devolucionProductoItem->getCantidad() * $pedidoProductoItem->getPrecioDeluxe();
                        
                $valor += $valorProducto;
            }
            
            $costoEnvio = 0;
            if ($devolucion->getTipoEnvio() == devolucion::envio_oca && !in_array( $devolucion->getIdDevolucionMotivo() , array('INCOR','FALLA')))
            {
                $costoEnvio = costoEnvioTable::getInstance()->search($devolucion->getIdLocalidad(), $devolucion->getPeso(), carritoEnvio::DOMICILIO, false );
            }
            
            $valor = $valor - $costoEnvio;
            $valor = ( $valor > 0 ) ? $valor : 0;
                        
            $devolucion->setMontoTotal( $valor );
            $devolucion->save();
        }
    }

    public function down()
    {
    }
}