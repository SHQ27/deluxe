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
    // Creo el paso 2
    $this->createPaso2($request);
      
    // Calculo la url de return para el recuperador de carrito
    $producto = $this->carritoProductoItems->getFirst()->getProductoItem()->getProducto();
    $origen = $producto->getOrigen();
    
    if ( $origen == producto::ORIGEN_OUTLET ) {
        $this->returnURL = $this->getController()->genUrl(array('sf_route' => 'producto_outlet'), true );
    } else if ( $origen == producto::ORIGEN_OFERTA ) {
        $campana = $producto->getCampana();
        $this->returnURL = $this->getController()->genUrl(array('sf_route' => 'ofertas_detalles', 'slugCampana' => $campana->getSlug() ), true );
    } else if ( $origen == producto::ORIGEN_STOCK_PERMANENTE) {
        $this->returnURL = $this->getController()->genUrl(array('sf_route' => 'homepage' ), true );     
    } else {
        $this->returnURL = $this->getController()->genUrl(array('sf_route' => 'homepage' ), true );
    }
        
  }
        
  /**
   * Executes paso3 actions
   *
   * @param sfRequest $request A request object
   */
  public function executePaso3(sfWebRequest $request)
  {
      // Creo el paso 3
      $this->createPaso3($request);
      
      $this->bannerAlPie = configuracionTable::getInstance()->find( configuracion::HOME_BANNER_PIE );
      
      $session = sessionTable::getInstance()->getSession();
      $this->tieneOfertas = sessionTable::getInstance()->hayOfertas( $session->getIdSession() );
      $this->tieneOutlet = sessionTable::getInstance()->hayOutlet( $session->getIdSession() );
  }
  
  /**
   * Executes generarPedido action
   *
   * @param sfRequest $request A request object
   */
  public function executeGenerarPedido(sfWebRequest $request)
  {   
      // Genero el pedido
      $this->createGenerarPedido($request);
  }
  
  /**
   * Executes recuperar actions
   *
   * @param sfRequest $request A request object
   */
  public function executeRecuperar(sfWebRequest $request)
  {
      $session = sessionTable::getInstance()->getSession();
      
      $hash = $request->getParameter('hash');
      $recuperoCarrito = recuperoCarritoTable::getInstance()->getByHash( $hash );
      
      if ( $recuperoCarrito )
      {
          $pedido = $recuperoCarrito->getPedido();
          $pedidoProductoItems = $pedido->getPedidoProductoItem();
          
          $borroCarrito = false;
          $huboAgregados = false;
          foreach ($pedidoProductoItems as $pedidoProductoItem) {
              $productoItem = $pedidoProductoItem->getProductoItem();
                        
              $producto = $productoItem->getProducto();
              
              if ( !$producto->estaHabilitado() ) {
                  continue;
              }
          
              $currentStock = $productoItem->getCurrentStock();
              if ( $currentStock > 0 ) {
                  
                  if ( !$borroCarrito ) {
                      carritoProductoItemTable::getInstance()->deleteAllByIdSession( $session->getIdSession() );
                      $borroCarrito = true;
                  }
                                
                  $cantidad = ( $currentStock > $pedidoProductoItem->getCantidad() ) ? $pedidoProductoItem->getCantidad() : $currentStock;
                  $carritoProductoItem = carritoProductoItemTable::getInstance()->addProductoItem(  $productoItem, $cantidad );
                  $huboAgregados = true;
              }
          }
          
          if ( $huboAgregados ) {
              $this->redirect('carrito');
              exit;
          }
      }      
  }
  	
   
}
