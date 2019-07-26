<?php

/**
 * devoluciones actions.
 *
 * @package    deluxebuys
 * @subpackage devoluciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class abstractDevolucionesActions extends deluxebuysActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeImprimirEtiqueta(sfWebRequest $request)
  {
    $usuario = $this->getUser()->getCurrentUser();

    $eshop = eshopTable::getInstance()->getCurrent();
    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

  	$idDevolucion = $request->getParameter('idDevolucion');

  	$devolucion = devolucionTable::getInstance()->getByIdDevolucion( $idDevolucion );

    $etiqueta = base64_encode( EnvioPack::getInstance( $idEshop )->etiqueta( $devolucion->getCodigoEnvio() ) );

    $this->error = false;

  	if ( !$devolucion ) {
  		$this->error = true;
  	} else {
  		$this->setLayout(false);
  	}

    $this->etiqueta = $etiqueta;
    $eshop = $devolucion->getEshop();
    $this->linkColor = ( $devolucion->getIdEshop() ) ? $eshop->getLinkColor() : '#fd7977';
  }
}
