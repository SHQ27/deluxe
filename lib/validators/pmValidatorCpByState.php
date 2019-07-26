<?php
/**
 *
 * @package    symfony
 * @subpackage validator
 * @author rgonzalez
 */
class pmValidatorCpByState extends sfValidatorBase
{

	/**
	 * 
	 * Available options:
   	 *
     *  * key:  An string wich determine the State Key to be searched on the POST array
     *  *       to be able to validate the CP
     *  * form: The name of the form. 
     *  
     * @param array $options    An array of options
     * @param array $messages   An array of error messages
     *
     * @see sfValidatorBase
	 */
	protected function configure($options = array(), $messages = array())
	{
		$this->addRequiredOption('key');
		$this->addRequiredOption('form');
	}

	protected function doClean($cpNumber)
	{
		$provinciaKey = $this->getOption('key');
		$form = $this->getOption('form');
		$state = $_POST[$form][$provinciaKey];
		
		if (!cpValidatorHelper::getInstance()->validate($state, $cpNumber))
		{
			throw new sfValidatorError($this, 'El codigo postal no coincide con la provincia seleccionada');
		}
		
		return $cpNumber;
	}
	
}
