<?php

require_once dirname(__FILE__).'/../lib/eshopImagenCampaignGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eshopImagenCampaignGeneratorHelper.class.php';

/**
 * eshopImagenCampaign actions.
 *
 * @package    deluxebuys
 * @subpackage eshopImagenCampaign
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopImagenCampaignActions extends autoEshopImagenCampaignActions
{
    protected function executeBatchActivar(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        foreach ($ids as $id)
        {
            $eshopImagenCampaign = eshopImagenCampaignTable::getInstance()->findOneByIdEshopImagenCampaign($id);
            $eshopImagenCampaign->setActivo(true);
            $eshopImagenCampaign->save();
        }
        
        $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $eshopImagenCampaign->getIdEshop() );
    }
    
    protected function executeBatchDesactivar(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        foreach ($ids as $id)
        {
            $eshopImagenCampaign = eshopImagenCampaignTable::getInstance()->findOneByIdEshopImagenCampaign($id);
            $eshopImagenCampaign->setActivo(false);
            $eshopImagenCampaign->save();
        }
        
        $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $eshopImagenCampaign->getIdEshop() );
    }
    
    public function executeBajar(sfWebRequest $request)
    {
        $eshopImagenCampaign = $this->getRoute()->getObject();
    
        $currentOrden = $eshopImagenCampaign->getOrden();
        $eshopImagenCampaignAnterior = eshopImagenCampaignTable::getInstance()->getPrev( $eshopImagenCampaign->getIdEshop(), $eshopImagenCampaign->getOrden() );
    
        $ordenAnterior = $eshopImagenCampaignAnterior->getOrden();
    
        //intercambio los ordenes
        $eshopImagenCampaignAnterior->setOrden($currentOrden);
        $eshopImagenCampaignAnterior->save();
    
        $eshopImagenCampaign->setOrden($ordenAnterior);
    
        $eshopImagenCampaign->save();
        $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $eshopImagenCampaign->getIdEshop() );
    }
    
    public function executeSubir(sfWebRequest $request)
    {
        $eshopImagenCampaign = $this->getRoute()->getObject();
    
        $currentOrden = $eshopImagenCampaign->getOrden();
        $eshopImagenCampaignSiguiente = eshopImagenCampaignTable::getInstance()->getNext( $eshopImagenCampaign->getIdEshop(), $eshopImagenCampaign->getOrden() );
        $ordenSiguiente = $eshopImagenCampaignSiguiente->getOrden();
    
        //intercambio los ordenes
        $eshopImagenCampaignSiguiente->setOrden($currentOrden);
        $eshopImagenCampaignSiguiente->save();
    
        $eshopImagenCampaign->setOrden($ordenSiguiente);
    
        $eshopImagenCampaign->save();
        $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $eshopImagenCampaign->getIdEshop() );
    }
    
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
    
        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    
        $eshopImagenCampaign = $this->getRoute()->getObject();
    
        if ($eshopImagenCampaign->delete())
        {
            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }
    
        $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $eshopImagenCampaign->getIdEshop() );
    }
    
    
    public function executeFilter(sfWebRequest $request)
    {
        $idEshop = $_GET['id_eshop'];
        
        $this->setPage(1);
    
        if ($request->hasParameter('_reset'))
        {
            $this->setFilters($this->configuration->getFilterDefaults());
    
            $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $idEshop );
        }
    
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
    
        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());
    
            $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $idEshop );
        }
    
        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
    
        $this->setTemplate('index');
    }
    
    public function executeBatch(sfWebRequest $request)
    {
        $idEshop = $_GET['id_eshop'];
        
        $request->checkCSRFProtection();
    
        if (!$ids = $request->getParameter('ids'))
        {
            $this->getUser()->setFlash('error', 'You must at least select one item.');
    
            $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $idEshop );
        }
    
        if (!$action = $request->getParameter('batch_action'))
        {
            $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');
    
            $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $idEshop );
        }
    
        if (!method_exists($this, $method = 'execute'.ucfirst($action)))
        {
            throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
        }
    
        if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
        {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
    
        $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'eshopImagenCampaign'));
        try
        {
            // validate ids
            $ids = $validator->clean($ids);
    
            // execute batch
            $this->$method($request);
        }
        catch (sfValidatorError $e)
        {
            $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
        }
    
        $this->redirect('/backend/eshopImagenCampaign?id_eshop=' . $idEshop );
    }
    
    
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $params = $request->getParameter($form->getName());
        
        $idEshop = $params['id_eshop'];
        
        $form->bind($params, $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
    
            try {
                $eshop_imagen_campaign = $form->save();
            } catch (Doctrine_Validator_Exception $e) {
    
                $errorStack = $form->getObject()->getErrorStack();
    
                $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
                foreach ($errorStack as $field => $errors) {
                    $message .= "$field (" . implode(", ", $errors) . "), ";
                }
                $message = trim($message, ', ');
    
                $this->getUser()->setFlash('error', $message);
                return sfView::SUCCESS;
            }
    
            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $eshop_imagen_campaign)));
                
            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
    
                $this->redirect('/backend/eshopImagenCampaign/new?id_eshop=' . $idEshop );
            }
            else
            {
                $this->getUser()->setFlash('notice', $notice);
    
                $this->redirect(array('sf_route' => 'eshop_imagen_campaign_edit', 'sf_subject' => $eshop_imagen_campaign));
            }
        }
        else
        {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }

      protected function doSave($con = null)
      {     
        $eshopImagenCampaign = $this->getObject();
            
        $notice = $eshopImagenCampaign->isNew() ? 'El nuevo elemento se creó correctamente.' : 'El elemento fue modificado.';
                        
        $this->updateObject();

        $eshopImagenCampaign->save($con);
        
        $this->message = $notice;
            
      }
}
