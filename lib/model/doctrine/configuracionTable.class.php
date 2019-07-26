<?php


class configuracionTable extends Doctrine_Table
{
    /**
     * @return configuracionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('configuracion');
    }
    /**
     * Devuelve el valor de la configuracion
     * 
     * @param string $id Configuracion id
     * 
     * @return mixed
     */
    static public function getValor($id)
    {
        return configuracionTable::getInstance()->getById($id)->getValor();        
    }
    
    public function getOutlet()
    {
        return $this->createQuery('c')
                     ->addWhere('c.id_configuracion = ?', configuracion::OUTLET)
                     ->useResultCache(true, null, cacheHelper::getInstance()->genKey('configuracion_getOutlet') )
                     ->fetchOne();
    }
    
    public function getById($idConfiguracion)
    {
        return $this->createQuery('c')
        ->addWhere('c.id_configuracion = ?', $idConfiguracion)
        ->useResultCache(true, null, cacheHelper::getInstance()->genKey('configuracion_getById_' . $idConfiguracion) )
        ->fetchOne();
    }

    public function montoFreeShipping($eshop, $campana = null)
    {       
        if ( $campana && $campana->getTieneEnvioGratis() ) return 0;
        
        if ( $eshop && $eshop->getIdEshop() ) {
            $montoFreeShipping = $eshop->getFreeshipping(); 
        } else {
            $montoFreeShipping = configuracionTable::getInstance()->findOneByIdConfiguracion( configuracion::MONTO_FREE_SHIPPING ); 
            $montoFreeShipping = $montoFreeShipping->getValor();
        }       

        return $montoFreeShipping;
    }
    
    
    
    
}