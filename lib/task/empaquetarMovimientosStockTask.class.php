<?php

class empaquetarMovimientosStockTask extends deluxebuysBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'empaquetar-movimientos-stock';
		$this->briefDescription = 'Empaqueta todos los registros de stock del antepenultimo mes en un solo registro';
		$this->detailedDescription = <<<EOF
La tarea [empaquetar-movimientos-stock|INFO] empaqueta todos los registros de stock del antepenultimo mes en un solo registro
Call it with: [php symfony deluxebuys:empaquetar-movimientos-stock|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{				
		
		$conn = Doctrine_Manager::connection();
		
		try
		{
			$conn->beginTransaction();
			
			$this->log('--- Comienzo de ejecucion: "empaquetarMovimientosStock"');
			
			$productoItemStock = array();
			
			$mesActual = date('m');
			$anoActual = date('Y');
												
			$desde = mktime(0, 0, 0, $mesActual - 2, 1, $anoActual );

			$fechaDesde = date('Y-m-d', $desde);			
			$hasta = mktime(0, 0, 0, $mesActual - 1, 0, $anoActual );
			$fechaHasta = date('Y-m-d', $hasta);
			
			$mesReferencia = date('m/Y', $desde);			
			
			$results = stockTable::getInstance()->listIdProductoItemByFechas($fechaDesde, $fechaHasta);
			
			foreach ($results as $row)
			{
				$idProductoItem = $row['id_producto_item'];
				
				$movimientos = stockTable::getInstance()->listByIdProductoItemAndFechas($idProductoItem, $fechaDesde, $fechaHasta);
				
				foreach ($movimientos as $movimiento)
				{
					$stockHistorico = new stockHistorico();
					$stockHistorico->setFecha( $movimiento->getFecha() );
					$stockHistorico->setCantidad( $movimiento->getCantidad() );
					$stockHistorico->setIdProductoItem( $idProductoItem );
					$stockHistorico->setOrigen( $movimiento->getOrigen() );
					$stockHistorico->setIdStockTipo( $movimiento->getIdStockTipo() );
					$stockHistorico->setObservacion( $movimiento->getObservacion() );
					$stockHistorico->save();
										
					if ( !isset( $productoItemStock[ $movimiento->getIdProductoItem() ] ) )
					{
						$productoItemStock[ $movimiento->getIdProductoItem() ][ $movimiento->getOrigen() ]['cantidad'] = 0;
						$productoItemStock[ $movimiento->getIdProductoItem() ][ $movimiento->getOrigen() ]['idsStockHistorico'] = array();
					}
					
					$productoItemStock[ $movimiento->getIdProductoItem() ][ $movimiento->getOrigen() ]['cantidad'] += $movimiento->getCantidad();
					$productoItemStock[ $movimiento->getIdProductoItem() ][ $movimiento->getOrigen() ]['idsStockHistorico'][] = $stockHistorico->getIdStockHistorico();
					
					$movimiento->delete();
				}
			}
			
			foreach ($productoItemStock as $idProductoItem => $data)
			{
			    foreach( $data as $origen => $row )
			    {			        
    				$cantidad = $row['cantidad'];
    				$idsStockHistorico = $row['idsStockHistorico'];
    				
    				$movimiento = new stock();
    				$movimiento->setIdProductoItem( $idProductoItem );
    				$movimiento->setCantidad( $cantidad );
    				$movimiento->setIdStockTipo( stockTipo::SISTEMA_EMPAQUETADO );
    				$movimiento->setObservacion( 'Mes ' . $mesReferencia );
    				$movimiento->setEmpaquetado(true);
    				$movimiento->setOrigen( $origen );
    				$movimiento->save();
    				
    				foreach ($idsStockHistorico as $idStockHistorico)
    				{
    					$stockHistorico = stockHistoricoTable::getInstance()->getByIdStockHistorico($idStockHistorico);
    					$stockHistorico->setIdStock( $movimiento->getIdStock() );
    					$stockHistorico->save();
    				}
			    }
			}

			$this->log('--- Fin de ejecucion: "empaquetarMovimientosStock"');

			$conn->commit();
	    }
	    catch(Doctrine_Exception $e)
	    {	    	
	    	echo $e;
			$conn->rollback();
			$this->log('--- Error de ejecucion: "empaquetarMovimientosStock"');
		}
		
	}  
}
