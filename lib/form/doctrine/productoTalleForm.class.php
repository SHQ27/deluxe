<?php

/**
 * productoTalle form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoTalleForm extends BaseproductoTalleForm
{
  public function configure()
  {
    //WIDGET ORDEN
	$this->setWidget('orden', new sfWidgetFormInputHidden()) ;
	
	if ( $this->isNew() )
	{
	    $ultimoOrden = productoTalleTable::getInstance()->getLast();
	    $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
	    $this->setDefault('orden', $ultimoOrden);
	}
  }
}
