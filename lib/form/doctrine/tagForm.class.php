<?php

/**
 * tag form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tagForm extends BasetagForm
{
  public function configure()
  {  	
  	$tag = $this->getObject();
  	
	// Asignacion												
	$this->setWidget( "asignacion", new pmWidgetProductAssign
											( array
												(
													'formName' => $this->getName(),
													'marcas' => marcaTable::getInstance()->listAll(),
												  'filtrosActivos' => array('marca', 'campana', 'activo', 'categoria')
												)
											));
	
										
	$this->setValidator( "asignacion", new sfValidatorPass());  	
  	
	$productosAsignados = productoTable::getInstance()->listByIdTag($tag->getIdTag(), false);  	
	$this->getWidget("asignacion")->setDefault($productosAsignados);
  }
  
  protected function doSave($con = null)
  {  	
	$tag = $this->getObject();
	$this->updateObject();
	$tag->save($con);

	// Productos
  	$productosTagActual = productoTable::getInstance()->listByIdTag($tag->getIdTag(), false);
  	
  	$existentes = array(); 
  	foreach($productosTagActual as $producto)
  	{
  		$existentes[] = $producto->getIdProducto();
  	}

	$asignacion = $this->getValue('asignacion');
	$asignacion = ( $asignacion  ) ? explode(',', $asignacion) : array();
  	
  	$sinCambios = array_intersect($existentes, $asignacion);
  	$altas = array_diff($asignacion, $sinCambios);
  	$bajas = array_diff($existentes, $asignacion);
  	  	
  	  	  	
	foreach ($bajas as $idProducto)
  	{  		
  		$productoTag = productoTagTable::getInstance()->getOne($idProducto, $tag->getIdTag());
  		$productoTag->delete();
  	}
  	
  	foreach ($altas as $idProducto)
  	{  		
	  	$productoTag = new productoTag();
	  	$productoTag->setIdTag($tag->getIdTag());
	  	$productoTag->setIdProducto($idProducto);
	  	$productoTag->save();
  	}  	
  }
  
}
