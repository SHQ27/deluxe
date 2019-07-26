<?php

class Net_Gearman_Job_ProductosPublicarMLWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {                    
        $this->log('--- Comienzo de ejecucion: "ProductosPublicarMLWorker"');

        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        $ids = $arg['ids'];
                
        $productos = productoTable::getInstance()->listByIdProductos( $ids );
         
        $result = array();
        foreach( $productos as $producto )
        {
            $response = MercadoLibre::getInstance()->publicar($producto);
                        
            if ( $response !== false )
            {
                $result[$producto->getIdProducto()] = $response;
            }            
        }
        
        $response = array('ids' => $ids, 'result' => $result);
                       
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_PUBLICAR_ML );
        $notificacionBackend->setResponse( json_encode( $response ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
        
        $this->log('--- Fin de ejecucion: "ProductosPublicarMLWorker"');
    }
    
    
}