<?php

class arrayHelper
{
	static protected $instance;
	
	protected function __construct() { }
		
	public static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * 
	 * @param $object
	 * @return array
	 */
	public function toArray($obj)
	{
		if( is_object($obj) ) {
			$obj = (array) $obj;
		}
		if(is_array($obj)) {

			$new = array();
			foreach($obj as $key => $val) {

				$new[$key] = $this->toArray($val);
			}
		} else {
			$new = $obj;
		}
		
		return $new;       
	}
}
