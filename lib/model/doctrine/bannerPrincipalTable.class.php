<?php

/**
 * bannerPrincipalTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class bannerPrincipalTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object bannerPrincipalTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('bannerPrincipal');
    }
    
    /**
     * Retorna el listado de banners principales activos y vigentes;
     *
     * @return bannerPrincipal
     */
    public function listVigentes($extenderVigencia = 0)
    {
        return $this->createQuery('bp')
                        ->addWhere('DATE_SUB(bp.fecha_desde, INTERVAL ? DAY) < NOW() AND NOW() < bp.fecha_hasta', array( $extenderVigencia ))
                        ->addWhere('bp.activo = ?', true)
                        ->orderBy('bp.orden ASC')
                        ->useResultCache(true, null, 'bannerPrincipal_listVigentes' . cacheHelper::getInstance()->genKey($extenderVigencia) )
                        ->execute();
    }
    
    /**
     * Retorna un banner principal segun su id
     *
     * @return bannerPrincipal
     */
    public function getById($id)
    {
        return $this->createQuery('bp')
        ->addWhere('bp.id_banner_principal = ?', $id)
        ->useResultCache(true, null, cacheHelper::getInstance()->genKey("bannerPrincipal_getById_" . $id) )
        ->fetchOne();
    }

    /**
     * Update del orden de un bannerPrincipal
     *
     * @param $idBannerPrincipal
     * @param $orden
     *
     */
    public function updateOrden($idBannerPrincipal, $orden)
    {
      $this->createQuery('bp')
           ->update()
           ->set('bp.orden', $orden)
           ->addwhere('bp.id_banner_principal = ?', $idBannerPrincipal)
           ->execute();
    }
    
}