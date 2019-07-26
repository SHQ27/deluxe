<?php

/**
 * eshopImagenCampaign form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopImagenCampaignForm extends BaseeshopImagenCampaignForm
{
  public function configure()
  {
      // Relacion con eShop
      $eshopImagenCampaign = $this->getObject();

      if ( $eshopImagenCampaign->getIdEshop() ) {
          $idEshop = $eshopImagenCampaign->getIdEshop();
      } else if ( isset ( $_GET['id_eshop'] )) {
          $idEshop = $_GET['id_eshop'];
      } else {
          $idEshop = $_POST[$this->getName()]['id_eshop'];
      }

      $this->setWidget('id_eshop', new sfWidgetFormInputHidden());
      $this->setDefault('id_eshop', $idEshop);

      // Orden
      $this->setWidget('orden', new sfWidgetFormInputHidden()) ;
      
      if ( $this->isNew() )
      {
          $ultimoOrden = eshopImagenCampaignTable::getInstance()->getLast( $idEshop );
          $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
          $this->setDefault('orden', $ultimoOrden);
      }

      // Imagen
      $this->setWidget("imagen", new sfWidgetFormInputFile());
      
      $this->setValidator("imagen", new sfValidatorFile(
          array(
              "required" => false,
              "path" => '/tmp',
          ), array(
              'required' => 'No ha seleccionado ningún elemento.'
          )
      ));  
  }


  protected function doSave($con = null)
  {   
    $file = $this->getValue('imagen');

    unset($this->values['imagen']);

    $eshopImagenCampaign = $this->getObject();
  
    unset($this->values['multimedia']);
    
    $notice = $eshopImagenCampaign->isNew() ? 'La imagen de la seccion Campaign del eShop se creó correctamente.' : 'La imagen de la seccion Campaign del eShop fue modificada.';
                
    $this->updateObject();

    $eshopImagenCampaign->save($con);

      if (isset($file))
      {
         imageHelper::getInstance()->processDeleteFile('eshop_imagen_campaign', $eshopImagenCampaign, true);
         imageHelper::getInstance()->processSaveFile('eshop_imagen_campaign', $eshopImagenCampaign, $file);
      }

    $this->message = $notice;
  }

}
