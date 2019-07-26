<?php

class Net_Gearman_Job_PrepararEnvioWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {                   
        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];

        // Recupero las variables enviadas
        $idEshop = $arg['idEshop'];
        $values = $arg['values'];

        $response = $this->procesar($idUsuario, $idEshop, $values);

        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_PREPARAR_ENVIO );
        $notificacionBackend->setResponse( json_encode( $response ) );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
    }

    protected function procesar ( $idUsuario, $idEshop, $values )
    {
        $idsPedido = $values['id_pedido'];

        // Si no hay pedidos se evita el proceso
        if (!$idsPedido) {
            return array('procesados' => count($idsPedido) );
        }
            
        // Envio
        $ok = array();
        $error = array();
        $pedidos = pedidoTable::getInstance()->listByIds( $idsPedido );
        foreach ($pedidos as $pedido)
        {   
            if ( $pedido->getEnvioTipo() == CarritoEnvio::DOMICILIO ) {
                $pedido->setEnvioCalle( $values['calle'][ $pedido->getIdPedido() ] );
                $pedido->setEnvioNumero( $values['numero'][ $pedido->getIdPedido() ] );
                $pedido->setEnvioPiso( $values['piso'][ $pedido->getIdPedido() ] );
                $pedido->setEnvioDepto( $values['dpto'][ $pedido->getIdPedido() ] );
                $pedido->setEnvioCodigoPostal( $values['cp'][ $pedido->getIdPedido() ] );
            }

            $pedido->setTelefono( $values['telefono'][ $pedido->getIdPedido() ] );
            $pedido->updateEnvioDetalle();
            $pedido->save();

            $status = $this->imponer($pedido);

            if ( $status ) {
                $ok[] = $pedido->getIdPedido();
            } else {
                $error[] = $pedido->getIdPedido();
            }
        }

        return array('procesados' => count($idsPedido), 'ok' => implode(',', $ok), 'error' => implode(',', $error) );
    }
    
    protected function imponer( $pedido ) {

        $idPedidoEnvioPack = EnvioPack::getInstance( $pedido->getIdEshop() )->imponerPedido( $pedido );
        if ( !$idPedidoEnvioPack ) { return false; }

        $response = EnvioPack::getInstance( $pedido->getIdEshop() )->imponerEnvio( $pedido );
        $this->log(json_encode($response));
        if ( !isset($response['id']) ) { return false; }

        $remito = new remito();
        $remito->setIdEnvio( $response['id'] );
        $remito->save();

        $remitoPedido = new remitoPedido();
        $remitoPedido->setIdRemito( $remito->getIdRemito() );
        $remitoPedido->setIdPedido( $pedido->getIdPedido() );
        $remitoPedido->save();

        return true;
    }
}