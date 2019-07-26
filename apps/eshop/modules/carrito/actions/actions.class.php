<?php

/**
 * carrito actions.
 *
 * @package    deluxebuys
 * @subpackage carrito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class carritoActions extends abstractCarritoActions
{

    /**
     * Executes paso1 actions
     *
     * @param sfRequest $request A request object
     */
    public function executePaso1(sfWebRequest $request)
    {
        $this->eshop = eshopTable::getInstance()->getCurrent();

        // Creo el paso 1
        $this->createPaso1($request);
    }
    
    /**
     * Executes paso2 actions
     *
     * @param sfRequest $request A request object
     */
    public function executePaso2(sfWebRequest $request)
    {
        $this->eshop = eshopTable::getInstance()->getCurrent();

        // Creo el paso 2
        $this->createPaso2($request);
    }
    
    /**
     * Executes paso3 actions
     *
     * @param sfRequest $request A request object
     */
    public function executePaso3(sfWebRequest $request)
    {
        $this->eshop = eshopTable::getInstance()->getCurrent();

          // Creo el paso 3
          $this->createPaso3($request);
          
          $session = sessionTable::getInstance()->getSession();
          $this->tieneOutlet = sessionTable::getInstance()->hayOutlet( $session->getIdSession() );
    }
    

    /**
     * Executes generarPedido action
     *
     * @param sfRequest $request A request object
     */
    public function executeGenerarPedido(sfWebRequest $request)
    {            
        $this->eshop = eshopTable::getInstance()->getCurrent();

        // Genero el pedido
        $this->createGenerarPedido($request);
    }
    
}
