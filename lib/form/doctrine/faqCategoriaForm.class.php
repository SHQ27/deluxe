<?php

/**
 * faqCategoria form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqCategoriaForm extends BasefaqCategoriaForm
{
  public function configure()
  {
      $this->setWidget('id_eshop', new sfWidgetFormInputHidden() );
      $this->setValidator('id_eshop', new sfValidatorPass() );
      
      if ( isset( $_GET['idEshop'] ) ) {
          $this->setDefault('id_eshop', $_GET['idEshop']);
      }
  }
  
  protected function doSave($con = null)
  {  
      $this->updateObject();
      $faqCategoria = $this->getObject();
  
      if ( $this->isNew())
      {
          $ultimoOrden = faqCategoriaTable::getInstance()->getLast( $faqCategoria->getIdEshop() );
          $ultimoOrden = ($ultimoOrden)? $ultimoOrden->getOrden() + 1 : 1;
          $faqCategoria->setOrden( $ultimoOrden );
      }
      
      if ( $faqCategoria->getIdEshop() == eshop::ESHOP_DELUXE ) {
          $faqCategoria->setIdEshop( null );
      }
  
      $faqCategoria->save($con);
  }
}
