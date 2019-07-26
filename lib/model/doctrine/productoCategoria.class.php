<?php

/**
 * productoCategoria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class productoCategoria extends BaseproductoCategoria
{	
    public function preSave($event)   {
        $this->clearCache($event);
    }
    public function preDelete($event) {
        $this->clearCache($event);
    }
    
    public function clearCache($event)
    {
        cacheHelper::getInstance()->deleteByPrefix('productoCategoria_listByIdProductoGenero');
    }
    
	public function __toString()
	{
		return $this->getProductoGenero()->getDenominacion() . " :: " . $this->getDenominacion();
	}
	
	public function getProductoGeneroSlug()
	{
	  return 'MUJ';
	}
	
	public function getProductoGenero()
	{
		return productoGeneroTable::getInstance()->getByIdProductoGenero( $this->getIdProductoGenero() );
	}

	public function getProductoCategoriaEshop( $idEshop )
	{
		return productoCategoriaEshopTable::getInstance()->getByCompoundKey( $idEshop, $this->getIdProductoCategoria() );
	}
}
