<?php

/**
 * usuario actions.
 *
 * @package        deluxebuys
 * @subpackage usuario
 * @author         Your name here
 * @version        SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuarioActions extends abstractUsuarioActions
{
    /**
     * Execute login with Facebook account
     *
     * @param sfRequest $request A request object
     */
    public function executeLoginFacebook(sfWebRequest $request)
    {
        $facebook = new Facebook(array(
            'appId'  => sfConfig::get('app_facebook_fb_api_id'),
            'secret' => sfConfig::get('app_facebook_fb_api_secret'),
        ));
    
        $user_profile = $facebook->api('/'.$facebook->getUser());
    
        if (!empty($user_profile["email"])) {
            // Si no hay registrado un usuario con ese email, lo creo.
            $estaRegistrado = usuarioTable::getInstance()->getByEmail($user_profile["email"], null);
            if (!$estaRegistrado) {
                $usuario = new usuario();
                $usuario->setNombre($user_profile["first_name"]);
                $usuario->setApellido($user_profile["last_name"]);
                $usuario->setEmail($user_profile["email"]);
                $usuario->setFid($user_profile["id"]);
                $usuario->setIdPais("AR");
                $usuario->setActivo(1);
                $usuario->save();
    
                $usuario->bonificarAlta();
            } else {
                $estaRegistrado->setFid($user_profile["id"]);
                $estaRegistrado->save();
            }
            // Si hay un usuario registrado con ese facebook_id y email lo logueo
            $registradoFacebook = usuarioTable::getInstance()->findOneByFid($user_profile["email"], $user_profile["id"]);
            if ($registradoFacebook) {
                $this->login($registradoFacebook);
                $referrer = $request->getParameter('referrer');
                $this->redirect( $referrer );
            } else {
                $this->getUser()->setFlash('registroFacebookError', "Los datos de acceso no son válidos.");
                $this->redirect('@usuario');
            }
    
        }
    
        $this->redirect('@usuario');
    }
    
    public function executeAltaCaptia(sfWebRequest $request)
    {
        set_time_limit(0);
    
        $codigo = $request->getParameter('codigo');
    
        $nombre = $this->getDatoCaptia($codigo, 'nombre');
        $apellido = $this->getDatoCaptia($codigo, 'apellido');
        $email = $this->getDatoCaptia($codigo, 'email');
        $sexo = $this->getDatoCaptia($codigo, 'sexo');
        $nacimiento_dd = $this->getDatoCaptia($codigo, 'nacimiento_dd');
        $nacimiento_mm = $this->getDatoCaptia($codigo, 'nacimiento_mm');
        $nacimiento_aaaa = $this->getDatoCaptia($codigo, 'nacimiento_aaaa');
        $celular_codigo = $this->getDatoCaptia($codigo, 'celular_codigo');
        $celular_numero = $this->getDatoCaptia($codigo, 'celular_numero');
        $telefono_codigo = $this->getDatoCaptia($codigo, 'telefono_codigo');
        $telefono_numero = $this->getDatoCaptia($codigo, 'telefono_numero');
    
        if ( !$email ) {
            echo 'NO SE PUDO DAR DE ALTA. FALTA EL EMAIL';
            exit;
        }
    
        $usuario = usuarioTable::getInstance()->getByEmail($email, null);
    
        if ($usuario){
            echo 'YA EXISTE UN USUARIO CON EL MISMO EMAIL';
            exit;
        }
    
        $usuario = new usuario();
        $usuario->setNombre( $nombre );
        $usuario->setApellido( $apellido );
        $usuario->setEmail( $email );
        $usuario->setSexo( $sexo == 'Masculino' ? 'h' : 'm' );
    
        if ( $nacimiento_aaaa && $nacimiento_mm && $nacimiento_dd ) {
            $usuario->setFechaNacimiento( $nacimiento_aaaa . '-' . $nacimiento_mm . '-' . $nacimiento_dd );
        }
    
        if ( $telefono = trim($telefono_codigo . ' ' . $telefono_numero) ) {
            $usuario->setTelefono( $telefono );
        }
    
        if ( $celular = trim($celular_codigo . ' ' . $celular_numero) ) {
            $usuario->setCelular( $celular );
        }
    
        $usuario->setIdPais("AR");
    
        $password = $this->generateRandomPassword();
        $usuario->setPassword($password);
    
        $usuario->setFechaConfirmacion(new Doctrine_Expression('NOW()'));
        $usuario->setActivo(1);
        $usuario->setSource('CAPTIA');
        $usuario->setFechaSource(new Doctrine_Expression('NOW()'));
        $usuario->save();
    
        $usuario->bonificarAlta();
        $this->subscribe($usuario);
    
        $subject = 'Bienvenido ' . $usuario->getNombre();
        $vars = array( 'title' => $subject, 'usuario' => $usuario, 'password' => $password );
        $mailer = new Mailer('nuevoUsuarioCaptia', $vars);
        $mailer->send( $subject, $usuario->getEmail());
    
        echo 'ALTA_OK';
        exit;
    }
    
    protected function getDatoCaptia($codigo, $campo)
    {
        return file_get_contents("http://captianet.com/deluxe/recibe.php?obtener_dato=si&codigo=".$codigo."&campo=".$campo);
    }    
}
