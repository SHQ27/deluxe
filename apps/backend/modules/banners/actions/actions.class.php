<?php

require_once dirname(__FILE__).'/../lib/bannersGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/bannersGeneratorHelper.class.php';

/**
 * banners actions.
 *
 * @package    deluxebuys
 * @subpackage banners
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannersActions extends autoBannersActions
{
	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind( $request->getParameter($form->getName()), $request->getFiles($form->getName()));
        
    if ($form->isValid())
    {
      try
      {
        $banner = $form->save();
		$notice = $form->getMessage();
        
      }
      catch (Doctrine_Validator_Exception $e)
      {
        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $banner)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@banner_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'banner_edit', 'sf_subject' => $banner));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }
  
  protected function executeBatchActivar(sfWebRequest $request)
  {
      $ids = $request->getParameter('ids');
      foreach ($ids as $idBanner)
      {
          $banner = bannerTable::getInstance()->findOneByIdBanner($idBanner);
          $banner->setActivo(true);
          $banner->save();
      }
  }
  
  protected function executeBatchDesactivar(sfWebRequest $request)
  {
      $ids = $request->getParameter('ids');
      foreach ($ids as $idBanner)
      {
          $banner = bannerTable::getInstance()->findOneByIdBanner($idBanner);
          $banner->setActivo(false);
          $banner->save();
      }
  }
  
  public function executeBajar(sfWebRequest $request)
  {
      $banner = $this->getRoute()->getObject();
  
      $currentOrden = $banner->getOrden();
      $bannerAnterior = BannerTable::getInstance()->getPrev( $banner->getOrden() );
  
      $ordenAnterior = $bannerAnterior->getOrden();
  
      //intercambio los ordenes
      $bannerAnterior->setOrden($currentOrden);
      $bannerAnterior->save();
  
      $banner->setOrden($ordenAnterior);
  
      $banner->save();
      $this->redirect('@banner');
  }
  
  public function executeSubir(sfWebRequest $request)
  {
      $banner = $this->getRoute()->getObject();
  
      $currentOrden = $banner->getOrden();
      $bannerSiguiente = BannerTable::getInstance()->getNext( $banner->getOrden() );
      $ordenSiguiente = $bannerSiguiente->getOrden();
  
      //intercambio los ordenes
      $bannerSiguiente->setOrden($currentOrden);
      $bannerSiguiente->save();
  
      $banner->setOrden($ordenSiguiente);
  
      $banner->save();
      $this->redirect('@banner');
  }
  
  protected function addSortQuery($query)
  {
      $query->addOrderBy('orden desc');
  }
	
}
