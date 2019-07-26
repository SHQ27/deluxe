<?php

class Net_Gearman_Job_ProductosSetCategoriaMLWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {                    
        $this->log('--- Comienzo de ejecucion: "ProductosSetCategoriaMLWorker"');

        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        $idCategoriaML = $arg['idCategoriaML'];
        $data = $arg['data'];
                
        $response = array();
        foreach ($data as $idProductoItem => $row)
        {
            $dataMercadoLibre = json_decode($row, true);
            ksort( $dataMercadoLibre );
            $dataMercadoLibre = json_encode( $dataMercadoLibre );
            	
            $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );
            $producto = $productoItem->getProducto();
        
            $producto->setIdCategoriaMl($idCategoriaML);
            $producto->save();
        
            $productoItem->setDataMercadoLibre( $dataMercadoLibre );
            $productoItem->save();
            
            $response[] = array(
                'id_producto' => $producto->getIdProducto(),
                'imagen' => imageHelper::getInstance()->getUrl('producto_lista_chica', $producto),
                'codigo' => $productoItem->getCodigo(),
                'denominacion' => $producto->getDenominacion(),
                'marca' => $producto->getMarca()->getNombre(),
                'talle' => $productoItem->getProductoTalle()->getDenominacion(),
                'color' => $productoItem->getProductoColor()->getDenominacion(),
            );
            
        }
                       
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_SET_CATEGORIA_ML );
        $notificacionBackend->setResponse( json_encode( $response ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
        
        $this->log('--- Fin de ejecucion: "ProductosSetCategoriaMLWorker"');
    }
    
    
}