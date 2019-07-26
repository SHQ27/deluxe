<?php

class Net_Gearman_Job_EditStockWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {           
        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        $values = $arg['values'];
        
        $this->log('--- Comienzo de ejecucion: "EditStockWorker"');
        $this->log( serialize($values) );
        
        $ids = array();
        foreach( $values as $key => $items)
        {
            $idProducto = str_replace('stock_', '', $key);
            $ids[] = $idProducto; 
                    
            $c = count($items['id_producto_item']);
            	
            for( $i = 0 ; $i < $c ; $i++ )
            {
                $id_producto_item = $items['id_producto_item'][$i];
                	
                $cantidadPermanente = $items['cantidad_permanente'][$i];
                $cantidadCampana = $items['cantidad_campana'][$i];
                $cantidadRefuerzo = $items['cantidad_refuerzo'][$i];
                
                $productoItem = productoItemTable::getInstance()->findOneByid_producto_item( $id_producto_item );                                
                $productoItem->remplazarStock($cantidadPermanente, producto::ORIGEN_STOCK_PERMANENTE, stockTipo::SISTEMA_CARGA_MASIVA );
                $productoItem->remplazarStock($cantidadCampana, producto::ORIGEN_OFERTA, stockTipo::SISTEMA_CARGA_MASIVA );
                $productoItem->remplazarStock($cantidadRefuerzo, producto::ORIGEN_REFUERZO, stockTipo::SISTEMA_CARGA_MASIVA );                
            }
        }
                
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_EDITAR_STOCK );
        $notificacionBackend->setResponse( json_encode( $ids ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
        
    }
}