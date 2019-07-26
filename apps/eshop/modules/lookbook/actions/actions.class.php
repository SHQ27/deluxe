<?php

/**
 * lookbook actions.
 *
 * @package    deluxebuys
 * @subpackage lookbook
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lookbookActions extends deluxebuysActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$eshop = eshopTable::getInstance()->getCurrent();
    $usaZoom = ($eshop->getLookbook() === eshopLookbook::CON_ZOOM);

    $eshopLookbooks = eshopLookbookTable::getInstance()->listLookbook( $eshop->getIdEshop() );

    $dataModal = array();

    if ( $usaZoom ) {
      foreach ($eshopLookbooks as $eshopLookbook) {

        $points = array();
        $eshopLookbookProductos = $eshopLookbook->getEshopLookbookProducto();
        foreach ($eshopLookbookProductos as $eshopLookbookProducto) {
          $producto = $eshopLookbookProducto->getProducto();
          $points[] = array(
            'top'          => $eshopLookbookProducto->getPositionTop(),
            'left'         => $eshopLookbookProducto->getPositionLeft(),
            'denominacion' =>  mb_strimwidth($producto->getDenominacion(), 0, 27, "..."),
            'precio'       => formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ),
            'url'          => $producto->getDetalleUrl(),
          );
        }

        $dataModal[ $eshopLookbook->getIdEshopLookbook() ] = array(
            'denominacion' => $eshopLookbook->getDenominacion(),
            'texto' => nl2br($eshopLookbook->getTexto() ),
            'imagen' => imageHelper::getInstance()->getUrl('eshop_lookbook_zoom', $eshopLookbook),
            'points' => $points
        );
      }

      $dataModal = json_encode($dataModal);
    }

	  $this->usaZoom        = $usaZoom; 
    $this->imagenesXFila  = $eshop->getLookbookImagenesFila();
  	$this->eshopLookbooks = $eshopLookbooks;
    $this->dataModal = $dataModal;    
  }
}
