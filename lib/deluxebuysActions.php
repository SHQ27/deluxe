<?php


class deluxebuysActions extends sfActions
{
  public function preExecute()
  {
  	if ( sfConfig::get('sf_app') === 'eshop' ) {
  		$this->setLayout( deviceHelper::getInstance()->getLayout() );	
  	}
    
  }
}
