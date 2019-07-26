<?php

class backendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
      set_include_path(sfConfig::get('sf_lib_dir')  . PATH_SEPARATOR . get_include_path());
      require_once 'Zend/Loader/Autoloader.php';
  }
  
  public function initialize()
  {
	  $cacheTime = 24 * 30 * 60 * 60;
      S3StreamWrapper::setMetadata(array(
          Zend_Service_Amazon_S3::S3_ACL_HEADER => Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ,
          'Cache-Control' => 'max-age=' . $cacheTime,
          'Expires' => gmdate("D, d M Y H:i:s", time() + $cacheTime),
      ));
      
      $s3 = new Zend_Service_Amazon_S3(sfConfig::get('app_aws_key'), sfConfig::get('app_aws_secret_key'));
      S3StreamWrapper::register($s3);
      
      sfConfig::set('sf_upload_dir', sfConfig::get('app_upload_dir'));
      
      ini_set('session.gc_maxlifetime', 3600);
  }
}
