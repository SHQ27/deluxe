<?php

require_once dirname(__FILE__).'/../lib/promosPagoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/promosPagoGeneratorHelper.class.php';

/**
 * promosPago actions.
 *
 * @package    deluxebuys
 * @subpackage promosPago
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class promosPagoActions extends autoPromosPagoActions
{
  public function executeBajar(sfWebRequest $request)
  {
		$promoPago = $this->getRoute()->getObject();

		$currentOrden = $promoPago->getOrden();
		$promoPagoAnterior = promoPagoTable::getInstance()->getPrev( $promoPago->getOrden() );
		$ordenAnterior = $promoPagoAnterior->getOrden();
		
		//intercambio los ordenes
		$promoPagoAnterior->setOrden($currentOrden);
		$promoPagoAnterior->save();

		$promoPago->setOrden($ordenAnterior);

		$promoPago->save();
		$this->redirect('/backend/promosPago' );
  }
  
  public function executeSubir(sfWebRequest $request)
  {
		$promoPago = $this->getRoute()->getObject();

		$currentOrden = $promoPago->getOrden();
		$promoPagoSiguiente = promoPagoTable::getInstance()->getNext( $promoPago->getOrden() );
		$ordenSiguiente = $promoPagoSiguiente->getOrden();

		//intercambio los ordenes
		$promoPagoSiguiente->setOrden($currentOrden);
		$promoPagoSiguiente->save();

		$promoPago->setOrden($ordenSiguiente);

		$promoPago->save();
		$this->redirect('/backend/promosPago' );
  }
}
