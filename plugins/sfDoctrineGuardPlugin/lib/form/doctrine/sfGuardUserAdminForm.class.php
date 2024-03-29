<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  /**
   * @see sfForm
   */
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
