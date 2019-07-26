<?php

class Net_Gearman_Job_ProductosSetOutletWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        $idsProductos = $arg['idsProductos'];
        $esOutlet = $arg['esOutlet'];
                
        $productos = productoTable::getInstance()->listByIdProductos( $idsProductos );
        
        $response = array();
        $response['ok'] = 0;
        $response['errores'] = 0;
        $response['detalle'] = array();
        foreach ($productos as $producto)
        {            
            if ( $esOutlet && $producto->getPrecioOutlet() <= 0 ) {
                $response['errores']++;
                $response['detalle'][ $producto->getIdProducto() ] = false;
            } else if ( !$esOutlet && $producto->getPrecioNormal() <= 0 ) {
                $response['detalle'][ $producto->getIdProducto() ] = false;
                $response['errores']++;
            } else {
                $producto->setEsOutlet($esOutlet);
                $producto->save();
                $response['detalle'][ $producto->getIdProducto() ] = true;
                $response['ok']++;
            }
        }
        
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        
        if ( $esOutlet ) {
            $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_SET_OUTLET );
        } else {
            $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_SET_NO_OUTLET );
        }
        
        $notificacionBackend->setResponse( json_encode( $response ) );
        
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
    }

}