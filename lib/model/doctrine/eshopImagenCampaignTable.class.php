<?php

/**
 * eshopImagenCampaignTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class eshopImagenCampaignTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object eshopImagenCampaignTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('eshopImagenCampaign');
    }

    /**
     * Retorna el listado ordenado para armar la seccion campaign
     *
     * @param integer $idEshop
     *
     * @return Doctrine_Collection
     */
    public function listCampaign($idEshop, $slide = null)
    {
        $q = $this->createQuery('eic')
                  ->addWhere('eic.id_eshop = ?', $idEshop)
                  ->addWhere('eic.activo = ?', true);

        $cacheSlide = '';
        if ( $slide !== null ) {
            $q->addWhere('eic.slide = ?', $slide);
            $cacheSlide = $slide ? 1 : 0;
        }

        $q->orderBy('eic.orden DESC');
        $q->useResultCache(true, 3600, cacheHelper::getInstance()->genKey("eshopImagenCampaign_list_" . $idEshop . '_' . $cacheSlide) );

        return $q->execute();
    }

    /**
     * Retorna el eshopImagenCampaign con orden mas bajo
     *
     * @param integer $idEshop
     *
     * @return eshopImagenCampaign
     */
    public function getFirst($idEshop)
    {
        return $this->createQuery('eic')
                    ->addWhere('eic.id_eshop = ?', $idEshop)
                    ->orderBy('eic.orden ASC')
                    ->limit(1)
                    ->fetchOne();
    }
    
    /**
     * Retorna el eshopImagenCampaign con orden mas alto
     *
     * @param integer $idEshop
     *
     * @return eshopImagenCampaign
     */
    public function getLast($idEshop)
    {
        return $this->createQuery('eic')
                    ->addWhere('eic.id_eshop = ?', $idEshop)
                    ->orderBy('eic.orden DESC')
                    ->limit(1)
                    ->fetchOne();
    }
    
    /**
     * Retorna el anterior eshopImagenCampaign para un $orden
     *
     * @param integer $idEshop
     * @param integer $orden
     *
     * @return eshopImagenCampaign
     */
    public function getPrev( $idEshop, $orden )
    {
        return $this->createQuery('eic')
                    ->addWhere('eic.id_eshop = ?', $idEshop)
                    ->addWhere('eic.orden < ?', array( $orden ) )
                    ->orderBy('eic.orden DESC')
                    ->limit(1)
                    ->fetchOne();
    }
    
    /**
     * Retorna el siguiente eshopImagenCampaign para un $orden
     *
     * @param integer $idEshop
     * @param integer $orden
     *
     * @return eshopImagenCampaign
     */
    public function getNext( $idEshop, $orden )
    {
        return $this->createQuery('eic')
                    ->addWhere('eic.id_eshop = ?', $idEshop)
                    ->addWhere('eic.orden > ?', array( $orden ) )
                    ->orderBy('eic.orden ASC')
                    ->limit(1)
                    ->fetchOne();
    }

}