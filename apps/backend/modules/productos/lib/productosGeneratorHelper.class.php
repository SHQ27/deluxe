<?php

/**
 * productos module helper.
 *
 * @package    deluxebuys
 * @subpackage productos
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productosGeneratorHelper extends BaseProductosGeneratorHelper
{
	
  public function linkToSaveAndBackToList($object, $params)
  {
    return '<li class="sf_admin_action_save_and_add"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_go_to_list" /></li>';
  }
  
  public function linkToClone($object, $params)
  {
      return '<li class="sf_admin_action_clone"><input type="submit" value="'.__($params['label'], array(), 'sf_admin').'" name="_clone"  /></li>';
  }
	
}
