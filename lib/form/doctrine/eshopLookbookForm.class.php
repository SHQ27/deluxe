<?php

/**
 * eshopLookbook form.
 *
 * @package    deluxebuys
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eshopLookbookForm extends BaseeshopLookbookForm
{
  public function configure()
  {
      // Relacion con eShop
      $eshopLookbook = $this->getObject();

      if ( $eshopLookbook->getIdEshop() ) {
          $idEshop = $eshopLookbook->getIdEshop();
      } else if ( isset ( $_GET['id_eshop'] )) {
          $idEshop = $_GET['id_eshop'];
      } else {
          $idEshop = $_POST[$this->getName()]['id_eshop'];
      }

      $this->setWidget('id_eshop', new sfWidgetFormInputHidden());
      $this->setDefault('id_eshop', $idEshop);
      
      // Denominacion
      $this->setWidget( "denominacion", new sfWidgetFormInputText());

      // Texto
      $this->setWidget( "texto", new sfWidgetFormTextarea());

      // Restriccion de Productos        
      $eshop = eshopTable::getInstance()->getById($idEshop);       
      $this->setWidget( "asignacion", new pmWidgetProductAssign
                          ( array
                            (
                              'formName' => $this->getName(),
                              'marcas' => array( $eshop->getMarca() ),
                              'filtrosActivos' => array('activo', 'categoria'),
                              'idEshop' => $idEshop
                            )
                          ));

                        
      $this->setValidator( "asignacion", new sfValidatorPass());
        
      $productosAsignados = productoTable::getInstance()->listByIdEshopLookbook( $eshopLookbook->getIdEshopLookbook() );
      $this->getWidget("asignacion")->setDefault($productosAsignados);

      // Asignacion Data
      $this->setWidget('asignacion_data', new sfWidgetFormInputHidden()) ;
      $this->setValidator('asignacion_data', new sfValidatorPass());

      // Orden
      $this->setWidget('orden', new sfWidgetFormInputHidden()) ;
      
      if ( $this->isNew() )
      {
          $ultimoOrden = eshopLookbookTable::getInstance()->getLast( $idEshop );
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

    $eshopLookbook = $this->getObject();
    
                
    $this->updateObject();

    $eshopLookbook->save();

    // Productos
    $eshopLookbookProductos = eshopLookbookProductoTable::getInstance()->listByIdEshopLookbook( $eshopLookbook->getIdEshopLookbook() );
    
    $existentes = array(); 
    foreach($eshopLookbookProductos as $eshopLookbookProducto)
    {
      $existentes[] = $eshopLookbookProducto->getIdProducto();
    }

    $asignacion = $this->getValue('asignacion');
    $asignacion = ( $asignacion  ) ? explode(',', $asignacion) : array();
    
    $sinCambios = array_intersect($existentes, $asignacion);
    $altas = array_diff($asignacion, $sinCambios);    
    $bajas = array_diff($existentes, $asignacion);
        
    $asignacionData = $this->getValue('asignacion_data');
    $asignacionData = json_decode($asignacionData, true);

    foreach ($sinCambios as $idProducto)
    {     
      $eshopLookbookProducto = eshopLookbookProductoTable::getInstance()->getOne($eshopLookbook->getIdEshopLookbook(), $idProducto);

      $top = $asignacionData[ $idProducto ]['top'];
      $eshopLookbookProducto->setPositionTop( $top );

      $left = $asignacionData[ $idProducto ]['left'];
      $eshopLookbookProducto->setPositionLeft( $left );

      $backgroundColor = $asignacionData[ $idProducto ]['backgroundColor'];
      $eshopLookbookProducto->setBackgroundColor( $backgroundColor );

      $eshopLookbookProducto->save();
    }

    foreach ($bajas as $idProducto)
    {     
      $eshopLookbookProducto = eshopLookbookProductoTable::getInstance()->getOne($eshopLookbook->getIdEshopLookbook(), $idProducto);
      $eshopLookbookProducto->delete();
    }
        
    foreach ($altas as $idProducto)
    {     
      $eshopLookbookProducto = new eshopLookbookProducto();
      $eshopLookbookProducto->setIdEshopLookbook( $eshopLookbook->getIdEshopLookbook() );
      $eshopLookbookProducto->setIdProducto($idProducto);

      $top = $asignacionData[ $idProducto ]['top'];
      $eshopLookbookProducto->setPositionTop( $top );

      $left = $asignacionData[ $idProducto ]['left'];
      $eshopLookbookProducto->setPositionLeft( $left );

      $backgroundColor = $asignacionData[ $idProducto ]['backgroundColor'];
      $eshopLookbookProducto->setBackgroundColor( $backgroundColor );
      
      $eshopLookbookProducto->save();
    }

    // Imagenes
    if (isset($file)) {
      imageHelper::getInstance()->processDeleteFile('eshop_lookbook_zoom', $eshopLookbook, true);
      imageHelper::getInstance()->processDeleteFile('eshop_lookbook', $eshopLookbook, true);

      $eshop = $eshopLookbook->getEshop();

      // Guardo las imagenes, de distintas formas de acuerdo a si usa zoom o no
      if ( $eshop->getLookbook() === eshopLookbook::CON_ZOOM ) {
         imageHelper::getInstance()->processSaveFile('eshop_lookbook_x' . $eshop->getLookbookImagenesFila(), $eshopLookbook, $file);
         imageHelper::getInstance()->processSaveFile('eshop_lookbook_zoom', $eshopLookbook, $file);
      } else {
         imageHelper::getInstance()->processSaveFile('eshop_lookbook_x' . $eshop->getLookbookImagenesFila(), $eshopLookbook, $file);
      }

    }
  }

}
