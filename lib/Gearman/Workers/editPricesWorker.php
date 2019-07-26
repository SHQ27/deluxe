<?php

class Net_Gearman_Job_EditPricesWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        $values = $arg['values'];
        
        $ids = $values['ids'];
        $productos = productoTable::getInstance()->listByIdProductos( $ids );
        
        foreach ($productos as $producto)
        {
            $precioLista	= $values['precio_lista_' . $producto->getIdProducto()];
            $precioNormal	= $values['precio_normal_' . $producto->getIdProducto()];
            $precioOutlet	= $values['precio_outlet_' . $producto->getIdProducto()];
            $costo		= $values['costo_' . $producto->getIdProducto()];
        
            $producto->setPrecioLista( $precioLista );
            $producto->setPrecioNormal( $precioNormal );
            $producto->setPrecioOutlet( $precioOutlet );
            $precioDeluxe = ($producto->getOrigen() != producto::ORIGEN_OUTLET) ? $producto->getPrecioNormal() : $producto->getPrecioOutlet();
            $producto->setPrecioDeluxe( $precioDeluxe );
            $producto->setCosto( $costo );
            
            $producto->doNotPostActions( array( 
                producto::POST_ACTION_UPDATE_STOCK,
                producto::POST_ACTION_CERRAR_PUBLICACION_ML
            ) );
            
            $producto->save();
        }
                
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_EDITAR_PRECIOS );
        $notificacionBackend->setResponse( json_encode( $ids ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
    }

}