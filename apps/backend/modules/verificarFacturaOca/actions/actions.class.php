<?php
/**
 * verificarFacturaOca actions.
 *
 * @package    deluxebuys
 * @subpackage verificarFacturaOca
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class verificarFacturaOcaActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $form = new verificarFacturaOcaForm();
        
        if( $request->isMethod('post') )
        {
        	$form->bind( $request->getParameter($form->getName()), $request->getFiles($form->getName()) );
        	
        	if ( $form->isValid() )
        	{
        	    $this->data = $form->verificar();
        	}
        }
        
        $this->verificarFacturaOcaForm = $form;
    }
}
