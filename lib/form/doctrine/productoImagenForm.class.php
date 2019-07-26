<?php

/**
 * productoImagen form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoImagenForm extends BaseproductoImagenForm
{
  public function configure()
  {
  	
  	$productoImagen = $this->getObject();
  	
  	// Se setea el producto
	$this->setWidget( "id_producto", new sfWidgetFormInputHidden() );
	$idProducto = sfContext::getInstance()->getRequest()->getParameter("id_producto");
	if ( $idProducto ) $this->setDefault("id_producto", $idProducto);
  	
	//WIDGET IMAGEN		
	$this->setWidget( "imagen", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('producto_lista_chica', $productoImagen) ) );
  	
	$this->setValidator( "imagen", new sfValidatorFile
										(
											imageHelper::getInstance()->getOptionForValidator('producto_detalle_grande', $productoImagen),
											imageHelper::getInstance()->getMessagesForValidator('producto_detalle_grande')
										));	
  	
  }
  
  
  protected function doSave($con = null)
  {  	
  	$productoImagen = $this->getObject();
  	  	
  	$imagenFile = $this->getValue('imagen');
  	
  	unset($this->values['imagen']);
  	  			      	
    $this->updateObject();
    $productoImagen->save($con);
    
  	imageHelper::getInstance()->processSaveFile('producto_lista_chica', $productoImagen, $imagenFile );
  	imageHelper::getInstance()->processSaveFile('producto_lista_grande', $productoImagen, $imagenFile );
  	imageHelper::getInstance()->processSaveFile('producto_detalle_chica', $productoImagen, $imagenFile );
	  imageHelper::getInstance()->processSaveFile('producto_detalle_mediana', $productoImagen, $imagenFile );
	  imageHelper::getInstance()->processSaveFile('producto_detalle_grande', $productoImagen, $imagenFile );
    imageHelper::getInstance()->processSaveFile('producto_thumb', $productoImagen, $imagenFile );
  }
  
}
