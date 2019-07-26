<?php

/**
 * productoSticker form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoStickerForm extends BaseproductoStickerForm
{
  public function configure()
  {
    $productoSticker = $this->getObject();
      
	// Imagen Chica
	$this->setWidget( "imagen_chica", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('producto_sticker_chico', $productoSticker) ) );
  	
	$this->setValidator( "imagen_chica", new sfValidatorFile
										(
											imageHelper::getInstance()->getOptionForValidator('producto_sticker_chico', $productoSticker),
											imageHelper::getInstance()->getMessagesForValidator('producto_sticker_chico')
										));	
	
	// Imagen Grande
	$this->setWidget( "imagen_grande", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('producto_sticker_grande', $productoSticker) ) );
	
	$this->setValidator( "imagen_grande", new sfValidatorFile
	        (
	                imageHelper::getInstance()->getOptionForValidator('producto_sticker_grande', $productoSticker),
	                imageHelper::getInstance()->getMessagesForValidator('producto_sticker_grande')
	        ));
  }
  
  
  protected function doSave($con = null)
  {
      $productoSticker = $this->getObject();
  
      $imagenChicaFile = $this->getValue('imagen_chica');
      $imagenGrandeFile = $this->getValue('imagen_grande');
        
      unset($this->values['imagen_chica'], $this->values['imagen_grande']);
  
      $this->updateObject();
      $productoSticker->save($con);
            
      // Imagenes
      if ( $imagenChicaFile )
      {
          $savePath = imageHelper::getInstance()->getPath('producto_sticker_chico', $productoSticker);            
          copy($imagenChicaFile->getTempName(), $savePath);
          @chmod($savePath, 0777);
          unlink($imagenChicaFile->getTempName());
      }
      
      if ( $imagenGrandeFile )
      {
          $savePath = imageHelper::getInstance()->getPath('producto_sticker_grande', $productoSticker);
          copy($imagenGrandeFile->getTempName(), $savePath);
          @chmod($savePath, 0777);
          unlink($imagenGrandeFile->getTempName());
      }
      
      
      
  }
  
}
