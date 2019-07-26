<?php

class Net_Gearman_Job_HojaDeRutaWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {                      
        $idUsuario = $arg['idUsuario'];
        
        $fecha = date( 'Y-m-d', strtotime('-25 days') );
        $campanas = campanaTable::getInstance()->finalizadasDesde( $fecha );

        $data = array();

        foreach ($campanas as $campana) {

          $dataCampana = array( 'recepcionadas' => array(), 'no-recepcionadas' => array() );
          $mostrarCampana = false;

          $campanaMarcas = $campana->getCampanaMarca();
          foreach ($campanaMarcas as $campanaMarca) {
            $marca = $campanaMarca->getMarca();
            $recepcionFinalizada = $campanaMarca->recepcionFinalizada();


            if ( $recepcionFinalizada ) {
              $dataCampana['recepcionadas'][ $marca->getNombre() ] = $marca->getNombre();
            } else {
              $mostrarCampana = true;
              $dataCampana['no-recepcionadas'][ $marca->getNombre() ] = $marca->getNombre();
            }
          }

          if ( $mostrarCampana ) {

            ksort( $dataCampana['recepcionadas'] );
            ksort( $dataCampana['no-recepcionadas'] );

            $data[] = array(
              'campana' => $campana->getDenominacion(),
              'desde' => $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y"),
              'hasta' => $campana->getDateTimeObject('fecha_fin')->format("d/m/Y"),
              'dataCampana' => $dataCampana
            );
          }
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
        $content = get_partial('campanas/hojaDeRuta', array('data' => $data) );

        $tempFile = sfConfig::get('sf_temp_dir'). '/hoja_de_ruta_' . date('Y_m_d') . '.html';
        file_put_contents($tempFile, $content);

        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_HOJA_DE_RUTA );
        $notificacionBackend->setResponse( $tempFile );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
        
        return $tempFile;
    }
}