<?php

class Net_Gearman_Job_ImportarProductoWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        $idUsuario = $arg['idUsuario'];

        $idEshop = $arg['idEshop'];
        $idEshop = ( $idEshop ) ? $idEshop : null;

        $origen = $arg['origen'];
        $idMarca = $arg['idMarca'];
        
        $dataSerializedFilePath = sfConfig::get('sf_temp_dir') . '/importacion/dataSerialized';
        $dataSerialized = file_get_contents( $dataSerializedFilePath );
        $dataProductos = unserialize($dataSerialized);
        
        $this->log('--- Comienzo de ejecucion: "ImportarProductoWorker"');
        
        $conn = Doctrine_Manager::connection();
        
        // Antes de comenzar el proceso se crean todos los tags que no existan
        foreach ($dataProductos as $rowProducto)
        {
            $tagString = $rowProducto['tags'];
            $tags = explode(',', $tagString);

            $aux = array();
            foreach ($tags as $denominacion) if (trim($denominacion)) $aux[trim($denominacion)] = null;
            $tags = array_keys($aux);

            foreach ($tags as $denominacion)
            {
                // Este metodo retorna el tag y si no existe lo crea
                tagTable::getInstance()->getTag($denominacion);
            }
        }

        try
        {
            $conn->beginTransaction();
            
            foreach ($dataProductos as $index => $rowProducto)
            {
                // Guardo el producto
                $producto = new producto();
                $producto->setDenominacion( $rowProducto['denominacion'] );
                $producto->setDescripcion( $rowProducto['descripcion'] );

                $producto->setInfoAdicional( $producto->getDefaultInfoAdicional() );

                $producto->setIdMarca( $idMarca );
                $producto->setIdProductoCategoria( $rowProducto['categoria']->getIdProductoCategoria() );

                $producto->setFechaModificacion( new Doctrine_Expression('now()') );

                $producto->setPrecioLista( $rowProducto['precioLista'] );
                $producto->setMostrarPrecioLista(true);

                $producto->setPrecioNormal( $rowProducto['precioDeluxe'] );
                $producto->setPrecioOutlet( $rowProducto['precioDeluxe'] );
                $producto->setPrecioDeluxe( $rowProducto['precioDeluxe'] );

                $producto->setCosto( $rowProducto['costo'] );
                $producto->setPeso( $rowProducto['peso'] );

                $producto->setDestacar(false);

                $producto->setIdEshop( $idEshop );

                $producto->setActivo(false);

                
                if ( $rowProducto['talleSet'] )
                {
                    $producto->setIdTalleSet( $rowProducto['talleSet']->getIdTalleSet() );
                }

                $producto->doNotPostActions( array( producto::POST_ACTION_UPDATE_ML,
                                                    producto::POST_ACTION_CERRAR_PUBLICACION_ML
                                           ) );
                
                $producto->save();

                // Guardo los tags del producto
                productoTagTable::getInstance()->addTagsByIdProducto( $producto->getIdProducto(), $rowProducto['tags'] );

                // Guardo los productoItems asociados al producto
                foreach ($rowProducto['items'] as $rowProductoItem)
                {
                    $productoItem = new productoItem();
                    $productoItem->setIdProducto( $producto->getIdProducto() );
                    $productoItem->setIdProductoTalle( $rowProductoItem['talle']->getIdProductoTalle() );
                    $productoItem->setIdProductoColor( $rowProductoItem['color']->getIdProductoColor() );

                    $productoItem->setCodigo( $rowProductoItem['codigo'] );
                    $productoItem->save();

                    $productoItem->sumaStock( $rowProductoItem['cantidad'], $origen, stockTipo::SISTEMA_IMPORTACION_INICIAL);
                }
                
                //Guardo las imagenes del producto
                $imagenesDirName = sfConfig::get('sf_temp_dir') . '/importacion/imagenes/' . $index . '/';
                $images = glob("{$imagenesDirName}*.[jJ][pP][gG]");

                $orden = 1;
                foreach ($images as $imagenFilePath)
                {
                    
                    @chmod($imagenFilePath, 0777);
                    
                    $productoImagen = new productoImagen();
                    $productoImagen->setIdProducto( $producto->getIdProducto() );
                    $productoImagen->setOrden( $orden );
                    $productoImagen->save();

                    imageHelper::getInstance()->processSaveFile('producto_lista_chica', $productoImagen, $imagenFilePath );
                    imageHelper::getInstance()->processSaveFile('producto_lista_grande', $productoImagen, $imagenFilePath );
                    imageHelper::getInstance()->processSaveFile('producto_detalle_chica', $productoImagen, $imagenFilePath );
                    imageHelper::getInstance()->processSaveFile('producto_detalle_mediana', $productoImagen, $imagenFilePath );
                    imageHelper::getInstance()->processSaveFile('producto_detalle_grande', $productoImagen, $imagenFilePath );
                    imageHelper::getInstance()->processSaveFile('producto_thumb', $productoImagen, $imagenFilePath );
                    $orden++;
                }
                

            }
            
            $conn->commit();
            $error = false;
        }
        catch(Doctrine_Exception $e)
        {
            $conn->rollback();
            $error = $e->getMessage();
            
            $this->log($error, sfLogger::ERR);
        }
        
        // Borro el archivo de informacion serializada
        @unlink($dataSerializedFilePath);
        
        // La carpeta de imagenes descomprimida
        $imagesTempFolderPath = sfConfig::get('sf_temp_dir') . '/imagenes';
        dirHelper::getInstance()->rrmdir($imagesTempFolderPath);

        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_IMPORTAR );
        $notificacionBackend->setResponse( json_encode( array('error' => $error ) ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();

        $this->log('--- Fin de ejecucion: "ImportarProductoWorker"');

    }
}
