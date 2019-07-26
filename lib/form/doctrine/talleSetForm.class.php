<?php

/**
 * talleSet form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class talleSetForm extends BasetalleSetForm
{
  public function configure()
  {
      // Widget para Marcas
      $choices = array();
      $marcas = marcaTable::getInstance()->listAll();
      foreach ($marcas as $marca)
      {
          $choicesMarcas[$marca->getIdMarca()] = $marca->getNombre();
      }
      $this->setWidget( 'id_marca', new sfWidgetFormChoice( array( 'choices' => $choicesMarcas ) ) );
      $this->setValidator('id_marca', new sfValidatorChoice( array( 'choices' => array_keys($choicesMarcas), 'required' => true ) ) );
      
      // Se agrega la logica de asignacion
      $this->setWidget( 'asignacion', new pmWidgetTalleSetAssign(array('formName' => $this->getName())) );
      $this->setValidator( 'asignacion', new sfValidatorPass() );
      
      $talleSet = $this->getObject();
      $talleSetZonas = talleSetZonaTable::getInstance()->listByIdTalleSet( $talleSet->getIdTalleSet() );
      $this->getWidget("asignacion")->setDefault($talleSetZonas);
  }

  protected function doSave($con = null)
  {
      $clone = $this->getOption('clone');
      
      // Guardo el Set de Talles
      $this->updateObject();
      
      $talleSet = $this->getObject();
      
      if ( $clone )
      {
          $idTalleSetOriginal = $talleSet->getIdTalleSet();
          $data = $talleSet->getData();
          unset($data['id_talle_set']);
          $talleSet = new talleSet();
          $talleSet->setArray($data);
      }
            
      $talleSet->save($con);
      $this->updateObject( $talleSet->getData() );      
      
      // Asignaciones
      $asignacion = $this->getValue('asignacion');
      
      $idsExistentes = array();
      $talleSetZonas = talleSetZonaTable::getInstance()->listByIdTalleSet( $talleSet->getIdTalleSet() );
      foreach($talleSetZonas as $talleSetZona) $idsExistentes[] = $talleSetZona->getIdTalleSetZona();
            
      $idsEditados = array();
      if ( $asignacion )
      {
          foreach( $asignacion as $idTalleZona => $row )
          {
              $orden = 1;
              foreach( $row as $idProductoTalle => $data )
              {
                  $idsEditados[] = talleSetZonaTable::getInstance()->save($talleSet->getIdTalleSet(), $idTalleZona, $idProductoTalle, $data['desde'], $data['hasta'], $orden);
                  $orden++;
              }
          }
      }
            
      $bajas = array_diff($idsExistentes, $idsEditados);
            
      talleSetZonaTable::getInstance()->deleteByIdsTalleSetZona($bajas);
      
  }
  
}