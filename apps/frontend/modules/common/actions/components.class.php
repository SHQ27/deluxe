<?php

class commonComponents extends abstractCommonComponents
{    
  public function executeFooter(sfWebRequest $request)
  {
  $noMostrarEn = array('blog','carrito','contacto','miCuenta','pedido');
    $module = $this->getContext()->getModuleName();
    $this->mostrarNewsletter = !in_array($module, $noMostrarEn);
    
    $noMostrarEn = array('blog','carrito','contacto','miCuenta','pedido');
    $module = $this->getContext()->getModuleName();
    $this->mostrarFooterLinks = !in_array($module, $noMostrarEn);
    
    $noMostrarEn = array('blog','carrito','pedido');
    $module = $this->getContext()->getModuleName();
    $this->mostrarFooterAccesosRapidos = !in_array($module, $noMostrarEn);
  }
  
  public function executeMainBar(sfWebRequest $request)
  {
      
      // Ofertas
      $ofertas = array();
      
      $campanasVigentes = campanaTable::getInstance()->listVigentes();
      $index = 0;
      foreach ( $campanasVigentes as $campana )
      {
          $ofertas[ $campana->getDenominacion() . '_' . $index ] = $campana;
          $index++;
      }
      
      $outlet = new outlet();
      $outletData = configuracionTable::getInstance()->getOutlet();
      $outletData = json_decode($outletData->getValor(), true);
      $outlet->setData($outletData);
      
      if ( $outletData['activo'] && strtotime($outletData['fecha_inicio']) < time() &&  time() < strtotime($outletData['fecha_fin']) )
      {
          $ofertas[ $outletData['denominacion'] . '_' . $index ] = $outlet;
          $index++;
      }
      
      ksort($ofertas);
      
      $this->ofertas = array_values($ofertas);
      
      $this->proximasOfertas = campanaTable::getInstance()->listProximasFecha();
      
      // Por Categoria
      $categorias = array();
      $menus = array(productoGenero::MUJER, productoGenero::HOMBRE);
      foreach ($menus as $idProductoGenero)
      {
          $categorias[$idProductoGenero]['productoGenero'] = productoGeneroTable::getInstance()->getByIdProductoGenero( $idProductoGenero );
          $categorias[$idProductoGenero]['productoCategorias'] = productoCategoriaTable::getInstance()->listByIdProductoGenero( $idProductoGenero );
      
          $length = count($categorias[$idProductoGenero]['productoCategorias']);
          $categorias[$idProductoGenero]['length'] = $length;
          $categorias[$idProductoGenero]['medio'] = ($length)? ceil($length/2) : 0;
      }
      
      $this->categorias = $categorias;
      
      // Stickers
      $this->productoStickers = array();
      $this->productoStickers[productoGenero::HOMBRE] = productoStickerTable::getInstance()->listVigentes(productoGenero::HOMBRE);
      $this->productoStickers[productoGenero::MUJER] = productoStickerTable::getInstance()->listVigentes(productoGenero::MUJER);
  }
     
  public function executeRecomendarProducto(sfWebRequest $request)
  {
    $recomendarProductoForm = new recomendarProductoForm( array('id_producto' => $this->idProducto) );
    $this->recomendarProductoForm = $recomendarProductoForm;
  }
  
}
