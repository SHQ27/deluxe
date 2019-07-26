<?php

class avisoPosibleStockDuplicadoTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'aviso-posible-stock-duplicado';
		$this->briefDescription = 'Envia el aviso por posible stock duplicado';
		$this->detailedDescription = <<<EOF
La tarea [aviso-posible-stock-duplicado|INFO] Envia el aviso por posible stock duplicado 
Call it with: [php symfony deluxebuys:aviso-posible-stock-duplicado|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "avisoPosibleStockDuplicado"');

		$posiblesDuplicados = productoItemTable::getInstance()->listAlertaStockDuplicado();
		
		if ( count($posiblesDuplicados) )
		{
			$data = array();
			foreach ( $posiblesDuplicados as $productoItem )
			{
				$producto = $productoItem->getProducto();
				
				$row['producto'] = $producto->getDenominacion();
				$row['productoTalle'] = $productoItem->getProductoTalle()->getDenominacion();
				$row['productoColor'] = $productoItem->getProductoColor()->getDenominacion();
				$row['URL'] = '/backend/productos/' . $producto->getIdProducto() . '/edit ';
				
				$data[] = $row;
				
				$this->log('Se registro posible stock para: idProducto = ' . $producto->getIdProducto() . ' | Talle = ' . $row['productoTalle'] . ' | Color = ' . $row['productoColor'] );
			}
			
			$subject = 'Alerta por posible stock duplicado durante el ' . date('d/m/Y');
			$vars = array( 'title'   => $subject, 'data' => $data );
			$mailer = new Mailer('avisoPosibleStockDuplicado', $vars);
			$mailer->send( $subject, sfConfig::get('app_email_to_avisoPosibleDuplicado') );
		}
		else 
		{
			$this->log('No se registro posible stock duplicado hasta el momento, durante el dia de hoy.' );
		}

		$this->log('--- Fin de ejecucion: "avisoPosibleStockDuplicado"');
	}
}
