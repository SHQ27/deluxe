<?php


class pmValidatorDocumento extends sfValidatorBase
{

  protected function configure($options = array(), $messages = array())
  {
    $this->setMessage('invalid', 'Verificá que el formato sea correcto.');
  }

  protected function doClean($value)
  { 
  	$value = str_replace('.', '', $value);
  	
    if ( !preg_match('/^[0-9]{6,10}$/', $value) )
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }
    
    return $value;
  }
}