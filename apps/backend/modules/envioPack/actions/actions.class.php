<?php
/**
 * aws actions.
 *buys
 * @subpackage aws
 * @author     Y
 * @package    deluxeour name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class envioPackActions extends sfActions
{
        
    public function executeNotifications(sfWebRequest $request)
    {    	
        $idEshop = $request->getParameter('idEshop');
        $idEnvioEnvioPack = $request->getParameter('id');

        $responseEnvio = EnvioPack::getInstance( $idEshop )->envio( $idEnvioEnvioPack );

        if ( isset( $responseEnvio['pedido'] ) ) {
            $idPedidoEnvioPack = $responseEnvio['pedido'];
            $responsePedido = EnvioPack::getInstance( $idEshop )->pedido( $idPedidoEnvioPack );

            if ( isset( $responsePedido['id_externo'] ) ) {
                $idPedido = $responsePedido['id_externo'];

                if ( substr( $idPedido, 0, 1 ) == 'D' ) {
                    $this->procesarNotificacionDevolucion( $idPedido, $responseEnvio );
                } else {
                    $this->procesarNotificacionPedido( $idPedido, $responseEnvio );
                }
            }
        }
        
        $status= "200";
        $status_header = 'HTTP/1.0 ' . $status . ' OK';
        header($status_header);
        exit;
    }

    protected function procesarNotificacionPedido( $idPedido, $responseEnvio ) {

        $pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );

        if ( $pedido ) {
            $pedido->setFechaEnvio( new Doctrine_Expression('now()') );
            $pedido->setCodigoEnvio( $responseEnvio['tracking_number'] );
            $pedido->save();

            $pedido->enviarGuiaEnvio();
        }

    }

    protected function procesarNotificacionDevolucion( $idExterno, $responseEnvio ) {

        $idDevolucion = str_replace('D', '', $idExterno);
        $devolucion = devolucionTable::getInstance()->getByIdDevolucion( $idDevolucion );

        if ( $devolucion ) {

            $usuario = $devolucion->getUsuario();
            
            if ( $devolucion->getIdEshop() ) {
                $eshop = $devolucion->getEshop();
                $from = $eshop->getEmailNoReply();
                $tipoMail  = 'ESHOP';
            } else {
                $eshop = false;
                $from = sfConfig::get('app_email_from_noreply');
                $tipoMail  = 'DELUXE';
            }
            
            $subject = 'Se ha dado inicio al proceso de devolucion';
            $vars = array( 'eshop'   => $eshop, 'title' => $subject, 'usuario' => $usuario, 'devolucion' => $devolucion );
            $mailer = new Mailer('devolucionEntregaOca' . $tipoMail, $vars);
            $mailer->send( $subject, $usuario->getEmail(), $from );
        }

    }
    
    
}
    