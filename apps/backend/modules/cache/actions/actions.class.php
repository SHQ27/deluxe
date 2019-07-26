<?php

/**
 * cache actions.
 *
 * @package    deluxebuys
 * @subpackage cache
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cacheActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $this->type = $request->getParameter('type', false);
      $this->borrar = (bool) $request->getParameter('borrar', false);
      if ( $this->type == 'listados' && $this->borrar ) 
      {
          cacheHelper::getInstance()->deleteByPrefix('productoCategoria_listByIdProductoGenero');
          cacheHelper::getInstance()->clearListados();
      }
  }
}
