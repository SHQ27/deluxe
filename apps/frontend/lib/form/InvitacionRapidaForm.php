<?php

class InvitacionRapidaForm extends sfForm
{
    const TOTAL_INPUTS = 20;
    
    public function configure()
    {
        $emailWidgets = array();
        $emailValidators = array();
        for ($i = 0; $i < self::TOTAL_INPUTS; $i++) {
            $emailWidgets[] = new sfWidgetFormInputText();
            $emailValidators[] = new sfValidatorEmail(array('required' => false));
        }
        $this->setWidget('emails', new sfWidgetFormSchema($emailWidgets));
        $this->setValidator('emails', new sfValidatorSchema($emailValidators));
        $this->getWidgetSchema()->setNameFormat('invitacion_rapida[%s]');
    }
}
