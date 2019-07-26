<?php

/**
 * cupon form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuponForm extends BasecuponForm
{
  public function configure()
  {
  	$cupon = $this->getObject();
  	
	// Fechas
	$this->setWidget('fecha_desde', new pmWidgetFormDate());
	
	$this->setValidator('fecha_desde', new sfValidatorDate(
												array('required' => false),
												array('invalid' => 'Fecha inválida.')));
												
	$this->setWidget('fecha_hasta', new pmWidgetFormDate());
												
	$this->setValidator('fecha_hasta', new sfValidatorDate(
												array('required' => false),
												array('invalid' => 'Fecha inválida.')));													

												
	// Asignacion												
	$this->setWidget( "asignacion", new pmWidgetProductAssign
											( array
												(
													'formName' => $this->getName(),
													'marcas' => marcaTable::getInstance()->listAll(),
													'idEshop' => eshop::ESHOP_DELUXE
												)
											));
	
										
	$this->setValidator( "asignacion", new sfValidatorPass());  	
  	
	$productosAsignados = productoTable::getInstance()->listByIdCupon($cupon->getIdCupon(), false);  	
	$this->getWidget("asignacion")->setDefault($productosAsignados);
  	
  }
  
  protected function doSave($con = null)
  {  	
	$cupon = $this->getObject();
	$this->updateObject();
	$cupon->save($con);
	
  	// Productos
  	$cuponProductosActual = cuponProductoTable::getInstance()->listByIdCupon( $cupon->getIdCupon() );
  	
  	$existentes = array(); 
  	foreach($cuponProductosActual as $cuponProducto)
  	{
  		$existentes[] = $cuponProducto->getIdProducto();
  	}

	$asignacion = $this->getValue('asignacion');
	$asignacion = ( $asignacion  ) ? explode(',', $asignacion) : array();
  	
  	$sinCambios = array_intersect($existentes, $asignacion);
  	$altas = array_diff($asignacion, $sinCambios);  	
  	$bajas = array_diff($existentes, $asignacion);
  	  	
  	  	  	
	foreach ($bajas as $idProducto)
  	{  		
  		$cuponProducto = cuponProductoTable::getInstance()->getOne($idProducto, $cupon->getIdCupon() );
  		$cuponProducto->delete();
  	}
  	  	
  	foreach ($altas as $idProducto)
  	{  		
	  	$cuponProducto = new cuponProducto();
	  	$cuponProducto->setIdCupon( $cupon->getIdCupon() );
	  	$cuponProducto->setIdProducto($idProducto);
	  	$cuponProducto->save();
  	}
  	
  } 
  
}
