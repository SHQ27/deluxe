<?php

class imageHelper
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
			self::$instance = new imageHelper();
		}
		
		return self::$instance;
	}

	protected function getConfig()
	{
		if (!$this->config)
		{
			$this->config = sfYaml::load( sfConfig::get('sf_config_dir') . "/images.yml");
		}
		
		return $this->config;
	}	
	
	public function getUrl( $key, $object, $sufix = false )
	{
		$config = $this->getConfig();

		$filename = $object->getImageFilename();

		if ($sufix)
		{
		    $filename = str_replace('.jpg', '', $filename);
		    $filename .= '_' . $sufix;
		    $filename .= '.jpg';
		}
				
		return sfConfig::get('app_upload_url') . $config[ $key ]['path'] . '/' . $filename;
	}
	
	public function getPath( $key, $object = null, $sufix = false )
	{
		$config = $this->getConfig();
		
		$path = sfConfig::get('app_upload_dir') . $config[ $key ]['path'] . '/';

		if ($object) $path .= $object->getImageFilename();
		if ($sufix)
		{
		    $path = str_replace('.jpg', '', $path);
		    $path .= '_' . $sufix;
		    $path .= '.jpg';
		}

		return $path;
	}
		
	public function getOptionForWidget( $key, $object, $sufix = false)
	{		
		$config = $this->getConfig();
		$deleteable = $config[ $key ]['deleteable'];
		
		$options["is_image"] = true;
		$options["with_delete"] = $deleteable;
		$options["delete_label"] = 'Desea eliminar este archivo?';		
		$options["template"] = '<p>%input%</p><p>%file%</p><p>%delete% %delete_label%</p>';

		$fileExists = file_exists( imageHelper::getInstance()->getPath($key, $object, $sufix) );
		$url = ( $fileExists ) ? imageHelper::getInstance()->getUrl($key, $object, $sufix) : '';
		$options["file_src"] = $url;
				
		return $options;		
	}
	
	public function getOptionForValidator( $key, $object, $sufix = false)
	{		
		$config = $this->getConfig();
		$required = !$config[ $key ]['deleteable'];
		
		if ($required)
		{
			$options["required"] = !file_exists( imageHelper::getInstance()->getPath($key, $object, $sufix) );
		}
		else
		{
			$options["required"] = false;
		}
		
		
		$options["path"] = '/tmp';
		
		return $options;		
	}
	
	public function getMessagesForValidator( $key )
	{		
		$config = $this->getConfig();
		if (!$config[ $key ]['deleteable']) return array('required' => 'No ha seleccionado una imagen.');
		return array();
	}
	
	public function processSaveFile( $key, $object, $file, $savePath = null, $sufix = false )
	{
		if (!$file) return;

		$file = ( is_object($file) )? $file->getTempName() : $file;
				
		$tmpfile = tempnam(sys_get_temp_dir(), "upload_image_");		
		$config = $this->getConfig();

		$resize  = $config[ $key ]['resize'];
		$crop  = $config[ $key ]['crop'];
		
		if ( !$savePath )
		{
		    $savePath = $this->getPath( $key, $object );
		}

		if ( $sufix ) {
			$savePath = $this->getPath( $key, $object, $sufix );
		}
		 
		if ( $resize ) {
			$thumbnail = new sfThumbnail( $config[ $key ]['width'], $config[ $key ]['height'], true, true, 95, 'sfGDAdapter');
			$thumbnail->loadFile( $file );
			$thumbnail->save( $tmpfile, $config[ $key ]['mime_type']);
			copy($tmpfile, $savePath);
		} else if ( $crop ) {
			$originalWidth  = $config[ $key ]['original_width'];
			$originalHeight = $config[ $key ]['original_height'];
			$thumbnail = new sfCrop( $config[ $key ]['width'], $config[ $key ]['height'], 0, 0, $originalWidth, $originalHeight, false);
			$thumbnail->loadFile( $file );
			$thumbnail->save( $tmpfile, $config[ $key ]['mime_type']);
			copy($tmpfile, $savePath);
		} else {
			copy($file, $savePath);
		}

		@chmod($savePath, 0777);
		unlink($tmpfile);
	}
	
	public function copy( $key, $objectSource, $objectDest)
	{
	    $source = imageHelper::getInstance()->getPath($key, $objectSource);
	    $dest = imageHelper::getInstance()->getPath($key, $objectDest);
	    @copy($source, $dest);
	}
	
	public function processDeleteFile( $key, $object, $checkDeleteValue, $sufix = false )
	{
		if ($checkDeleteValue) @unlink($this->getPath($key, $object, $sufix));
	}
	
	public function getWidth( $key )
	{
	    $config = $this->getConfig();
	    return $config[ $key ]['width'];
	}
	
	public function getHeight( $key )
	{
	    $config = $this->getConfig();
	    return $config[ $key ]['height'];
	}

	public function exists( $url ) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $code === 200;
	}
}



