<?php

require_once dirname(__FILE__).'/../lib/talleSetsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/talleSetsGeneratorHelper.class.php';

/**
 * talleSets actions.
 *
 * @package    deluxebuys
 * @subpackage talleSets
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class talleSetsActions extends autoTalleSetsActions
{
    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $clone = $request->hasParameter('_clone');
        $form->setOption('clone', $clone);

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        
        if ($form->isValid())
        {
            $notice = $form->getObject()->isNew() ? 'El Set de Talles se ha creado satisfactoriamente.' : 'El Set de Talles se ha editado satisfactoriamente.';
    
            try
           {
                $talle_set = $form->save();
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
    
            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $talle_set)));

            
            if ($request->hasParameter('_save_and_add'))
            {
                $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
            
                $this->redirect('@talle_set_new');
            }
            elseif ($request->hasParameter('_clone'))
            {
                $this->redirect(array('sf_route' => 'talle_set_edit', 'sf_subject' => $talle_set));
            }
            else
            {
                $this->getUser()->setFlash('notice', $notice);
            
                $this->redirect(array('sf_route' => 'talle_set_edit', 'sf_subject' => $talle_set));
            }
        }
        else
        {
            $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
        }
    }
}
