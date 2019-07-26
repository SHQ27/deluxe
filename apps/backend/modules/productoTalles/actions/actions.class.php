<?php

require_once dirname(__FILE__).'/../lib/productoTallesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoTallesGeneratorHelper.class.php';

/**
 * productoTalles actions.
 *
 * @package    deluxebuys
 * @subpackage productoTalles
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoTallesActions extends autoProductoTallesActions
{
    
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

  	$idProductoTalle = $request->getParameter('id_producto_talle'); 

    $hayProductos = productoItemTable::getInstance()->hayProductosDeTalle($idProductoTalle);
    
    if (!$hayProductos)
    {
	    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
	
	    if ($this->getRoute()->getObject()->delete())
	    {
	      $this->getUser()->setFlash('notice', 'El talle fue borrado correctamente.');
	    }
    }
    else
    {
 		$this->getUser()->setFlash('error', 'No se pudo borrar el talle seleccionado debido a que existen productos de ese talle.');
    }
    
    $this->redirect('@producto_talle');
  }  
  
  
  public function executeSubir(sfWebRequest $request)
  {
		$productoTalle = $this->getRoute()->getObject();

		$currentOrden = $productoTalle->getOrden();
		$productoTalleAnterior = productoTalleTable::getInstance()->getPrev( $productoTalle->getOrden() );
		$ordenAnterior = $productoTalleAnterior->getOrden();
		
		//intercambio los ordenes
		$productoTalleAnterior->setOrden($currentOrden);
		$productoTalleAnterior->save();

		$productoTalle->setOrden($ordenAnterior);

		$productoTalle->save();
		$this->redirect('/backend/productoTalles' );
  }
  
  public function executeBajar(sfWebRequest $request)
  {
		$productoTalle = $this->getRoute()->getObject();

		$currentOrden = $productoTalle->getOrden();
		$productoTalleSiguiente = productoTalleTable::getInstance()->getNext( $productoTalle->getOrden() );
		$ordenSiguiente = $productoTalleSiguiente->getOrden();

		//intercambio los ordenes
		$productoTalleSiguiente->setOrden($currentOrden);
		$productoTalleSiguiente->save();

		$productoTalle->setOrden($ordenSiguiente);

		$productoTalle->save();
		$this->redirect('/backend/productoTalles' );
  }
  
  protected function addSortQuery($query)
  {
    
    $query->addOrderBy('orden asc');
  }
	
}
