<?php

class miCuentaComponents extends abstractMiCuentaComponents
{
    public function executeInvitar()
    {
        $this->result = 'Success';
        
        $request = $this->getRequest();
        
        $this->invitacionRapidaForm = new InvitacionRapidaForm();
        
        if ($request->isMethod('post')) {      
            
            $invitacionRapidaParams = $request->getParameter('invitacion_rapida');
            if ($invitacionRapidaParams) {
                $this->invitacionRapidaForm->bind($invitacionRapidaParams);
                if ($this->invitacionRapidaForm->isValid()) {
                    $emails = $this->invitacionRapidaForm->getValue('emails');
                    $this->enviarInvitaciones($emails);
                }
            }

            $invitacionListadoParams = $request->getParameter('invitacion_listado');
            if ($invitacionListadoParams) {
                $contacts = unserialize($request->getParameter('contacts'));
                $this->invitacionListadoForm = new InvitacionListadoEmailsForm($contacts);
                $this->invitacionListadoForm->bind($invitacionListadoParams);
                if ($this->invitacionListadoForm->isValid()) {
                    $this->enviarInvitaciones($this->invitacionListadoForm->getValue('emails'));
                }
            }
        }
    }
    
    public function enviarInvitaciones(array $emails)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $from = ( $eshop ) ? $eshop->getEmailNoReply() : sfConfig::get('app_email_from_noreply');
        
        $usuario = $this->getUser()->getCurrentUser();
        $mailer = new Mailer('invitacion', array('usuario' => $usuario));
        $mailer->setLowPriority();
		foreach ($emails as $email) {
            $invitacionExistente = invitacionTable::getInstance()->findByEmail($email);
            if (!$email || $invitacionExistente) {
                continue;
            }
            $invitacion = invitacion::crear($usuario, $email);
            $mailer->setVar('invitacion', $invitacion);
            
            $subject = $usuario->getNombre().' '.$usuario->getApellido().' te invita a Deluxebuys: Shopping Online de Moda con descuentos únicos.';
            $mailer->send($subject, $email, $from);
            $invitacion->save();
        }
        $this->getUser()->setFlash('invitados_ok', true);
        $this->getController()->redirect('@mi_cuenta_invitados');             
    }
}