<?php

class Net_Gearman_Job_RestaurarCampanaWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {           

        $conn = Doctrine_Manager::connection();
                        
        try
        {
            $conn->beginTransaction();
        
            $idUsuario = $arg['idUsuario'];
            $asignar = $arg['asignar'];
            $stockEn = $arg['stockEn'];
            $restaurarRefuerzo = $arg['restaurarRefuerzo'];
            $idsProductoItems = $arg['idsProductoItems'];
            $idCampana = $arg['idCampana'];

            $campana = campanaTable::getInstance()->getById($idCampana);
            
            $productoItems = productoItemTable::getInstance()->listByIdsProductoItem( $idsProductoItems );
            $idProductoItemsConFaltantes = productoItemTable::getInstance()->getFaltantesByIdCampana( $idCampana );
            
            $data = array();
            foreach ($productoItems as $productoItem) {

                $producto = $productoItem->getProducto();
                if ( !isset( $data[ $producto->getIdProducto() ] ) ) {
                    $data[ $producto->getIdProducto() ] = array();
                }
                
                $instanteReseteo = stockTable::getInstance()->getInstanteReseteo($productoItem->getIdProductoItem(), $campana->getFechaFin());            
                $stockReseteadoCampana = stockTable::getInstance()->getStockReseteado($productoItem->getIdProductoItem(), producto::ORIGEN_OFERTA, $instanteReseteo);
                $stockReseteadoRefuerzo = stockTable::getInstance()->getStockReseteado($productoItem->getIdProductoItem(), producto::ORIGEN_REFUERZO, $instanteReseteo);
                
                $row = array();
                $row['idProductoItem'] = $productoItem->getIdProductoItem();
                $row['talle'] = $productoItem->getProductoTalle()->getDenominacion();
                $row['color'] = $productoItem->getProductoColor()->getDenominacion();
                $row['stock'] = 0;

                if ( !in_array( $productoItem->getIdProductoItem(), $idProductoItemsConFaltantes ) )
                {
                    if ($stockEn == 'CAMPAN') {
                        $productoItem->sumaStock($stockReseteadoCampana, producto::ORIGEN_OFERTA, stockTipo::SISTEMA_RESTAURACION_CAMPANA, null, 'Campaña #' . $campana->getIdCampana());
                        $stockRestauradoCampana = $productoItem->getStockCampana();
                    } else
                    if ($stockEn == 'STKPER') {
                        $productoItem->sumaStock($stockReseteadoCampana, producto::ORIGEN_STOCK_PERMANENTE, stockTipo::SISTEMA_RESTAURACION_CAMPANA, null, 'Campaña #' . $campana->getIdCampana());
                        $stockRestauradoCampana = $productoItem->getStockPermanente();
                    } else {
                        $productoItem->sumaStock($stockReseteadoCampana, producto::ORIGEN_OUTLET, stockTipo::SISTEMA_RESTAURACION_CAMPANA, null, 'Campaña #' . $campana->getIdCampana());
                        $stockRestauradoCampana = $productoItem->getStockOutlet();
                    }

                    $stockRestauradoRefuerzo = 0;
                    if ( $restaurarRefuerzo ) {
                        $productoItem->sumaStock($stockReseteadoRefuerzo, producto::ORIGEN_REFUERZO, stockTipo::SISTEMA_RESTAURACION_CAMPANA, null, 'Campaña #' . $campana->getIdCampana());
                        $stockRestauradoRefuerzo = $productoItem->getStockRefuerzo();
                    }
                                    
                    if ($asignar) {
                        $productoCampana = productoCampanaTable::getInstance()->getOne($producto->getIdProducto(), $asignar);
                    
                        if (! $productoCampana) {
                            $productoCampana = new productoCampana();
                            $productoCampana->setIdCampana($asignar);
                            $productoCampana->setIdProducto($producto->getIdProducto());
                            $productoCampana->save();
                        }
                    }
                    
                    $row['stock'] = $stockRestauradoCampana + $stockRestauradoRefuerzo;
                    
                }

                productoCampanaFinalizadaTable::getInstance()->updateRestaurada($producto->getIdProducto(), $campana->getIdCampana());

                $data[ $producto->getIdProducto() ]['producto'] = $producto;
                $data[ $producto->getIdProducto() ]['productoItems'][] = $row;
            }

            $response = array(
                'data' => $data,
                'campana' => $campana,
                'asignar' => $asignar,
                'stockEn' => $stockEn,
                'restaurarRefuerzo' => $restaurarRefuerzo,
                'idProductoItemsConFaltantes' => $idProductoItemsConFaltantes
            );

                    
            // Creo la notificacion
            $notificacionBackend = new notificacionBackend();
            $notificacionBackend->setTipo( notificacionBackend::TIPO_RESTAURAR_CAMPANA );
            $notificacionBackend->setResponse( serialize( $response ) );
            $notificacionBackend->setIdUsuario( $idUsuario );
            $notificacionBackend->save();

            $conn->commit();
        }
        catch(Doctrine_Exception $e)
        {
            $conn->rollback();
        }
        
    }
}