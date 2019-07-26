<?php

class swfHelper
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
            self::$instance = new swfHelper();
        }

        return self::$instance;
    }

    protected function getConfig()
    {
        if (!$this->config)
        {
            $this->config = sfYaml::load( sfConfig::get('sf_config_dir') . "/swf.yml");
        }

        return $this->config;
    }	

    public function getUrl($key, $object)
    {
        $config = $this->getConfig();

        return sfConfig::get('app_upload_url') . $config[ $key ]['path'] . '/' . $object->getSwfFilename();
    }

    public function getPath($key, $object = null)
    {
        $config = $this->getConfig();

        $path = sfConfig::get('sf_upload_dir') . $config[ $key ]['path'] . '/';

        if ($object) $path .= $object->getSwfFilename();

        return $path;
    }


    public function processSaveFile($key, $object, $file)
    {
        if (!$file) return;

        $path = $this->getPath( $key, $object );
        move_uploaded_file($file->getTempName(), $path);
        @chmod($path, 0777);
    }

    public function processDeleteFile($key, $object, $checkDeleteValue)
    {
        if ($checkDeleteValue) @unlink($this->getPath($key, $object));
    }

}