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
        $eshop = eshopTable::getInstance()->getCurrent();

        $this->eshopHomes = eshopHomeTable::getInstance()->listHome( $eshop->getIdEshop() );
        $this->productosDestacados = productoTable::getInstance()->listDestacadosEnHomeByIdEshop( $eshop->getIdEshop() );
        $this->eshop = $eshop;
    }

}