<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', 'Este campo es requerido.');
    sfValidatorBase::setDefaultMessage('invalid', 'Este campo es inválido.');      
  }
}
