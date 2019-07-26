<?php

/**
 * usuario actions.
 *
 * @package        deluxebuys
 * @subpackage     usuario
 * @author         Your name here
 * @version        SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class abstractUsuarioActions extends deluxebuysActions
{
    /**
     * @var usuarioForm
     */
    protected $usuarioForm;
    /**
     * @var LoginForm
     */
    protected $loginForm;
    /**
     * (non-PHPdoc)
     * @see lib/action/sfAction::preExecute()
     */
    public function preExecute()
    {
        // Antes de pisar el preExecute es necesario ejecutar el parent
        parent::preExecute();

        $eshop = eshopTable::getInstance()->getCurrent();
        
        $request = $this->getRequest();
        
        // Usuario Form
        $this->usuarioForm = new usuarioForm(
                                            null,
                                            array('isBackend' => false, 'eshop' => $eshop)
        );
        
        $this->usuarioForm->setDefault('referrer', $this->getReferrerRedirect());

        if ($usuarioParams = $request->getParameter('usuario')) {
            $this->usuarioForm->bind($usuarioParams);
        }
        $this->setVar('usuarioForm', $this->usuarioForm);
        
        
        // Login Form
        $this->loginForm = new LoginForm(
                                            array( 'referrer' => $this->getReferrerRedirect() ),
                                            array( 'eshop' => $eshop )
        );
        
        if ($loginParams = $request->getParameter('login')) {
            $this->loginForm->bind($loginParams);
        }
        
        $this->setVar('loginForm', $this->loginForm);

        // Olvide Contrasena Form 
        $this->olvideContrasenaForm = new OlvideContrasenaForm();
        
        if ($OlvideContrasenaParams = $request->getParameter('olvide_contrasena')) {
            $this->olvideContrasenaForm->bind($OlvideContrasenaParams);
        }
        
        $this->setVar('OlvideContrasenaForm', $this->olvideContrasenaForm);
        $this->setVar('eshop', $eshop);
        
    }
    /**
     * Obtiene la url de redireccion
     */
    protected function getReferrerRedirect()
    {
        $requestedRoute = $this->getRoute()->getParameters();
        
        if ($requestedRoute['module'] != 'usuario') {
            return ltrim($_SERVER['REQUEST_URI'], '/');
        }
        if (isset($_SERVER['HTTP_REFERER'])) { 
            $pos = strpos($_SERVER['HTTP_REFERER'], '/', 8) + 1;
            return substr($_SERVER['HTTP_REFERER'], $pos);
        }
        return '';        
    }    
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->view = $request->getParameter('view', 'login');

    	$this->olvideClave = $request->getParameter("olvide_clave");
    	    	
    	$referrer = $this->getReferrerRedirect();
    	$referrer = ($referrer) ? '/' . $referrer : 'homepage';
    	
    	$this->getUser()->setFlash('referrer', $referrer);
    	$this->referrer = $referrer;
    }    


    
    /**
     * Executes login action
     *
     * @param sfRequest $request A request object
     */
    public function executeLogin(sfWebRequest $request)
    {
        if (!$this->executeForm($this->loginForm, 'login')) {
            return;
        }

        $email = $this->loginForm->getValue('email');
        $pass = $this->loginForm->getValue('password');
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $usuario = usuarioTable::getInstance()->findOneByCredentials($email, $pass, $idEshop );
        $this->login($usuario, (bool) $this->loginForm->getValue('remember_me'));
        $referrer = $this->loginForm->getValue('referrer');
        $this->redirect($referrer ? '/' . $referrer  : 'homepage');
    }
    /**
     * Executes logout action
     *
     * @param sfRequest $request A request object
     */
    public function executeLogout(sfWebRequest $request)
    {
        $this->getUser()->destroy();
        $this->getUser()->getAttributeHolder()->clear();
        $this->redirect('homepage');
    }
    
    /**
     * Executes nuevo usuario action
     *
     * @param sfRequest $request A request object
     */
    public function executeNuevo(sfWebRequest $request)
    {
        if (!$this->executeForm($this->usuarioForm, 'nuevo')) {
            return;
        }

        $this->usuarioForm->save();
                
        $usuario = $this->usuarioForm->getObject();
        $referrer = $this->usuarioForm->getValue('referrer');
        $this->enviarEmailActivacion($usuario, $referrer);
        $usuario->setFechaBaja(null);
        $usuario->save();

        // Suscripcion
        $this->subscribe($usuario);                
        $this->usuario = $usuario;

        // Si el usuario es de eshop no le bonifico el alta
        if ( !$usuario->getIdEshop() )
        {
            $usuario->bonificarAlta();
        }
        
        $data = $this->getContext()->getRequest()->getCookie(usuario::USER_SOURCE);
        
        if ( $data !== null )
        {
            $data = json_decode( base64_decode( $data ), true );
            
            $usuario->setSource( $data['source'] );
            $usuario->setFechaSource( $data['fecha'] );
            $usuario->setUtmCampaign( $data['utmCampaign'] );
            $usuario->setUtmTerm( $data['utmTerm'] );
            $usuario->save();
        }
        
    }

    public function executeActivar(sfWebRequest $request)
    {
        $usuario = $this->getRoute()->getObject();
        
        if ( !$usuario->getActivo() )
        {                 
	        if ($usuario->getHashActivacion() != $request->getParameter('hash_activacion')) {
	            return sfView::ERROR;
	        }
	        
	        $usuario->activar();
	        	        
	        $this->login($usuario);
	                
	        $referrer = $request->getParameter('referrer');
	        $this->getUser()->setFlash('registroOK', true);
        }
        
        $this->redirect($referrer ? '/' . $referrer : 'homepage');
    }    
    
    public function executeOlvideContrasena(sfWebRequest $request)
    {        
        if (!$this->executeForm($this->olvideContrasenaForm, 'olvide_contrasena')) {
            return;
        }
        
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $email = $this->olvideContrasenaForm->getValue('email');
        
        $usuario = usuarioTable::getInstance()->getByEmail($email, $idEshop );        
        
        if (!$usuario)
        {
            return sfView::ERROR;
        }
        
        $password = $this->generateRandomPassword();
        $usuario->setPassword($password);
        $usuario->setActivo(true);
        $usuario->setFechaConfirmacion(new Doctrine_Expression('NOW()'));
        $usuario->save();
		$mailer = new Mailer('resetContrasena', array(
		    'eshop'  => $eshop,
			'usuario' => $usuario,
		    'password' => $password,
		));
		$from = ( $usuario->getIdEshop() ) ? $usuario->getEshop()->getEmailNoReply() : sfConfig::get('app_email_from_noreply');
		$mailer->send('Has reseteado tu contraseña', $usuario->getEmail(), $from);
    }
    
    protected function generateRandomPassword()
    {
        return substr(md5(mt_rand()), 0, 8);
    }
    
    protected function login(usuario $usuario, $rememberMe = false)    
    {
        $this->getUser()->setCurrentUser($usuario);
        if ($rememberMe) {
            $this->getUser()->rememberMe();
        }        
    }

    protected function executeForm(sfForm $form, $flashName)
    {
        if ($this->getUser()->isAuthenticated()) {
            $this->redirect('homepage');
        }
        
        $request = $this->getRequest();

        if (!$request->isMethod('post')) {
            $this->redirect('usuario/index');
        }
        
        if (!$form->isValid())
        {
            $errors = $form->getErrorSchema();
            $this->getUser()->setFlash($flashName, (object) array(
                'tipo' => 'error',
                'mensaje' => $errors,
            ));
            $this->forward('usuario', 'index');
            return false;
        }
        return true;
    }
        
    protected function subscribe(usuario $usuario, $saveSource = true)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $email = $usuario->getEmail();
        
        if ( $eshop ) {
            $sexo = ( $eshop->getProductoGenero() == productoGenero::HOMBRE ) ? 'h' : 'm';
            $idEshop = $eshop->getIdEshop();
        } else {
            $sexo = $usuario->getSexo();
            $idEshop = null;
        }
        
        
	  	if ( newsletterTable::getInstance()->subscriberExist( $sexo, $email, $idEshop ) )
	  	{
	  	    return true;
	  	}
	  	
		$newsletter = new newsletter();
		$newsletter->setNombre($nombre);
		$newsletter->setApellido($apellido);
		$newsletter->setSexo($sexo);
		$newsletter->setEmail($email);
		$newsletter->setIdEshop( $idEshop );
		
		if ( $saveSource )
		{
    		$data = $this->getContext()->getRequest()->getCookie(usuario::USER_SOURCE);
    		
    		if ( $data !== null )
    		{
    		    $data = json_decode( base64_decode( $data ), true );
    		    
    		    $newsletter->setSource( $data['source'] );
    		    $newsletter->setFechaSource( $data['fecha'] );
    		    $newsletter->setUtmCampaign( $data['utmCampaign'] );
    		    $newsletter->setUtmTerm( $data['utmTerm'] );
    		}
		}
		
		return $newsletter->suscribir();
    }
    
    protected function enviarEmailActivacion(usuario $usuario, $referrer)
    {
        if ( $usuario->getIdEshop() ) {
            $eshop = $usuario->getEshop();
            $from = $eshop->getEmailNoReply();
        } else {
            $eshop = false;
            $from = sfConfig::get('app_email_from_noreply');
        }
        
        $datos = array('eshop' => $eshop, 'usuario' => $usuario, 'referrer' => $referrer);
		$mailer = new Mailer('nuevoUsuario', $datos);
		$mailer->send('Bienvenido ' . $usuario->getNombre(), $usuario->getEmail(), $from);
    }
}
