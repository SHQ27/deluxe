<?php

/**
 * home actions.
 *
 * @package    deluxebuys
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
 
  public function executeOrdenar(sfWebRequest $request)
  {
    // Form
    $form = new ordenarHomeForm();

    if( $request->isMethod('post') )
    {
      
      $form->bind( $request->getParameter('ordenarHome') );

      if ( $form->isValid() ) 
      {
        $form->save();

        cacheHelper::getInstance()->deleteByPrefix('campana_listVigentes');
        cacheHelper::getInstance()->deleteByPrefix('bannerPrincipal_listVigentes');
        cacheHelper::getInstance()->delete('configuracion_getOutlet');
        cacheHelper::getInstance()->deleteByPrefix( sfConfig::get('app_cache_templatesFrontendPrefix') ) ;

        $this->getUser()->setFlash('notice', 'Se actualizaron los ordenes correctamente.');
        $this->redirect( $this->getController()->genUrl( array('sf_route' => 'home_ordenar')));
      }
    }
  
    $items = homeHelper::getInstance()->getItems(7);

    // Variables de template
    $this->items = $items;
    $this->form = $form;
  }

}