<?php

/**
 * eshops module helper.
 *
 * @package    deluxebuys
 * @subpackage eshops
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopsGeneratorHelper extends BaseEshopsGeneratorHelper
{
    public function linkToNew($params)
    {
        return '';
    }
    
    public function linkToEdit($object, $params)
    {
        return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object).'</li>';
    }
    
    public function linkToDelete($object, $params)
    {
        return '';
    }
}
