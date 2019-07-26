<?php

class eshopConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {

  }
  
  public function initialize()
  {
     $host = $_SERVER['HTTP_HOST'];
      
     sfConfig::set('app_host', 'http://' . $host);
      
     if ( strtolower( sfConfig::get('sf_environment') ) == 'dev' ) {
         sfConfig::set('app_host', 'http://' . $host);
     }
  }

  public function getTemplateDirs($moduleName)
  {
    $dirs = array();

    $device = false;
    if ( $moduleName != 'mails' ) {
      $device = deviceHelper::getInstance()->getDevice();
    }

    $devicePath = ( $device ) ? '/' . $device : '';

    $dirs[] = sfConfig::get('sf_app_module_dir').'/'.$moduleName.'/templates' . $devicePath;                  // application
    $dirs = array_merge($dirs, $this->getPluginSubPaths('/modules/'.$moduleName.'/templates'));               // plugins
    $dirs[] = $this->getSymfonyLibDir().'/controller/'.$moduleName.'/templates';                              // core modules
    $dirs[] = sfConfig::get('sf_module_cache_dir').'/auto'.ucfirst($moduleName.'/templates' . $devicePath);   // generated templates in cache

    return $dirs;
  }


  
}
