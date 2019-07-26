<?php

/**
 * talleSets module helper.
 *
 * @package    deluxebuys
 * @subpackage talleSets
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class talleSetsGeneratorHelper extends BaseTalleSetsGeneratorHelper
{
    public function linkToClone($object, $params)
    {
        return '<li class="sf_admin_action_clone"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_clone"  /></li>';
    }
}
