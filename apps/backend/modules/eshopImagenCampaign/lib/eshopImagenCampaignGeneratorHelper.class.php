<?php

/**
 * eshopImagenCampaign module helper.
 *
 * @package    deluxebuys
 * @subpackage eshopImagenCampaign
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopImagenCampaignGeneratorHelper extends BaseEshopImagenCampaignGeneratorHelper
{
    public function linkToNew($params)
    {
        return '<li class="sf_admin_action_new">'.link_to(__($params['label'], array(), 'sf_admin'), url_for($this->getUrlForAction('new')) . '?id_eshop=' . $_GET["id_eshop"] ).'</li>';
    }
    
    public function linkToEdit($object, $params)
    {
        return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), url_for($this->getUrlForAction('edit'), $object) . '?id_eshop=' . $_GET["id_eshop"] ).'</li>';
    }
    
    public function linkToList($params)
    {
        $idEshop = (isset($params["id_eshop"]))? $params["id_eshop"] : $_GET["id_eshop"];        
        return '<li class="sf_admin_action_list">'.link_to(__($params['label'], array(), 'sf_admin'), url_for($this->getUrlForAction('list')) . '?id_eshop=' . $idEshop ).'</li>';
    }
    
    public function linkVolver()
    {
        return '<li class="sf_admin_action_list">'.link_to("Volver al listado de eShops", '/backend/eshops' ).'</li>';
    }
}
