<?php

/**
 * familiaColor form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class familiaColorForm extends BasefamiliaColorForm
{
  public function configure()
  {
  	$familiaColor = $this->getObject();
  	
	// Imagen
	$this->setWidget( "imagen", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('familia_color', $familiaColor) ) );
  	
	$this->setValidator( "imagen", new sfValidatorFile
										(
											imageHelper::getInstance()->getOptionForValidator('familia_color', $familiaColor),
											imageHelper::getInstance()->getMessagesForValidator('familia_color')
										));
										
	$this->setValidator( "imagen_delete", new sfValidatorBoolean() );  
  }

  protected function doSave($con = null)
  {
  	$familiaColorFile = $this->getValue('imagen');
  	
  	unset($this->values['imagen']);
  	
  	$this->updateObject();	
	$familiaColor = $this->getObject();
	$familiaColor->save($con);
  	
	// Gestion de imagenes
  	imageHelper::getInstance()->processDeleteFile('familia_color', $familiaColor, $this->getValue('imagen_delete') );
  	imageHelper::getInstance()->processSaveFile('familia_color', $familiaColor, $familiaColorFile);  	
  }

}
