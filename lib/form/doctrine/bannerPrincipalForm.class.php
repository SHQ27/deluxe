<?php

/**
 * bannerPrincipal form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannerPrincipalForm extends BasebannerPrincipalForm
{
    public function getJavaScripts()
    {
        $js = array('formBannerPrincipal.js');
    
        return array_merge($js, $this->widgetSchema->getJavaScripts());
    }
    
  public function configure()
  {
      $bannerPrincipal = $this->getObject();
      
      // Fechas
      $this->setWidget('fecha_desde',  new pmWidgetFormDateTime());
      $this->setWidget('fecha_hasta',  new pmWidgetFormDateTime());
      
      // Url
      $w = new sfWidgetFormInput();
      
      $this->setWidget('url', $w);
      
      $this->setValidator( "url", new sfValidatorUrl
              (
                      array(),
                      array
                      (
                              'required' => 'No ha insertado una dirección URL (ej: http://www.google.com)',
                              'invalid' => 'No ha insertado una dirección URL válida (ej: http://www.google.com)'
                      )
              )
      );
      
  	  // Imagen Grande	
  	  $this->setWidget( 'imagen_grande', new sfWidgetFormInputFile( array(), array( 'multiple' => 'multiple', 'name' => 'imagen_grande[]' ) ) );
	   $this->setValidator( 'imagen_grande', new sfValidatorPass() );
      
      // Imagen Chica
      $this->setWidget( "imagen_chica", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('banner_principal_chico', $bannerPrincipal) ) );
      
      $this->setValidator( "imagen_chica", new sfValidatorFile
              (
                      imageHelper::getInstance()->getOptionForValidator('banner_principal_chico', $bannerPrincipal),
                      imageHelper::getInstance()->getMessagesForValidator('banner_principal_chico')
              ));
      
      $this->setValidator( "imagen_chica_delete", new sfValidatorBoolean() );

      // Imagen Chica
      $this->setWidget( "imagen_chica_hover", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('banner_principal_chico', $bannerPrincipal, 'hover') ) );
      
      $this->setValidator( "imagen_chica_hover", new sfValidatorFile
              (
                      imageHelper::getInstance()->getOptionForValidator('banner_principal_chico', $bannerPrincipal, 'hover'),
                      imageHelper::getInstance()->getMessagesForValidator('banner_principal_chico')
              ));
      
      $this->setValidator( "imagen_chica_hover_delete", new sfValidatorBoolean() );
      
      // Off
      $choices = array('0' => 'No mostrar');
      for ( $i = 5 ; $i <= 100 ; $i=$i+5 ) $choices[$i] = $i . '%';
      $this->setWidget('off', new sfWidgetFormSelect( array('choices' => $choices) ) );
      $this->getWidget('off')->setLabel('Porcentaje de Descuento');
      $this->setValidator('off', new sfValidatorPass() );

      // Color
      $this->setWidget('color', new sfWidgetFormInputText()) ;
      $this->setValidator("color", new sfValidatorString(
          array(
              "required" => 'false'
          )
      ));
      
  }
  
  protected function doSave($con = null)
  {
      $bannerPrincipal = $this->getObject();
  
      $imagenChicaFile = $this->getValue('imagen_chica');
      $imagenChicaHoverFile = $this->getValue('imagen_chica_hover');  

      unset($this->values['imagen_chica']);
      unset($this->values['imagen_chica_hover']);
  
      $this->updateObject();
      $bannerPrincipal->save($con);  
  
      // Imagenes      
      imageHelper::getInstance()->processDeleteFile('banner_principal_chico', $bannerPrincipal, $this->getValue('imagen_chica_delete') );
      imageHelper::getInstance()->processSaveFile('banner_principal_chico', $bannerPrincipal, $imagenChicaFile);

      imageHelper::getInstance()->processDeleteFile('banner_principal_chico', $bannerPrincipal, $this->getValue('imagen_chica_hover_delete'), 'hover' );
      imageHelper::getInstance()->processSaveFile('banner_principal_chico', $bannerPrincipal, $imagenChicaHoverFile, null, 'hover');

      
      $bannersPrincipalGrande = $_FILES['imagen_grande'];
      $cantidadImagenes = ( isset($bannersPrincipalGrande['tmp_name']) && $bannersPrincipalGrande['tmp_name'][0] )? count($bannersPrincipalGrande['tmp_name']) : 0;
      
      for ( $i = 0 ; $i < $cantidadImagenes ; $i++ )
      {
          $tmpName = $bannersPrincipalGrande['tmp_name'][$i];
      
          $unique = md5(uniqid(rand(), true));
          $savePath = imageHelper::getInstance()->getPath('banner_principal_grande', $bannerPrincipal, $unique );
          imageHelper::getInstance()->processSaveFile('banner_principal_grande', $bannerPrincipal, $tmpName, $savePath );
      
          $imagenBannerPrincipal = new imagenBannerPrincipal();
          $imagenBannerPrincipal->setId( $bannerPrincipal->getIdBannerPrincipal() );
          $imagenBannerPrincipal->setTipo( imagenBannerPrincipal::TIPO_BANNER_PRINCIPAL );
          $imagenBannerPrincipal->setSrc( $bannerPrincipal->getIdBannerPrincipal() . '_' .  $unique . '.jpg' );
          $imagenBannerPrincipal->save();
      }
     
  }
}
