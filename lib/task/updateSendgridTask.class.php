<?php

class updateSendgridTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'update-sendgrid';
		$this->briefDescription = 'Envia a sendgrid en forma batch a todos los suscriptos del dia anterior';
		$this->detailedDescription = <<<EOF
La tarea [update-sendgrid|INFO] envia a sendgrid en forma batch a todos los suscriptos del dia anterior
Call it with: [php symfony deluxebuys:update-sendgrid|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "updateSendgrid"');

		$fecha = date( 'Y-m-d', strtotime('-1 days') );

    	// Deluxe Buys
    	
		$newsletters = newsletterTable::getInstance()->listByFechaAlta( $fecha, null, 'h' );
		$idList = sfConfig::get('app_sendGrid_SubscribersListID_h' );
	    Sendgrid::getInstance()->addContacts( $newsletters, $idList );
	    $this->log('Se actualizaron ' . count($newsletters) . ' contacto/s de Deluxe Buys en la lista de Hombres');

		$newsletters = newsletterTable::getInstance()->listByFechaAlta( $fecha, null, 'm' );
		$idList = sfConfig::get('app_sendGrid_SubscribersListID_m' );
	    Sendgrid::getInstance()->addContacts( $newsletters, $idList );
	    $this->log('Se actualizaron ' . count($newsletters) . ' contacto/s de Deluxe Buys en la lista de Mujeres');

	    // eShops
	    $eshops = eshopTable::getInstance()->listAll();
	    foreach ($eshops as $eshop) {
	      $newsletters = newsletterTable::getInstance()->listByFechaAlta( $fecha, $eshop->getIdEshop() );
	      Sendgrid::getInstance()->addContacts( $newsletters, $eshop->getListaSendgrid() );
	      $this->log('Se actualizaron ' . count($newsletters) . ' contacto/s de ' . $eshop->getDenominacion() );
	    }

		$this->log('--- Fin de ejecucion: "updateSendgrid"');
	}

}
