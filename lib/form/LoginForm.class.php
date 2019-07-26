<?php

class LoginForm extends sfFormSymfony
{
    public function configure()
    {        
        $this->setWidgets(array(
            'email'    => new sfWidgetFormInput(array('label' => 'Email')),
            'password' => new sfWidgetFormInputPassword(array('label' => 'Contraseña')),
            'remember_me' => new sfWidgetFormInputCheckbox(array(), array('class' => 'check')),
        	'referrer' => new sfWidgetFormInputHidden(), 
        ));    
        
        $this->getWidget('remember_me')->setDefault(true);
     
        $this->setValidators(array(
        	'email'    => new sfValidatorEmail(array('required' => true)),
            'password' => new sfValidatorString(array('required' => true)),
            'remember_me' => new sfValidatorPass(),
        	'referrer' => new sfValidatorPass(),
        ));
     
        $this->widgetSchema->setNameFormat('login[%s]');
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
        	'callback' => array($this, 'login'),
        )));        
    }
    
    public function login($validator, $values)
    {
        $eshop = $this->getOption('eshop');
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $email = $values['email'];
        $pass = $values['password'];
        
        if ($email && $pass) {
            $user = usuarioTable::getInstance()->findOneByCredentials($email, $pass, $idEshop );
            if (!$user) {
                $mensaje = '<strong>El usuario o la contraseña son incorrectos.</strong><br/><br/>Si tenes dificultades para ingresar utilizá el proceso para <a class="olvidastePass">recuperar tu contraseña</a>';
                throw new sfValidatorError($validator, $mensaje);
            }
        }
        return $values;
    }
}