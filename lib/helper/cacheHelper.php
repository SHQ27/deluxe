<?php

class cacheHelper
{
    CONST SALT = 'D3LUX3-C4CH3';
    
	static protected $instance;
	
	protected $config;
	protected $cacheDriver;

	protected function __construct()
	{
	    $manager = Doctrine_Manager::getInstance();
	    $this->cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new cacheHelper();
		}
		
		return self::$instance;
	}
	
	public function genKey($key)
	{
	    return sha1($key . self::SALT);
	}
	
	public function delete($key)
	{
	    $this->cacheDriver->delete( cacheHelper::getInstance()->genKey( $key ) );
	}
	
	public function set($key, $value, $ttl = null)
	{
	    $expiration = 0;
	    if ( $ttl !== null ) {
	        $expiration = time() + $ttl;
	    }
	    
	    $this->cacheDriver->set( $key, $value, $expiration);
	}
	
	public function deleteByPrefix($key)
	{
	    $this->cacheDriver->deleteByPrefix( $key );
	}
	
	public function get($key)
	{
	    return $this->cacheDriver->get( $key );
	}

	public function clearListados()
	{
		$this->cacheDriver->deleteByPrefix( sfConfig::get('app_cache_templatesFrontendPrefix') ) ;
		$this->cacheDriver->deleteByPrefix( sfConfig::get('app_cache_templatesEshopPrefix') ) ;
	    $this->cacheDriver->deleteByPrefix( sfConfig::get('app_cache_listadosPrefix') ) ;
	}
	
	public function getStaticVersion()
	{
	    $staticVersion = @file_get_contents( sfConfig::get('sf_temp_dir') . '/static-version.number' );
	    
	    $staticVersion = ( $staticVersion ) ? $staticVersion : time();
	    
	    return trim($staticVersion);
	}

}



