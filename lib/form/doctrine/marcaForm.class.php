<?php

/**
 * marca form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class marcaForm extends BasemarcaForm
{
  public function configure()
  {
	$marca = $this->getObject();
	
	// Condicion Fiscal
	$this->setWidget( "condicion_fiscal", new sfWidgetFormSelect( array( 'choices' => marca::$condicionesFiscales )) );
	$this->setValidator( "condicion_fiscal", new sfValidatorString(array('max_length' => 3, 'required' => true)));
	
	// Imagen Marca		
	$this->setWidget( "imagen", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('marca_imagen', $marca) ) );
  	
	$this->setValidator( "imagen", new sfValidatorFile
										(
											imageHelper::getInstance()->getOptionForValidator('marca_imagen', $marca),
											imageHelper::getInstance()->getMessagesForValidator('marca_imagen')
										));
										
	$this->setValidator( "imagen_delete", new sfValidatorBoolean() );
	
  }
  
  protected function doSave($con = null)
  {
  	$marcaFile = $this->getValue('imagen');
  	
  	unset($this->values['imagen']);
  	
  	$this->updateObject();	
	$marca = $this->getObject();
	$marca->save($con);
  	
	// Gestion de imagenes
  	imageHelper::getInstance()->processDeleteFile('marca_imagen', $marca, $this->getValue('imagen_delete') );
  	imageHelper::getInstance()->processSaveFile('marca_imagen', $marca, $marcaFile);  	
  }
}
