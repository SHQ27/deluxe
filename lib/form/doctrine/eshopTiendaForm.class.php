<?php

/**
 * eshopTienda form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopTiendaForm extends BaseeshopTiendaForm
{
  public function configure()
  {
      $eshopTienda = $this->getObject();
      
      if ( $eshopTienda->getIdEshop() ) {
        $idEshop = $eshopTienda->getIdEshop();
      } else if ( isset ( $_GET['id_eshop'] )) {
        $idEshop = $_GET['id_eshop'];
      } else {
          $idEshop = $_POST[$this->getName()]['id_eshop'];
      }      
      
      $this->setWidget('id_eshop', new sfWidgetFormInputHidden());
      $this->setDefault('id_eshop', $idEshop);
      
            
      // Categorias de eshop
      $eshopTiendaCategorias = eshopTiendaCategoriaTable::getInstance()->listAll();
      $choices = array();
      foreach ($eshopTiendaCategorias as $eshopTiendaCategoria) $choices[$eshopTiendaCategoria->getIdEshopTiendaCategoria()] = $eshopTiendaCategoria->getDenominacion();
      $this->setWidget( "id_eshop_tienda_categoria", new sfWidgetFormSelectDoubleList( array('choices' => $choices, 'label_unassociated' => 'No Asociadas', 'label_associated' => 'Asociadas') ) );
      $this->setValidator( "id_eshop_tienda_categoria", new sfValidatorChoice( array('choices' => array_keys($choices), 'multiple' => true ) ) );
      
      $categoriasExistentes = eshopTiendaTiendaCategoriaTable::getInstance()->listByIdEshopTienda( $eshopTienda->getIdEshopTienda() );
      $default = array();
      foreach ($categoriasExistentes as $categoriasExistente) $default[] = $categoriasExistente->getIdEshopTiendaCategoria();
      $this->getWidget("id_eshop_tienda_categoria")->setDefault( $default );
  }
  
  protected function doSave($con = null)
  {
      $eshopTienda = $this->getObject();
      $this->updateObject();      
      $eshopTienda->save($con);
       
      // Categorias
      $eshopTiendaCategorias = $this->getValue('id_eshop_tienda_categoria');
      $categoriasExistentes = eshopTiendaTiendaCategoriaTable::getInstance()->listByIdEshopTienda( $eshopTienda->getIdEshopTienda() );
      $existentes = array();
      foreach ($categoriasExistentes as $categoriasExistente) $existentes[] = $categoriasExistente->getIdEshopTiendaCategoria();
  
      $bajas = array_diff($existentes, $eshopTiendaCategorias);     
  
      foreach ( $bajas as $idEshopTiendaCategoria )
      {
          $eshopTiendaTiendaCategoria = eshopTiendaTiendaCategoriaTable::getInstance()->getByCompoundKey($eshopTienda->getIdEshopTienda(), $idEshopTiendaCategoria);
          $eshopTiendaTiendaCategoria->delete();
      }
  
      $values = $this->getTaintedValues();
      	
      foreach ($eshopTiendaCategorias as $idEshopTiendaCategoria)
      {
          $eshopTiendaTiendaCategoria = eshopTiendaTiendaCategoriaTable::getInstance()->getByCompoundKey($eshopTienda->getIdEshopTienda(), $idEshopTiendaCategoria);
           
          if (!$eshopTiendaTiendaCategoria)
          {
              $eshopTiendaTiendaCategoria = new eshopTiendaTiendaCategoria();
          }
          
          $eshopTiendaTiendaCategoria->setIdEshopTienda( $eshopTienda->getIdEshopTienda() );
          $eshopTiendaTiendaCategoria->setIdEshopTiendaCategoria( $idEshopTiendaCategoria );
          $eshopTiendaTiendaCategoria->save();
      }
  } 
  
}