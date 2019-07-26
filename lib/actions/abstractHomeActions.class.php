<?php

/**
 *
 * @package    deluxebuys
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class abstractHomeActions extends deluxebuysActions
{	
    public function executeSuscribir(sfWebRequest $request)
    {
        $this->setLayout( false );

        if (!$this->getRequest()->isXmlHttpRequest())
        {
            $this->redirect('/');
            return;
        }
        
        $eshop = eshopTable::getInstance()->getCurrent();
        
        if ( $eshop ) {
            $idEshop = $eshop->getIdEshop();
            $from = $eshop->getEmailNoReply();
            $asunto = 'Bienvenido al eShop de ' . $eshop->getDenominacion();
            $titulo = '¡Bienvenido al eShop de ' . $eshop->getDenominacion() . '!';
        } else {
            $idEshop = null;
            $from = sfConfig::get('app_email_from_noreply');
            $asunto = 'Bienvenido a Deluxebuys';
            $titulo = '¡Bienvenido a Deluxebuys!';
        }
    
        $form = new suscribeForm();
    
        $nombre = $request->getParameter('nombre');
    
        $apellido = $request->getParameter('apellido');
        $email = $request->getParameter('email');
        $genero = $request->getParameter('genero');
    
        $form->bind( array('nombre' => $nombre, 'apellido' => $apellido, 'email' => $email ) );
    
        if ($form->isValid())
        {
            $existe = newsletterTable::getInstance()->subscriberExist($genero, $email, $idEshop );
    
            if (!$existe)
            {
                $newsletter = new newsletter();
                $newsletter->setNombre( $nombre );
                $newsletter->setApellido( $apellido );
                $newsletter->setSexo( $genero );
                $newsletter->setEmail( $email );
                $newsletter->setIdEshop( $idEshop );
    
                $data = $this->getContext()->getRequest()->getCookie(usuario::USER_SOURCE);
    
                if ( $data !== null )
                {
                    $data = json_decode( base64_decode( $data ), true );
    
                    $newsletter->setSource( $data['source'] );
                    $newsletter->setFechaSource( $data['fecha'] );
                    $newsletter->setUtmCampaign( $data['utmCampaign'] );
                    $newsletter->setUtmTerm( $data['utmTerm'] );
                }
                 
                $newsletter->suscribir();
    
                $valor = configuracionTable::getValor(configuracion::MONTO_ALTA_USUARIO);

                $vars = array('eshop' => $eshop, 'title' => $titulo, 'valor' => $valor);
                $mailBonificacion = new Mailer('avisoBonificacion', $vars);
                $mailBonificacion->send($asunto, $email, $from);
    
                return sfView::SUCCESS;
            }
            $this->mensaje = "Ya estás suscripto.";
            $this->tipoError = "ERROR_UNIQUE";
        }
        else
        {
            $this->mensaje = "Debe ingresar datos validos";
            $this->tipoError = "ERROR_VALID";
        }
        return sfView::ERROR;
    }
    
    public function executeNuevaSuscripcion(sfWebRequest $request)
    {
        $this->eshop = eshopTable::getInstance()->getCurrent();
    }    	
}
