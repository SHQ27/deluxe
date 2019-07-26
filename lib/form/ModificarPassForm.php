<?php

class ModificarPassForm extends sfFormDoctrine
{
    public function configure()
    {
        $this->setWidgets(array(
            'old' => new sfWidgetFormInputPassword(),
            'new' => new sfWidgetFormInputPassword(),
        ));
        $this->setValidators(array(
            'old' => new sfValidatorString(),
            'new' => new sfValidatorString(),        
        ));
        $this->widgetSchema->setNameFormat('modificar_pass[%s]');
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
        	'callback' => array($this, 'checkCurrentPassword'),
        )));        
    }
    
    public function checkCurrentPassword($validator, $values)
    {
        $old = $values['old'];
        if ($old) {
            $current = sfContext::getInstance()->getUser()->getCurrentUser()->getPassword();
            if (usuario::hashPassword($old) != $current) {                
                $mensaje = 'La contraseña actual es incorrecta';
                throw new sfValidatorError($validator, $mensaje);
            }
        }
        return $values;
    }    
    
    public function getModelName()
    {
        return 'usuario';
    }    
}