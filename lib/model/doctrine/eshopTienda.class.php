<?php

/**
 * eshopTienda
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class eshopTienda extends BaseeshopTienda
{
    public function preSave($event)   {         
        $this->clearCache($event);
    }
    
    public function preDelete($event) {
        $eshopTiendaTiendaCategorias = eshopTiendaTiendaCategoriaTable::getInstance()->findByIdEshopTienda( $this->getIdEshopTienda() );
        foreach ( $eshopTiendaTiendaCategorias as $eshopTiendaTiendaCategoria ) {
            $eshopTiendaTiendaCategoria->delete();
        }
        
        $this->clearCache($event);
    }
    
    public function clearCache($event)
    {
        cacheHelper::getInstance()->deleteByPrefix('eshopTienda');
    }
}