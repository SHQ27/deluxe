<?php

/**
 * pedidoDescuento
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    deluxebuys
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class pedidoDescuento extends BasepedidoDescuento
{
    
    public function getArrayInfoAdicional()
    {
        if ( !$this->getInfoAdicional() ) return array();
        
        return json_decode( $this->getInfoAdicional(), true );
    }
        
}
