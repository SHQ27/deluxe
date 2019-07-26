<?php

require_once dirname(__FILE__).'/../lib/faqsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/faqsGeneratorHelper.class.php';

/**
 * faqs actions.
 *
 * @package    deluxebuys
 * @subpackage faqs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqsActions extends autoFaqsActions
{
    
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';
    
            try {
                $faq = $form->save();
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
    
            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $faq)));
    
            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
    
                $this->redirect('/backend/faqs/new?id_faq_categoria=' . $faq->getIdFaqCategoria() );
            }
            else
            {
                $this->getUser()->setFlash('notice', $notice);
    
                $this->redirect(array('sf_route' => 'faq_edit', 'sf_subject' => $faq));
            }
        }
        else
        {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }
    
    public function executeBajar(sfWebRequest $request)
    {
        $faq = $this->getRoute()->getObject();
    
        $currentOrden = $faq->getOrden();
        $faqAnterior = FaqTable::getInstance()->getPrev( $faq->getIdFaqCategoria(), $faq->getOrden() );
    
        $ordenAnterior = $faqAnterior->getOrden();
    
        //intercambio los ordenes
        $faqAnterior->setOrden($currentOrden);
        $faqAnterior->save();
    
        $faq->setOrden($ordenAnterior);
    
        $faq->save();
        $this->redirect('/backend/faqs?id_faq_categoria=' . $faq->getIdFaqCategoria() );
    }
    
    public function executeSubir(sfWebRequest $request)
    {
        $faq = $this->getRoute()->getObject();
    
        $currentOrden = $faq->getOrden();
        $faqSiguiente = FaqTable::getInstance()->getNext( $faq->getIdFaqCategoria(), $faq->getOrden() );
        $ordenSiguiente = $faqSiguiente->getOrden();
    
        //intercambio los ordenes
        $faqSiguiente->setOrden($currentOrden);
        $faqSiguiente->save();
    
        $faq->setOrden($ordenSiguiente);
    
        $faq->save();
        $this->redirect('/backend/faqs?id_faq_categoria=' . $faq->getIdFaqCategoria() );
    }
    
    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();
    
        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    
        if ($this->getRoute()->getObject()->delete())
        {
            $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        }
    
        $faq = $this->getRoute()->getObject();
        $this->redirect('/backend/faqs?id_faq_categoria=' . $faq->getIdFaqCategoria() );
    }
    
    protected function getSort()
    {
        return array('orden', 'asc');
    }
    
    protected function buildQuery()
    {
        $q = parent::buildQuery();
        $rootAlias = $q->getRootAlias();
        
        return $q->addWhere( $rootAlias . '.id_faq_categoria = ?', $_GET['id_faq_categoria']);
    }
}
