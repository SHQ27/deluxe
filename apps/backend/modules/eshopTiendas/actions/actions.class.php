<?php

require_once dirname(__FILE__).'/../lib/eshopTiendasGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eshopTiendasGeneratorHelper.class.php';

/**
 * eshopTiendas actions.
 *
 * @package    deluxebuys
 * @subpackage eshopTiendas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopTiendasActions extends autoEshopTiendasActions
{
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
    
        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    
        $eshopTiendas = $this->getRoute()->getObject();
    
        if ($eshopTiendas->delete())
        {
            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }
    
        $this->redirect('/backend/eshopTiendas?id_eshop=' . $eshopTiendas->getIdEshop() );
    }
    
    public function executeFilter(sfWebRequest $request)
    {
        $idEshop = $_GET['id_eshop'];
    
        $this->setPage(1);
    
        if ($request->hasParameter('_reset'))
        {
            $this->setFilters($this->configuration->getFilterDefaults());
    
            $this->redirect('/backend/eshopTiendas?id_eshop=' . $idEshop );
        }
    
        $this->filters = $this->configuration->getFilterForm($this->getFilters());
    
        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());
    
            $this->redirect('/backend/eshopTiendas?id_eshop=' . $idEshop );
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
    
            $this->redirect('/backend/eshopTiendas?id_eshop=' . $idEshop );
        }
    
        if (!$action = $request->getParameter('batch_action'))
        {
            $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');
    
            $this->redirect('/backend/eshopTiendas?id_eshop=' . $idEshop );
        }
    
        if (!method_exists($this, $method = 'execute'.ucfirst($action)))
        {
            throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
        }
    
        if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
        {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
    
        $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'eshopTiendas'));
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
    
        $this->redirect('/backend/eshopTiendas?id_eshop=' . $idEshop );
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
                $eshop_tienda = $form->save();
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
    
            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $eshop_tienda)));
    
            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
    
                $this->redirect('/backend/eshopTiendas/new?id_eshop=' . $idEshop );
            }
            else
            {
                $this->getUser()->setFlash('notice', $notice);
    
                $this->redirect(array('sf_route' => 'eshop_tienda_edit', 'sf_subject' => $eshop_tienda));
            }
        }
        else
        {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }
}
