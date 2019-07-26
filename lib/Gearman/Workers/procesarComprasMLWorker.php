<?php

class Net_Gearman_Job_ProcesarComprasMLWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        $idPagoNotificacion = $arg['idPagoNotificacion'];
        $pagoNotificacion = pagoNotificacionTable::getInstance()->findOneByIdPagoNotificacion( $idPagoNotificacion );
        
        return MercadoLibre::getInstance()->procesarPago($pagoNotificacion);
    }
}