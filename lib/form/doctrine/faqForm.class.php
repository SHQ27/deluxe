<?php

/**
 * faq form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqForm extends BasefaqForm
{
  public function configure()
  {
      $faq = $this->getObject();
      
      // FaqCategoria
      $this->setWidget( "id_faq_categoria", new sfWidgetFormInputHidden() );
      $this->setValidator( "id_faq_categoria", new sfValidatorPass() );
      
      if ( isset( $_GET['id_faq_categoria'] ) ) {
          $this->setDefault('id_faq_categoria', $_GET['id_faq_categoria']);
      }
      
      // Texto
      $this->setWidget('texto', new sfWidgetFormTextareaTinyMCE( array('width' => 800, 'height' => 300)) );

      // Imagen
      $this->setWidget( "imagen", new sfWidgetFormInputFileEditable( imageHelper::getInstance()->getOptionForWidget('faq_imagen', $faq) ) );
      
      $this->setValidator( "imagen", new sfValidatorFile
              (
                      imageHelper::getInstance()->getOptionForValidator('faq_imagen', $faq),
                      imageHelper::getInstance()->getMessagesForValidator('faq_imagen')
              ));
      
      $this->setValidator( "imagen_delete", new sfValidatorBoolean() );
  }
  
  protected function doSave($con = null)
  {
      $faqFile = $this->getValue('imagen');
      $faqFileDelete = $this->getValue('imagen_delete');
              
      unset($this->values['imagen'], $this->values['imagen_delete']);
  
      $this->updateObject();
      $faq = $this->getObject();
            
      if ( $this->isNew())
      {
          $ultimoOrden = FaqTable::getInstance()->getLast( $faq->getIdFaqCategoria() );
          $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
          $faq->setOrden( $ultimoOrden );
      }
      
      $faq->save($con);
      

  
      // Gestion de imagenes
      imageHelper::getInstance()->processDeleteFile('faq_imagen', $faq, $faqFileDelete );
      imageHelper::getInstance()->processSaveFile('faq_imagen', $faq, $faqFile);
  }
  
}
