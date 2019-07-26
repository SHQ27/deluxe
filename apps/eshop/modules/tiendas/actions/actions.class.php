<?php

/**
 * tiendas actions.
 *
 * @package    deluxebuys
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tiendasActions extends deluxebuysActions
{
 
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $eshopTiendas = eshopTiendaTable::getInstance()->listByIdEshop( $eshop->getIdEshop() );
        
        $categorias = array();
        $data = array();
        foreach ( $eshopTiendas as $eshopTienda ) {
                        
            $categoriasTienda = array();
            $esttcs = $eshopTienda->getEshopTiendaTiendaCategorias();
            foreach( $esttcs as $esttc ) {
                $eshopTiendaCategoria = $esttc->getEshopTiendaCategoria();
                $categorias[ $eshopTiendaCategoria->getIdEshopTiendaCategoria() ] = $eshopTiendaCategoria->getDenominacion();
                $categoriasTienda[ $eshopTiendaCategoria->getIdEshopTiendaCategoria() ] = $eshopTiendaCategoria->getDenominacion();
            }
                        
            $data[] = array(
                'nombre' => $eshopTienda->getDenominacion(),
                'dir' => $eshopTienda->getDireccion(),
                'tel' =>  $eshopTienda->getTelefono(),
                'lat' =>  $eshopTienda->getLatitud(),
                'lng' =>  $eshopTienda->getLongitud(),
                'clases' => implode(',', array_keys($categoriasTienda) ),
            );
        }
        
        $this->categorias = $categorias;
        $this->eshopTiendas = $data;
        $this->eshop = $eshop;
        $this->jsonTiendas = json_encode( $data );
    }

}