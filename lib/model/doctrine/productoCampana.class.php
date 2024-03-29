<?php

/**
 * productoCampana
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class productoCampana extends BaseproductoCampana
{    
    public function preSave($event)   {
        $this->clearCache($event);
    }
    
    public function postSave($event)   {
	  	$producto = productoTable::getInstance()->getById( $this->getIdProducto() );
	  	$producto->setEsOutlet(false);
	  	
	  	$producto->doNotPostActions( array(
	  	    producto::POST_ACTION_CERRAR_PUBLICACION_ML
	  	) );
	  	
	  	$producto->save();
    }
    
    public function preDelete($event)
    {
        $this->clearCache($event);
    }
        
    public function clearCache($event)
    {
        cacheHelper::getInstance()->delete('campana_getFirstByIdProducto_' . $this->getIdProducto() );
    }
    
}
