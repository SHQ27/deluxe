<?php

class deviceHelper
{
	static protected $instance;
	protected $isMobile;
	
	protected function __construct()
	{
		$mobileDetect = new Mobile_Detect();
		$this->isMobile = $mobileDetect->isMobile() && !$mobileDetect->isTablet();
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}

	public function isMobile()
	{
		if ( sfConfig::get('sf_app') == 'eshop' ) {
			return $this->isMobile;
		} else {
			return false;
		}
	}

	public function getDevice()
	{
    	return ( $this->isMobile() ) ? 'mobile' : 'desktop';
	}

	public function isDesktop()
	{
    	return !$this->isMobile();
	}

	public function getLayout()
	{
    	return $this->getDevice() . '/layout';
	}
}
