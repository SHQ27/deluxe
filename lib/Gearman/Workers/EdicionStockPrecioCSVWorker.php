<?php

class Net_Gearman_Job_EdicionStockPrecioCSVWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {                    
        $this->log('--- Comienzo de ejecucion: "EdicionStockPrecioCSVWorker"');
        
        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        // Recupero el path del csv
        $csv = $arg['csv'];    
    
        // Inicializo las variables de resultado
        $errores = array();
        $dataRaw = array();
        
        // Proceso el CSV
        $file = fopen($csv, "r");
    
        $row = fgetcsv($file, 0, ";");
        
        $columnasEsperadas = 12;
                
        if ( count($row) != $columnasEsperadas )
        {
            $errores[] = 'El formato del CSV es incorrecto (Debe tener exactamente ' . $columnasEsperadas . ' columnas).';
        }
    

        $validaciones = array();
        $validaciones['marcas'] = array();
        $validaciones['talles'] = array();
        $validaciones['colores'] = array();

        $validaciones = array();
        $indices['talles'] = array();
        $indices['colores'] = array();
        $indices['producto'] = array();

        if ( !count($errores) )
        {
            /*
             * LECTURA DEL CSV
             */ 
            while ( ($row = fgetcsv($file, 0, ";")) !== FALSE )
            {                        
                $marcaNombre       = trim($row[0]);
                $idProducto    = trim($row[1]);
                $talleDenominacion = trim($row[3]);
                $colorDenominacion = trim($row[4]);
                
                $precioLista       = trim($row[5]);
                $precio            = trim($row[6]);
                $costo             = trim($row[7]);
                $stockCampana      = trim($row[8]);
                $stockPermanente   = trim($row[9]);
                $stockOutlet       = trim($row[10]);
                $stockRefuerzo     = trim($row[11]);

                $validaciones['marcas'][] = $marcaNombre;
                $validaciones['talles'][] = $talleDenominacion;
                $validaciones['colores'][] = $colorDenominacion;

                if ( !isset( $dataRaw[$marcaNombre] ) ) {
                    $dataRaw[$marcaNombre] = array();
                }

                if ( !isset( $dataRaw[$marcaNombre][$idProducto] ) ) {
                    $dataRaw[$marcaNombre][$idProducto] = array(
                        'precioLista'       => $precioLista,
                        'precio'            => $precio,
                        'costo'             => $costo,
                        'items'             => array(),
                        );
                }

                $dataRaw[$marcaNombre][$idProducto]['items'][] = array(
                    'talleDenominacion' => $talleDenominacion,
                    'colorDenominacion' => $colorDenominacion,
                    'stockCampana'      => $stockCampana,
                    'stockPermanente'   => $stockPermanente,
                    'stockOutlet'       => $stockOutlet,
                    'stockRefuerzo'     => $stockRefuerzo
                    );          
            }

            fclose($file);
        
            /*
             * VALIDACIONES
             */

            // Validacion de Marca
            $indexMarcas = array();
            foreach( $validaciones['marcas'] as $marcaNombre ) {
                $marca = marcaTable::getInstance()->getByNombre( $marcaNombre );
                $indexMarcas[ $marcaNombre ] = $marca;

                if (!$marca) {
                    $errores[] = "La marca \"$marcaNombre\" no existe en DeluxeBuys";
                }
            }

            // Validacion de Talle
            foreach( $validaciones['talles'] as $talleDenominacion ) {
                $talle = productoTalleTable::getInstance()->getByDenominacion($talleDenominacion);
                if (!$talle) {
                    $errores[] = "El talle \"$talleDenominacion\" no existe en DeluxeBuys";
                } else {
                    $indices['talles'][$talleDenominacion] = $talle;
                }
            }   
                                
            // Validacion de Color
            foreach( $validaciones['colores'] as $colorDenominacion ) {
                $color = productoColorTable::getInstance()->getByDenominacion($colorDenominacion);
                if (!$color) {
                    $errores[] = "El color \"$colorDenominacion\" no existe en DeluxeBuys";
                } else {
                    $indices['colores'][$colorDenominacion] = $color;
                }
            }   


            foreach ($dataRaw as $marcaNombre => $row) {
                foreach ($row as $idProducto => $rowProducto) {
                    
                    $marca = $indexMarcas[ $marcaNombre ];

                    // Validacion de ID del producto
                    $producto = productoTable::getInstance()->getByIdAndMarca( $idProducto, $marca->getIdMarca() );
                    if (!$producto ) {
                        $errores[] = "No hay ningun producto de la marca \"$marcaNombre\" con ID \"$idProducto\"";
                    } else {
                        $indices['producto'][$idProducto] = $producto;
                    }

                    // Validacion de Valores
                    if ( !is_numeric( $rowProducto['precioLista'] ) ) {
                        $errores[] = 'El precio de lista "' . $rowProducto['precioLista'] . '" no es un valor númerico';
                    }
                    
                    if ( !is_numeric( $rowProducto['precio'] ) ) {
                        $errores[] = 'El Precio DB "' . $rowProducto['precio'] . '" no es un valor númerico';
                    }
                    
                    if ( !is_numeric( $rowProducto['costo'] ) ) {
                        $errores[] = 'El costo "' . $rowProducto['costo'] . '" no es un valor númerico';
                    }

                    foreach ($rowProducto['items'] as $rowItem) {
                        if ( !is_numeric( $rowItem['stockCampana'] ) ) {
                            $errores[] = 'El stock en campaña "' . $rowItem['stockCampana'] . '" no es un valor númerico';
                        }
                    }
                    foreach ($rowProducto['items'] as $rowItem) {
                        if ( !is_numeric( $rowItem['stockPermanente'] ) ) {
                            $errores[] = 'El stock en permanente "' . $rowItem['stockPermanente'] . '" no es un valor númerico';
                        }
                    }

                    foreach ($rowProducto['items'] as $rowItem) {
                        if ( !is_numeric( $rowItem['stockOutlet'] ) ) {
                            $errores[] = 'El stock en outlet "' . $rowItem['stockOutlet'] . '" no es un valor númerico';
                        }
                    }

                    foreach ($rowProducto['items'] as $rowItem) {
                        if ( !is_numeric( $rowItem['stockRefuerzo'] ) ) {
                            $errores[] = 'El stock de refuerzo "' . $rowItem['stockRefuerzo'] . '" no es un valor númerico';
                        }
                    }

                }
            }
        }
        
