<?php

/**
 * formulario actions.
 *
 * @package    deluxebuys
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class formularioActions extends deluxebuysActions
{
 
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $campos = json_decode($eshop->getFormularioCampos(), true);

	  	$form = new eshopFormularioForm($campos);
	  	
	    if( $request->isMethod('post') )
	  	{
	  		$form->bind( $request->getParameter('eshopFormularioForm') );

	  		if ( $form->isValid() )
	  		{
	  			$form->send();
	  			$this->getUser()->setFlash('mensaje', 'El mensaje se envió correctamente.');
	  			$this->redirect('formulario');
	  			exit;
	  		}
	  		
	  	}  	
	  	
	  	$this->form = $form;
	  	$this->eshop = $eshop;
	  	$this->campos = $campos;
    }

}