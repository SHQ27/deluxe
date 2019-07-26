<?php

/**
 * campanas module configuration.
 *
 * @package    deluxebuys
 * @subpackage campanas
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class campanasGeneratorConfiguration extends BaseCampanasGeneratorConfiguration
{

  public function getPagerMaxPerPage()
  {
  	$esLogistica = stripos($_SERVER['REQUEST_URI'], 'logistica') !== false;
  	$filters = sfContext::getInstance()->getUser()->getAttribute('campanas.filters', $this->getFilterDefaults(), 'admin_module');
  	
    if ( !$esLogistica )             return 10;
    if ( isset($filters['marca']) )  return 10;

    return 5;
    
  }
}