        // Si no hubo errores procesa
        if ( !count($errores) )
        {
            $response = array();
            $response['status'] = true;
            $response['idsProducto'] = array();
            
            $conn = Doctrine_Manager::connection();
                            
            try
            {
                $conn->beginTransaction();

                foreach ($dataRaw as $marcaNombre => $row) {
                    foreach ($row as $idProducto => $rowProducto) {
                        $producto = $indices['producto'][$idProducto];
                        $this->updateProducto( $producto, $rowProducto );
                    }
                }

                $conn->commit();

                $conn->beginTransaction();

                foreach ($dataRaw as $marcaNombre => $row) {
                    foreach ($row as $idProducto => $rowProducto) {

                        $producto = $indices['producto'][$idProducto];

                        foreach ($rowProducto['items'] as $rowItem) {

                            $talle = $indices['talles'][ $rowItem['talleDenominacion'] ];
                            $color = $indices['colores'][ $rowItem['colorDenominacion'] ];

                            $this->updateProductoItem($producto, $talle, $color, $rowItem['stockCampana'], $rowItem['stockPermanente'], $rowItem['stockOutlet'], $rowItem['stockRefuerzo'] );
                        }

                        $response['idsProducto'][] = $producto->getIdProducto();

                    }
                }

                $conn->commit();
            }
            catch(Doctrine_Exception $e)
            {
                $conn->rollback();
            }

        }
        else
        {
            $errores = array_unique($errores);            
            $response = array('status' => false, 'errors' => $errores);
        }

                                                                  
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PRODUCTO_EDICION_STOCK_PRECIO_CSV );
        $notificacionBackend->setResponse( json_encode( $response ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
    }

    protected function updateProducto($producto, $rowProducto)
    {
        $producto->setPrecioNormal( $rowProducto['precio'] );
        $producto->setPrecioLista( $rowProducto['precioLista'] );
        $producto->setCosto( $rowProducto['costo'] );
                                        
        $producto->doNotPostActions( array( 
            producto::POST_ACTION_CERRAR_PUBLICACION_ML,
            producto::POST_ACTION_UPDATE_ML
        ) );
        
        $producto->save();
    }

    protected function updateProductoItem($producto, $talle, $color, $stockCampana, $stockPermanente, $stockOutlet, $stockRefuerzo )
    {
        $productoItem = productoItemTable::getInstance()->getByCompoundKey($producto->getIdProducto(), $talle->getIdProductoTalle(), $color->getIdProductoColor() );

        if ( !$productoItem ) {
            $productoItem = new productoItem();
            $productoItem->setIdProducto( $producto->getIdProducto() );
            $productoItem->setIdProductoTalle( $talle->getIdProductoTalle() );
            $productoItem->setIdProductoColor( $color->getIdProductoColor() );
            $productoItem->save();
        }

        $productoItem->remplazarStock($stockCampana, producto::ORIGEN_OFERTA, stockTipo::SISTEMA_CARGA_MASIVA );
        $productoItem->remplazarStock($stockPermanente, producto::ORIGEN_STOCK_PERMANENTE, stockTipo::SISTEMA_CARGA_MASIVA );
        $productoItem->remplazarStock($stockOutlet, producto::ORIGEN_OUTLET, stockTipo::SISTEMA_CARGA_MASIVA );
        $productoItem->remplazarStock($stockRefuerzo, producto::ORIGEN_REFUERZO, stockTipo::SISTEMA_CARGA_MASIVA );
    }
    
}