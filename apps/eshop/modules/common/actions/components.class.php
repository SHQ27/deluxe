<?php

class commonComponents extends abstractCommonComponents
{    
  public function executeMainBar(sfWebRequest $request)
  {   
      $eshop = eshopTable::getInstance()->getCurrent();

      $productoCategoriasPrendas = productoCategoriaTable::getInstance()->listByIdProductoGeneroEshops(
        $eshop->getIdProductoGenero(),
        $eshop->getIdEshop(),
        productoCategoriaEshop::TIPO_PRENDA_PRENDA
      );
      
      $productoCategoriasAccesorios = productoCategoriaTable::getInstance()->listByIdProductoGeneroEshops(
        $eshop->getIdProductoGenero(),
        $eshop->getIdEshop(),
        productoCategoriaEshop::TIPO_PRENDA_ACCESORIO
      );

      $outlet = null;
      
      if ( $eshop->getIdEshop() == 5 ) {

        foreach ($productoCategoriasPrendas as $i => $productoCategoria) {
          if ( $productoCategoria->getDenominacion() === 'Outlet' ) {
            $outlet = $productoCategoriasPrendas[$i];
            unset($productoCategoriasPrendas[$i]);
          }
        }

        foreach ($productoCategoriasAccesorios as $i => $productoCategoria) {
          if ( $productoCategoria->getDenominacion() === 'Outlet' ) {
            $outlet = $productoCategoriasAccesorios[$i];
            unset($productoCategoriasAccesorios[$i]);
          }
        }

      }
      


      $this->productoCategoriasPrendas    = $productoCategoriasPrendas;
      $this->productoCategoriasAccesorios = $productoCategoriasAccesorios;

      $this->outlet = $outlet;

      $this->eshop = $eshop;
  }

  
  public function executeHeader(sfWebRequest $request)
  {
      $this->eshop = eshopTable::getInstance()->getCurrent();
  }
  
  public function executeFooter(sfWebRequest $request)
  {
      $this->eshop = eshopTable::getInstance()->getCurrent();
  }

  public function executeUserBar(sfWebRequest $request)
  {
      $this->eshop = eshopTable::getInstance()->getCurrent();
  }  
  
}
