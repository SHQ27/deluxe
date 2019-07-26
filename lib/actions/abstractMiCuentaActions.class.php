<?php

/**
 * miCuenta actions.
 *
 * @package        deluxebuys
 * @subpackage     miCuenta
 * @author         Your name here
 * @version        SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class abstractMiCuentaActions extends deluxebuysActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $usuario = $this->getUser()->getCurrentUser();
    
        $this->datosPersonalesForm = new DatosPersonalesForm($usuario, array('eshop' => $eshop));
        $this->modificarPassForm = new ModificarPassForm();
        $this->direccionEnvioForm = new direccionEnvioForm($usuario->getDireccionEnvioDefault());
        $this->modificarEmailForm = new ModificarEmailForm( null, array('eshop' => $eshop) );
        $this->devolucionesForm = new devolucionesForm();
    
        if ($request->isMethod('post')) {
            $usuarioParams = $request->getParameter('usuario');
            if ($usuarioParams) {
                $this->datosPersonalesForm->bind($usuarioParams);
                if ($this->datosPersonalesForm->isValid()) {
                    $this->datosPersonalesForm->save();
                    $this->getUser()->setFlash('datos_personales_guardado', true);
                }
            }
    
            $modificarPassParams = $request->getParameter('modificar_pass');
            if ($modificarPassParams) {
                $this->modificarPassForm->bind($modificarPassParams);
                if ($this->modificarPassForm->isValid()) {
                    $usuario = $this->getUser()->getCurrentUser();
                    $usuario->setPassword($this->modificarPassForm->getValue('new'));
                    $usuario->save();
                    $this->getUser()->setFlash('pass_modificada', true);
                }
            }
    
            $modificarEmailParams = $request->getParameter('modificar_email');
            if ($modificarEmailParams) {
                $this->modificarEmailForm->bind($modificarEmailParams);
                if ($this->modificarEmailForm->isValid()) {
                    $usuario = $this->getUser()->getCurrentUser();
                    $usuario->setEmail($this->modificarEmailForm->getValue('email'));
                    $usuario->setActivo(false);
                    $usuario->save();
    
                    $datos = array('eshop' => $eshop, 'usuario' => $usuario, 'referrer' => 'mi-cuenta');
                    $mailer = new Mailer('modificarEmail', $datos);
                    $from = ( $usuario->getIdEshop() ) ? $usuario->getEshop()->getEmailNoReply() : sfConfig::get('app_email_from_noreply');
                    $mailer->send('Necesitamos que confirmes la modificacion de tu Email', $usuario->getEmail(), $from );
    
                    $this->getUser()->setFlash('email_modificado', true);
                }
            }
    
            $direccionEnvioParams = $request->getParameter('direccion_envio');
            if ($direccionEnvioParams) {
                $direccionEnvioParams['id_usuario'] = $usuario->getIdUsuario();
                $this->direccionEnvioForm->bind($direccionEnvioParams);
    
                if ($this->direccionEnvioForm->isValid()) {
                    $this->direccionEnvioForm->save();
                    $this->getUser()->setFlash('direccion_modificada', true);
                }
                else
                {
                    $this->getUser()->setFlash('direccion_modificada', false);
                }
            }
    
            $devolucionesParams = $request->getParameter('devoluciones');
    
            if ($devolucionesParams) {
                $this->devolucionesForm->bind($devolucionesParams);
                 
                if ( $this->devolucionesForm->isValid() )
                {
                    if ($this->devolucionesForm->procesar($eshop) )
                    {
                        $this->redirect('mi_cuenta_devoluciones_ok');
                    }
                    else
                    {
                        $this->redirect('mi_cuenta_devoluciones_error');
                    }
                }
            }
    
        }
    
        $this->ultimosPedidos = pedidoTable::getInstance()->listUltimosByIdUsuario( $usuario->getIdUsuario() );
        $this->creditoUtilizado = bonificacionTable::getInstance()->creditoUtilizado($usuario);
        $this->usuario = $usuario;
    }
    
    public function executeDesactivar(sfWebRequest $request)
    {
        $this->getUser()->getCurrentUser()->desactivar();
        $this->getUser()->destroy();
        $this->redirect('homepage');
    }
    
    public function executeDetallePedido(sfWebRequest $request)
    {
        $this->setLayout( false );

        $this->pedido = $this->getRoute()->getObject();
    }
    
    public function executeDetalleEnvio(sfWebRequest $request)
    {
        $this->setLayout( false );
        
        $this->pedido = $this->getRoute()->getObject();
    }
    
    public function executeVerificarEnvio(sfWebRequest $request)
    {
        $idPedido = $request->getParameter('idPedido');
        $this->pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
        $this->setLayout(false);
    }
    
    public function executeDescargarFactura(sfWebRequest $request)
    {
        $idPedido = $request->getParameter('idPedido');
        $factura = facturaTable::getInstance()->getByIdPedido($idPedido);
    
        if ( $this->getUser()->getCurrentUser()->getIdUsuario() != $factura->getPedido()->getIdUsuario() )
        {
            $this->redirect('/');
        }
         
        if ( $factura )
        {
            $filePath = FacturaPDFFactory::getInstance()->getDownloadPath( $factura );
            $fileName = FacturaPDFFactory::getInstance()->getDownloadName( $factura );
             
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$fileName\"\n");
            $fp=fopen( $filePath , "r");
            fpassthru($fp);
        }
    
        throw new sfStopException();
    }
    
    /**
     * Executes bajaPedido action
     *
     * @param sfRequest $request A request object
     */
    public function executeBajaPedido(sfWebRequest $request)
    {
        $idPedido = $request->getParameter('idPedido');
        $pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
    
        if ( $this->getUser()->getCurrentUser()->getIdUsuario() == $pedido->getIdUsuario() )
        {
            $pedido->procesarBaja( 'Baja del Pedido #' . $pedido->getIdPedido() . ', por eleccion del usuario desde mi cuenta.' );
        }
    
        $this->redirect('@mi_cuenta_pedidos');
        exit;
    }
}
