<?php

class dirHelper
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
			self::$instance = new dirHelper();
		}
		
		return self::$instance;
	}

    public function rrmdir($path)
    {
        return is_file($path)? @unlink($path): array_map(array($this, 'rrmdir'),glob($path.'/*')) == @rmdir($path);
    }

}