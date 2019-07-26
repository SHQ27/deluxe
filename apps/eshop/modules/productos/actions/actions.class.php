<?php

/**
 * productos actions.
 *
 * @package    deluxebuys
 * @subpackage productos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productosActions extends abstractProductosActions
{	

    /**
     * Executes listado action
     *
     * @param sfRequest $request A request object
     */
    public function executeListado(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $idProductoGenero = $eshop->getIdProductoGenero();
    
        // Filtros adicionales        
        $filtros = array(
            'idEshop' => $eshop->getIdEshop(),
            'idProductoGenero' => $idProductoGenero
        );
        
        // Creo el listado
        $this->createListado($request, $eshop->getIdProductoGenero(), $filtros);

        // Se obtiene la imagen de banner segun corresponda caso A o B

        // A) Imagen Default del eShop
        $bannerListado = imageHelper::getInstance()->getUrl('eshop_banner_listado', $eshop);
                
        // B) Si tiene imagen dentro de la categoria
        $slugProductoCategoria = $request->getParameter('slugProductoCategoria');
        if ( $slugProductoCategoria ) {
            $productoCategoria = productoCategoriaTable::getInstance()->getBySlug( $slugProductoCategoria, $idProductoGenero );
            $productoCategoriaEshop = productoCategoriaEshopTable::getInstance()->getByCompoundKey(
                $eshop->getIdEshop(),
                $productoCategoria->getIdProductoCategoria()
            );

            if ( $productoCategoriaEshop ) {

                $img = imageHelper::getInstance()->getUrl('eshop_banner_listado', $productoCategoriaEshop);

                if ( imageHelper::getInstance()->exists( $img ) ) {
                    $bannerListado = $img;
                }
            }
        }

        // Si no existe la imagen de banner no se muestra nada
        if ( !imageHelper::getInstance()->exists( $bannerListado ) ) {
            $bannerListado = false;
        }
        
        $this->bannerListado = $bannerListado;
        $this->idEshop = $eshop->getIdEshop();
        $this->eshop = $eshop;
    }
    
    /**
     * Executes detalle action
     *
     * @param sfRequest $request A request object
     */
    public function executeDetalle(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
    
        // Creo el detalle
        $this->createDetalle($request);
    
        $this->idEshop = $eshop->getIdEshop();
        $this->eshop = $eshop;
    }
    
    /**
     * Executes listaTag action
     *
     * @param sfRequest $request A request object
     */
    public function executeListaTag(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
    
        // Filtros adicionales        
        $filtros = array(
            'idEshop' => $eshop->getIdEshop()       
        );
        
	    // Creo el listado de tags
	    $this->createListaTag($request, $filtros);

        // Imagen Default del eShop
        $bannerListado = imageHelper::getInstance()->getUrl('eshop_banner_listado', $eshop);
                
        // Si no existe la imagen de banner no se muestra nada
        if ( !imageHelper::getInstance()->exists( $bannerListado ) ) {
            $bannerListado = false;
        }
        
        $this->bannerListado = $bannerListado;
	    $this->idEshop = $eshop->getIdEshop();
        $this->eshop = $eshop;
    }

	
}
