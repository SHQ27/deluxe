<?php

class notificarMercaderiaNoRecepcionadaTask extends deluxebuysBaseTask
{

	protected function configure()
	{
		parent::preConfigure();

		$this->name             = 'notificar-mercaderia-no-recepcionada';
		$this->briefDescription = 'Crea una notificacion en el backend sobre la mercaderia no recepcionada';
		$this->detailedDescription = <<<EOF
La tarea [notificar-mercaderia-no-recepcionada|INFO] crea una notificacion en el backend sobre la mercaderia no recepcionada
Call it with: [php symfony deluxebuys:notificar-mercaderia-no-recepcionada|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{
		$this->log('--- Comienzo de ejecucion: "notificarMercaderiaNoRecepcionada"');

		$fecha = date( 'Y-m-d', strtotime('-7 days') );
		$campanas = campanaTable::getInstance()->listByFechaFin( $fecha );

    foreach ($campanas as $campana) {
      $campanaMarcas = $campana->getCampanaMarca();
      foreach ($campanaMarcas as $campanaMarca) {
        $marca = $campanaMarca->getMarca();
        if ( !$campanaMarca->recepcionFinalizada() ) {
        	$this->informarRetraso( $campana, $marca, 337 );
        	$this->informarRetraso( $campana, $marca, 113 );
        }
      }
    }

		$this->log('--- Fin de ejecucion: "notificarMercaderiaNoRecepcionada"');
	}


    protected function informarRetraso($campana, $marca, $idUsuario) {


      $link = sfContext::getInstance()->getController()->genUrl( array(
        'sf_route' => 'campanas_pedidosNoEnviados',
        'idCampana' => $campana->getIdCampana(),
        'idMarca' => $marca->getIdMarca(),
      ), false);

      $link = str_replace('./symfony', sfConfig::get('app_host') . '/backend', $link);

      $notificacionBackend = new notificacionBackend();
      $notificacionBackend->setTipo( notificacionBackend::TIPO_MENSAJE );
      $notificacionBackend->setResponse( 'La marca ' . $marca->getNombre() . ' en la campaña ' . $campana->getDenominacion() . ' tiene demoras en la entrega de mercadería. <br /><br />Recordá informar a los compradores de esta eventualidad.<br /><br />Podes descargar el csv con los datos de los usuarios afectados haciendo <a href="' . $link . '">click aqui</a>' );
      $notificacionBackend->setIdUsuario( $idUsuario );
      $notificacionBackend->save();
    }

}
