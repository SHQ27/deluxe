<?php

class formatHelper
{
	static protected $instance;
	
	protected $config;

	protected function __construct()
	{
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new formatHelper();
		}
		
		return self::$instance;
	}

	public function decimalNumber($number)
	{
		$numberFormat = new sfNumberFormat( sfContext::getInstance()->getUser()->getCulture() );
		$number = sprintf('%1.2f', $number);
		return $numberFormat->format( $number );
	}	
	
	public function formatPrice($number)
	{
		return number_format($number, 0, "", ",");
	}

}



