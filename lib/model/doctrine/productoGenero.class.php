<?php

/**
 * productoGenero
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class productoGenero extends BaseproductoGenero
{
	CONST MUJER = 'MUJ';
	CONST HOMBRE= 'HOM';
	CONST NINOS = 'NIN';

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
		return $this->getDenominacion();
	}
	
}