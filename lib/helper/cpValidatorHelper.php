<?php
/**
 * 
 * Validate a Cp given the location, state and cpNumber
 * 
 * @package helper
 * @author rgonzalez
 *
 */
class cpValidatorHelper
{
	static protected $instance;

	protected function __construct()
	{
	}

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}

		return self::$instance;
	}
	
	/**
	 *
	 * Validate postal code
	 * 
	 * @param int $state
	 * @param int $cpNumber
	 * @return boolean
	 */
	public function validate($state, $cpNumber)
	{
		return codigoPostalTable::getInstance()->getCpByState($state, $cpNumber);
	}
	
}