<?php

class updateStockCampanaFinalizadaTask extends deluxebuysBaseTask
{	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'update-stock-campana-finalizada';
		$this->briefDescription = 'Hace update al stock de todos los productos una vez que son quitados de la campaña finalizada';
		$this->addOption('fecha', null, sfCommandOption::PARAMETER_OPTIONAL, 'Fecha de ejecucion (Y-m-d)', false);
		$this->detailedDescription = <<<EOF
La tarea [update-stock-campana-finalizada|INFO] hace update al stock de todos los productos una vez que son quitados de la campaña finalizada
Call it with: [php symfony deluxebuys:update-stock-campana-finalizada|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{	    
	    $fechaHoy = ( $options['fecha'] ) ? $options['fecha'] : date('Y-m-d', strtotime('today') );

    	$productos = productoTable::getInstance()->listByCampanaFinalizada( $fechaHoy );

    	foreach ($productos as $producto) {
    		$producto->updateStock();
    		$this->log('Se actualiza el stock del producto #' . $producto->getIdProducto() );
    	}
	}
	
		
}