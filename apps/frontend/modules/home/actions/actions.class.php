<?php

/**
 * home actions.
 *
 * @package    deluxebuys
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends abstractHomeActions
{
 
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $items = homeHelper::getInstance()->getItems();
        $itemDestacado = array_shift($items);

        $this->proximasCampanas = campanaTable::getInstance()->listProximas();
        $this->banners = bannerTable::getInstance()->homeBanners();

        $this->items = $items;

        $this->bannerDestacado = ( $itemDestacado['tipo'] == 'bannerPrincipal' ) ? $itemDestacado['item'] : false;
        $this->campanaDestacada = ( $itemDestacado['tipo'] == 'campana' ) ? $itemDestacado['item'] : false;
        $this->outletDestacado = ( $itemDestacado['tipo'] == 'outlet' ) ? $itemDestacado['item'] : false;

        $this->bannerAlPie = configuracionTable::getInstance()->find( configuracion::HOME_BANNER_PIE );
    }

}