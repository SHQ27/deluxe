<?php

/**
 * sfGuardGroup form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardGroupForm extends PluginsfGuardGroupForm
{
  public function configure()
  {
      $choices = array();
      $permisos = sfGuardPermissionTable::getInstance()->listAllOrdered();
      foreach ( $permisos as $permiso )
      {
          $choices[$permiso->getId()] = $permiso->getDescription();
      }
      
      $this->setWidget('permissions_list', new sfWidgetFormSelect( array('choices' => $choices, 'multiple' => true) ) );
  }
}
