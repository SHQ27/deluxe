<?php

class stringHelper
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
	 * @param string $string
	 * @return string
	 */
	public function slug($string)
	{
    	return strtolower(trim(preg_replace(array('~[^0-9a-z]~i', '~-+~'), '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'))), '-'));
	}

	public function removeQueryStringVar($url, $key)
	{
		$url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
		return $url;
	}

	public function quitarAcentos($cadena){
	    $originales  = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $cadena = utf8_decode($cadena);
	    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	    $cadena = strtolower($cadena);
	    return utf8_encode($cadena);
	}


}
