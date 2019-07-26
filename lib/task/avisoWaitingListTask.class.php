<?php

class avisoWaitingListTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'aviso-waiting-list';
		$this->briefDescription = 'Envia el aviso de reposicion del stock a los usuarios en lista de espera.';
		$this->detailedDescription = <<<EOF
La tarea [aviso-waiting-list|INFO] Envia el aviso de reposicion del stock a los usuarios en lista de espera. 
Call it with: [php symfony deluxebuys:aviso-waiting-list|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "avisoWaitingList"');

		$waitingList = waitingListTable::getInstance()->listActivos();

		$current = array();
				
		foreach ($waitingList as $row)
		{
			if ( $current['productoItem']['id'] != $row->getIdProductoItem() )
			{
				$current['productoItem']['id'] = $row->getIdProductoItem();
				$current['productoItem']['hayStock'] = $row->getProductoItem()->getCurrentStock() > 0;
				$current['producto'] = $row->getProductoItem()->getProducto();
				$current['marca'] = $current['producto']->getMarca();
			}
				
			if ( !$current['productoItem']['hayStock'] ) continue;
			
			$productoCampana = $current['producto']->getProductoCampana();			
			if ($productoCampana->count()) {
			    $campana = $productoCampana->getFirst()->getCampana();
			    if (!$campana->estaOnline()) {
			        continue;
			    }
			}
			
			$usuario = $row->getUsuario();
			
			$subject = 'Nuevo stock disponible en ' . $current['marca']->getNombre();
			$vars = array( 'title'   => $subject, 'usuario' => $usuario, 'producto' => $current['producto'], 'marca' => $current['marca'] );
			$mailer = new Mailer('avisoWaitingList', $vars);
			$from = ( $usuario->getIdEshop() ) ? $usuario->getEshop()->getEmailNoReply() : sfConfig::get('app_email_from_noreply');
			$mailer->send( $subject, $usuario->getEmail(), $from );

			$this->log('Se envió el aviso a ' . $usuario->getEmail() . ' por el producto #' . $row->getIdProductoItem() );
			$row->delete();
		}

		$this->log('--- Fin de ejecucion: "avisoWaitingList"');
	}
}
