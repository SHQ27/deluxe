<?php

/**
 * productoImagen
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class productoImagen extends BaseproductoImagen
{
	
    public function preSave($event)   {
        $this->clearCache($event);
    }
    
    public function preDelete($event) {
        $this->clearCache($event);
        
        @unlink( imageHelper::getInstance()->getPath('producto_lista_chica', $this) );
        @unlink( imageHelper::getInstance()->getPath('producto_lista_grande', $this) );
        @unlink( imageHelper::getInstance()->getPath('producto_detalle_chica', $this) );
        @unlink( imageHelper::getInstance()->getPath('producto_detalle_mediana', $this) );
        @unlink( imageHelper::getInstance()->getPath('producto_detalle_grande', $this) );
        @unlink( imageHelper::getInstance()->getPath('producto_thumb', $this) );
    }
    
    public function clearCache($event)
    {
        cacheHelper::getInstance()->delete('productoImagen_getFirst_' . $this->getIdProducto() );
    }
    
	public function getImageFilename()
	{
		return $this->getIdProductoImagen() . '.jpg';		
	}
    
	public function canOrderUp()
	{
		$first = productoImagenTable::getInstance()->getFirst( $this->getIdProducto() );
		
		if ( $first )
		{
			return $first->getIdProductoImagen() != $this->getIdProductoImagen();
		}
		
		return false;
	}

	public function canOrderDown()
	{
		$last = productoImagenTable::getInstance()->getLast( $this->getIdProducto() );
			
		if ( $last )
		{
			return $last->getIdProductoImagen() != $this->getIdProductoImagen();
		}
		
		return false;
	}
	
}
