<?php

/**
 * campaign actions.
 *
 * @package    deluxebuys
 * @subpackage campaign
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class campaignActions extends deluxebuysActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$eshop = eshopTable::getInstance()->getCurrent();
  	$this->eshopImagenCampaignsSlide = eshopImagenCampaignTable::getInstance()->listCampaign( $eshop->getIdEshop(), true );
  	$this->eshopImagenCampaignsNoSlide = eshopImagenCampaignTable::getInstance()->listCampaign( $eshop->getIdEshop(), false );
  }
}
