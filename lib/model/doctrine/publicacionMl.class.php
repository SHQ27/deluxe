<?php

/**
 * publicacionMl
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class publicacionMl extends BasepublicacionMl
{
    CONST STATUS_ACTIVE = 'active';
    CONST STATUS_PAUSED = 'paused';
    CONST STATUS_CLOSED = 'closed';
    
    public function estaVigente()
    {
        if ( !$this->getFechaInicio() ) return false;
        if ( !$this->getFechaFin() ) return false;
        
        $now = time();
                
        if ( strtotime( $this->getFechaInicio() ) <= $now && $now <= strtotime( $this->getFechaFin() ) )
        {
            return true;
        }
        
        return false;
    }
    
    public function nuncaFuePublicado()
    {
        return $this->getItemId() === null;
    }
    
    public function delete(Doctrine_Connection $conn = null)
    {
        $producto = $this->getProducto();
        
        $ok = MercadoLibre::getInstance()->cerrarPublicacion($producto, true);
        
        if ( $ok )
        {
            $this->setItemId( null );
            $this->setFechaInicio( null );
            $this->setFechaFin( null );
            $this->setDataMercadoLibre( null );
            $this->setStatusMl(null);
            $this->save();            
        }
        
        return $ok;
    }
    
    public function close()
    {
        $producto = $this->getProducto();
        return MercadoLibre::getInstance()->cerrarPublicacion($producto, true);
    }
    
}
