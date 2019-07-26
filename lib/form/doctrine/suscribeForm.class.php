<?php 

class suscribeForm extends sfForm
{
  public function configure()
  {
    $this->setValidators(array(
      'nombre' => new sfValidatorString(array('required' => true)),
      'apellido' => new sfValidatorString(array('required' => true)),
      'email' => new sfValidatorEmail(array('required' => true)),
    ));
    
    $this->disableCSRFProtection();
    
  }
}
