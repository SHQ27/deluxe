<?php

/**
 *
 * @package    deluxebuys
 * @subpackage contacto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class abstractContactoActions extends deluxebuysActions
{	
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $comoComprar = $request->getParameter('comoComprar');
             
        $form = new contactoForm( array(), array('eshop' => $eshop) );
        $this->processForm( $request, $form );
    
        $categoria = null;
        $pregunta = null;
                
        if ( $comoComprar ) {
            $faqComoComprar = faqTable::getInstance()->getComoComprar( $idEshop );
            
            if ( $faqComoComprar ) {
                $categoria = $faqComoComprar->getIdFaqCategoria();
                $pregunta = $faqComoComprar->getIdFaq();   
            }
        }        
        
        $this->form = $form;
        $this->categoria = $categoria;
        $this->pregunta = $pregunta;

        $this->eshop = $eshop;
        
        $this->faqCategorias = faqCategoriaTable::getInstance()->listAll( $idEshop );        
    }
    
    protected function processForm($request, $form)
    {
        $havePost = $request->isMethod('post');
         
        if ( $havePost )
        {
            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
            $this->getUser()->setFlash('contactResult', $form->isValid());
    
            if ( $form->isValid() )
            {
                $this->getUser()->setFlash('mensaje', 'El mensaje se envió correctamente.');
    
                $form->sentToMail();
    
                $form->bind( array ($form->getCSRFFieldName() => $form->getCSRFToken()), $request->getFiles($form->getName()));
                $this->error = false;
            }
             
            else
            {
                $this->getUser()->setFlash('mensaje', 'Por favor asegúrese de completar los campos requeridos (*) con datos válidos.');
                $this->error = true;
            }
        }
    }	
}
