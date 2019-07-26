<?php

require_once dirname(__FILE__).'/../lib/descuentosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/descuentosGeneratorHelper.class.php';

/**
 * descuentos actions.
 *
 * @package    deluxebuys
 * @subpackage descuentos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class descuentosActions extends autoDescuentosActions
{
    /**
     * Executes generar action
     *
     * @param sfRequest $request A request object
     */
    public function executeGenerar(sfWebRequest $request)
    {
        $form = new descuentoGenerarForm();
                
        if( $request->isMethod('post') )
        {
            $form->bind( $request->getParameter('descuentoGenerar') );
        
            if ( $form->isValid() )
            {
                $this->result = $form->generar();
            }
        
        }
        
        $this->form = $form;
    }
    
    /**
     * Executes generar action
     *
     * @param sfRequest $request A request object
     */
    public function executeEliminarNoVendidos(sfWebRequest $request)
    {
        $form = new descuentoEliminarNoVendidosForm();
    
        if( $request->isMethod('post') )
        {
            $form->bind( $request->getParameter('descuentoEliminarNoVendidos') );
                
            if ( $form->isValid() )
            {
                $this->result = $form->eliminar();
            }
        }
    
        $this->form = $form;
    }
    
}
    