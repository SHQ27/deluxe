<?php

class pmValidatorProductoItem extends sfValidatorBase
{
  
  protected function configure($options = array(), $messages = array())
  {
  }

  protected function doClean($value)
  {      
  	$c = count($value['talle']);
  	$duplicateKey = array();
  	for( $i = 0 ; $i < $c ; $i++ )
  	{
  		$duplicateKey[$value['talle'][$i]['id'] . '-' . $value['color'][$i]['id']] = 1;
  	}
  		
  	if (count($duplicateKey) <> $c)
	{
		throw new sfValidatorError($this, 'Hay 2 o mas items para el mismo talle y color');
	}
	
    return $value;
  }
}
