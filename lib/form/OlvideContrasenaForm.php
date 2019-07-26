<?php

class OlvideContrasenaForm extends sfForm
{
    public function configure()
    {
        $this->setWidget('email', new sfWidgetFormInputText());
        $this->setValidator('email', new sfValidatorEmail());
        $this->getWidgetSchema()->setNameFormat('olvide_contrasena[%s]');    
    }
}
