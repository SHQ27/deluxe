<?php

/**
 * eshopHome form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopHomeForm extends BaseeshopHomeForm
{
  public function configure()
  {
      // Relacion con eShop
      $eshopHome = $this->getObject();

      if ( $eshopHome->getIdEshop() ) {
          $idEshop = $eshopHome->getIdEshop();
      } else if ( isset ( $_GET['id_eshop'] )) {
          $idEshop = $_GET['id_eshop'];
      } else {
          $idEshop = $_POST[$this->getName()]['id_eshop'];
      }

      $this->setWidget('id_eshop', new sfWidgetFormInputHidden());
      $this->setDefault('id_eshop', $idEshop);

      // Tipos
      $choices = eshopHome::$TIPOS;
      $this->setWidget('tipo', new sfWidgetFormChoice( array('choices' => $choices ) ));
      $this->setValidator('tipo', new sfValidatorChoice( array('choices' => array_keys($choices), 'required' => true )));
      

      // Vigencia
      $this->setWidget('vigencia_desde',  new pmWidgetFormDateTime());
      $this->setWidget('vigencia_hasta',  new pmWidgetFormDateTime());

      // Orden
      $this->setWidget('orden', new sfWidgetFormInputHidden()) ;
      
      if ( $this->isNew() )
      {
          $ultimoOrden = eshopHomeTable::getInstance()->getLast( $idEshop );
          $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
          $this->setDefault('orden', $ultimoOrden);
      }

      // Multimedia
      $this->setWidget("multimedia", new sfWidgetFormInputFile());
      $this->setValidator("multimedia", new sfValidatorPass());

      // Links
      $this->setWidget("link", new sfWidgetFormInput());
      $this->setValidator("link", new sfValidatorPass());
  }

  protected function doSave($con = null)
  {   
    $eshopHome = $this->getObject();
    $tipoAnterior = $eshopHome->getTipo();
  
    unset($this->values['multimedia']);
    
    $notice = $eshopHome->isNew() ? 'El elemento se creó correctamente.' : 'El elemento fue modificado.';
                
    $this->updateObject();
    $eshopHome->save($con);

    $this->message = $notice;

    /* Si el tipo de eshopHome cambia se debe ejecutar el proceso que limpia
    *  la base para dejarla lista para el nuevo tipo
    */
    if ( $tipoAnterior != $eshopHome->getTipo() ) {
      $this->procesarCambioTipo( $eshopHome );  
    }
    

    $tipo = $this->getValue('tipo');
    
    // Adecuacion a Grilla
    preg_match('/GRLA([0-9]+)/', $tipo, $match); 
    if ( isset( $match[1] ) ) {
      $subIndice = $match[1];
      $tipo = 'GRLAX';
    }

    // Adecuacion a Banner Secundario
    preg_match('/BSX2([0-9]+)/', $tipo, $match); 
    if ( isset( $match[1] ) ) {
      $subIndice = $match[1];
      $tipo = 'BSX2X';
    }

    $method = 'save' . $tipo;
    $this->$method( $eshopHome, $subIndice );

    // Si no es tipo texto o productos destacados vacio el campo
    if ( !in_array($eshopHome->getTipo(), array( eshopHome::TIPO_TEXTO, eshopHome::TIPO_PRODUCTOS_DESTACDOS ) ) ) {
      $eshopHome->setTexto(null);
      $eshopHome->save();
    }
  }

  protected function saveBPRFS( $eshopHome, $subIndice ) {

    $link = $_POST['link']['BPRFS'];
    $tmpName = $_FILES['multimedia']['tmp_name']['BPRFS'];
    $tmpNamePoster = $_FILES['multimedia']['tmp_name']['BPRFS_POSTER'];
    $tmpNameMobile = $_FILES['multimedia']['tmp_name']['BPRFS_MOBILE'];
    $tmpNameMobilePoster = $_FILES['multimedia']['tmp_name']['BPRFS_MOBILE_POSTER'];

    if (!$tmpName || !$tmpNameMobile) { return; }

    $name = $_FILES['multimedia']['name']['BPRFS'];    
    $extension = strtolower( substr($name, -3) );

    $eshopHomeMultimedia = new eshopHomeMultimedia();
    $eshopHomeMultimedia->setIdEshopHome( $eshopHome->getIdEshopHome() );
    $eshopHomeMultimedia->setLink( $link );
    $eshopHomeMultimedia->setEsVideo( $extension == 'mp4' );
    $eshopHomeMultimedia->save();
      
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_full', $tmpName, $extension);
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_full', $tmpNamePoster, null, 'poster');
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_full', $tmpNameMobile, $extension, 'mobile');
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_full', $tmpNameMobilePoster, null, 'mobile_poster');

  }

  protected function saveBPRNO( $eshopHome, $subIndice ) {

    $link = $_POST['link']['BPRNO'];
    $tmpName = $_FILES['multimedia']['tmp_name']['BPRNO'];
    $tmpNamePoster = $_FILES['multimedia']['tmp_name']['BPRNO_POSTER'];
    $tmpNameMobile = $_FILES['multimedia']['tmp_name']['BPRNO_MOBILE'];
    $tmpNameMobilePoster = $_FILES['multimedia']['tmp_name']['BPRNO_MOBILE_POSTER'];

    if (!$tmpName || !$tmpNameMobile) { return; }

    $name = $_FILES['multimedia']['name']['BPRNO'];    
    $extension = strtolower( substr($name, -3) );

    $eshopHomeMultimedia = new eshopHomeMultimedia();
    $eshopHomeMultimedia->setIdEshopHome( $eshopHome->getIdEshopHome() );
    $eshopHomeMultimedia->setLink( $link );
    $eshopHomeMultimedia->setEsVideo( $extension == 'mp4' );
    $eshopHomeMultimedia->save();
      
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_normal', $tmpName, $extension);
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_normal', $tmpNamePoster, 'jpg', 'poster');
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_normal', $tmpNameMobile, $extension, 'mobile');
    $this->processSaveFile($eshopHomeMultimedia, 'eshop_home_principal_normal', $tmpNameMobilePoster, 'jpg', 'mobile_poster');

  }

  protected function saveBSX2X( $eshopHome, $subIndice ) {
      $this->saveBSX($eshopHome, 2, 1, $subIndice);
      $this->saveBSX($eshopHome, 2, 2, $subIndice);
  }

  protected function saveBSEX3( $eshopHome, $subIndice ) {
      $this->saveBSEX($eshopHome, 3, 1);
      $this->saveBSEX($eshopHome, 3, 2);
      $this->saveBSEX($eshopHome, 3, 3);
  }

  protected function saveBSX( $eshopHome, $tipo, $indice, $subIndice ) {
    $key = 'eshop_home_secundario_x' . $tipo . '_' . eshopHome::$BANNERS_SECUNDARIOS[$subIndice][$indice - 1];
    $tipo = $tipo . $subIndice;

    $link = $_POST['link']['BSX' . $tipo . '_' . $indice];

    $tmpName = $_FILES['multimedia']['tmp_name']['BSX' . $tipo . '_' . $indice];

    $name = $_FILES['multimedia']['name']['BSX' . $tipo . '_' . $indice];
    $extension = strtolower( substr($name, -3) );

    $tmpNameHover = $_FILES['multimedia']['tmp_name']['BSX' . $tipo . '_' . $indice . '_HOVER'];
    $tmpNamePoster = $_FILES['multimedia']['tmp_name']['BSX' . $tipo . '_' . $indice . '_POSTER'];

    $this->saveFileMultimedia($eshopHome, $link, $tmpName, $extension, $tmpNameHover, $tmpNamePoster, $key, $indice);
  }
  
  protected function saveBSEX( $eshopHome, $tipo, $indice ) {

    $link = $_POST['link']['BSEX' . $tipo . '_' . $indice];

    $tmpName = $_FILES['multimedia']['tmp_name']['BSEX' . $tipo . '_' . $indice];

    $name = $_FILES['multimedia']['name']['BSEX' . $tipo . '_' . $indice];
    $extension = strtolower( substr($name, -3) );

    $tmpNameHover = $_FILES['multimedia']['tmp_name']['BSEX' . $tipo . '_' . $indice . '_HOVER'];
    $tmpNamePoster = $_FILES['multimedia']['tmp_name']['BSEX' . $tipo . '_' . $indice . '_POSTER'];

    $this->saveFileMultimedia($eshopHome, $link, $tmpName, $extension, $tmpNameHover, $tmpNamePoster, 'eshop_home_secundario_x' . $tipo, $indice);
  }
  

  protected function saveBCINT( $eshopHome, $subIndice ) {

    $link = $_POST['link']['BCINT'];
    $tmpName = $_FILES['multimedia']['tmp_name']['BCINT'];

    $name = $_FILES['multimedia']['name']['BCINT'];
    $extension = strtolower( substr($name, -3) );

    $tmpNameHover = $_FILES['multimedia']['tmp_name']['BCINT_HOVER'];
    $tmpNamePoster = $_FILES['multimedia']['tmp_name']['BCINT_POSTER'];

    $this->saveFileMultimedia($eshopHome, $link, $tmpName, $extension, $tmpNameHover, $tmpNamePoster, 'eshop_home_cinta');
  }

  protected function saveFileMultimedia( $eshopHome, $link, $tmpName, $extension, $tmpNameHover, $tmpNamePoster, $key, $indice = null ) {

    // Si no se sube archivo no se hace nada
    if (!$tmpName) {

      $eshopHomeMultimedia = eshopHomeMultimediaTable::getInstance()->getList($eshopHome->getIdEshopHome(), $indice)->getFirst();
      if ( $eshopHomeMultimedia ) {

        if ( $link ) { 
          $eshopHomeMultimedia->setLink( $link );
        }

        if ( $tmpNameHover ) { 
          imageHelper::getInstance()->processSaveFile($key, $eshopHomeMultimedia, $tmpNameHover, null, 'hover');
        }

        if ( $tmpNamePoster ) { 
          imageHelper::getInstance()->processSaveFile($key, $eshopHomeMultimedia, $tmpNamePoster, null, 'poster');
        }

        $eshopHomeMultimedia->save();
      }

      return;
    }

    // Se eliminan las imagenes anteriores
    $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome(), $indice );
    foreach ($eshopHomeMultimedias as $eshopHomeMultimedia) {
      $eshopHomeMultimedia->delete();
    }

    // Se crea la nueva imagen
    $eshopHomeMultimedia = new eshopHomeMultimedia();
    $eshopHomeMultimedia->setIdEshopHome( $eshopHome->getIdEshopHome() );
    $eshopHomeMultimedia->setEsVideo( $extension == 'mp4' );
    $eshopHomeMultimedia->setLink( $link );

    if ( $indice ) {
      $eshopHomeMultimedia->setIndice( $indice );
    }

    $eshopHomeMultimedia->save();

    $this->processSaveFile($eshopHomeMultimedia, $key, $tmpName, $extension);

    // El hover se toma en cuenta solo si la imagen subida no es un video
    if ( !$eshopHomeMultimedia->getEsVideo() ) {
      imageHelper::getInstance()->processSaveFile($key, $eshopHomeMultimedia, $tmpNameHover, null, 'hover');
    }

    // El poster se toma en cuenta solo si la imagen subida es un video
    if ( $eshopHomeMultimedia->getEsVideo() ) {
      imageHelper::getInstance()->processSaveFile($key, $eshopHomeMultimedia, $tmpNamePoster, null, 'poster');
    }

  }

  protected function saveGRLAX( $eshopHome, $subIndice ) {

    $keys = eshopHome::$GRILLA[ $subIndice ];
    for ($i = 1 ; $i <= 6 ; $i++ ) {
      $key = $keys[$i-1];
      
      $link = $_POST['link']['GRLA' . $subIndice . '_' . $key . '_' . $i];

      $tmpName = $_FILES['multimedia']['tmp_name']['GRLA' . $subIndice . '_' . $key . '_' . $i];

      $name = $_FILES['multimedia']['name']['GRLA' . $subIndice . '_' . $key . '_' . $i];
      $extension = strtolower( substr($name, -3) );

      $tmpNameHover = $_FILES['multimedia']['tmp_name']['GRLA' . $subIndice . '_' . $key . '_' . $i . '_HOVER'];
      $tmpNamePoster = $_FILES['multimedia']['tmp_name']['GRLA' . $subIndice . '_' . $key . '_' . $i . '_POSTER'];

      $this->saveFileMultimedia($eshopHome, $link, $tmpName, $extension, $tmpNameHover, $tmpNamePoster, 'eshop_home_grilla_' . $key, $i);

    }
  }

  protected function saveTEXTO( $eshopHome, $subIndice ) {}
  protected function savePRODE( $eshopHome, $subIndice ) {}

  protected function procesarCambioTipo( $eshopHome ) {
    $eshopHomeMultimedias = eshopHomeMultimediaTable::getInstance()->getList( $eshopHome->getIdEshopHome() );
    foreach ($eshopHomeMultimedias as $eshopHomeMultimedia) {
      $eshopHomeMultimedia->delete();
    }
  }

  protected function processSaveFile($eshopHomeMultimedia, $key, $tmpName, $extension, $sufix = false) {
      if ( $extension == 'mp4' ) {
        $savePath = imageHelper::getInstance()->getPath( $key, $eshopHomeMultimedia );
        $sufix = ( $sufix ) ? '_' . $sufix : '';
        $savePath = str_replace('.jpg', $sufix . '.mp4', $savePath);
        copy($tmpName, $savePath);
        @chmod($savePath, 0777);
      } else if ( $extension == 'gif' ) {
        $savePath = imageHelper::getInstance()->getPath( $key, $eshopHomeMultimedia );
        $sufix = ( $sufix ) ? '_' . $sufix : '';
        $savePath = str_replace('.jpg', $sufix . '.jpg', $savePath);
        copy($tmpName, $savePath);
        @chmod($savePath, 0777);
      }else {
        imageHelper::getInstance()->processSaveFile($key, $eshopHomeMultimedia, $tmpName, null, $sufix);
      }
  }

}
