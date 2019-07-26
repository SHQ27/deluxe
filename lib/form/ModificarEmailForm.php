<?php

class ModificarEmailForm extends sfFormDoctrine
{
    public function configure()
    {
        $eshop = $this->getOption('eshop');
        
        $this->setWidget('email', new sfWidgetFormInputText( array(), array('maxlength' => 50)));
        $this->setValidator('email', new sfValidatorEmail(array('max_length' => 50, 'required' => true)));
        
        $this->widgetSchema->setNameFormat('modificar_email[%s]');
        
        $this->validatorSchema->setPostValidator( new pmValidatorUsuarioUnique( array('eshop' => $eshop) ) );        
        
    }
    
    public function getModelName()
    {
        return 'usuario';
    }    
}