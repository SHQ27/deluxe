<?php


class faqCategoriaTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de faqCategoriaTable;
     *
     * @return faqCategoriaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('faqCategoria');
    }
    
    /**
     * Lista todas las FAQs
     *
     * @return Doctrine_Collection
     */
    public function listAll( $idEshop = null )
    {
        $q = $this->createQuery('fc')
                     ->innerJoin('fc.faq f');
        
        if ( $idEshop ) {
            $q->addwhere('fc.id_eshop = ?', array( $idEshop ) );
            $cacheKey = 'listAll_' . $idEshop;
        } else {
            $q->addwhere('fc.id_eshop IS NULL');
            $cacheKey = 'listAll_null';
        }        
        
        return $q->orderBy('fc.orden asc, f.orden asc')
                 ->useResultCache(true, null, 'faqCategoria_' . cacheHelper::getInstance()->genKey( $cacheKey) )
                 ->execute();
    }
    
    /**
     * Retorna el faqCategoria con orden mas bajo
     * 
     * @param integer $idEshop
     *
     * @return faqCategoria
     */
    public function getFirst($idEshop)
    {
        $q = $this->createQuery('fc');
        
        if ( $idEshop ) {
            $q->addwhere('fc.id_eshop = ?', array( $idEshop ) );
        } else {
            $q->addwhere('fc.id_eshop IS NULL');
        }
        
        return $q->orderBy('fc.orden ASC')
                 ->limit(1)
                 ->fetchOne();
    }
    
    /**
     * Retorna el faqCategoria con orden mas alto
     *
     * @param integer $idEshop
     *
     * @return faqCategoria
     */
    public function getLast($idEshop)
    {
        $q = $this->createQuery('fc');
        
        if ( $idEshop ) {
            $q->addwhere('fc.id_eshop = ?', array( $idEshop ) );
        } else {
            $q->addwhere('fc.id_eshop IS NULL');
        }
        
        return $q->orderBy('fc.orden DESC')
                 ->limit(1)
                 ->fetchOne();
    }
    
    /**
     * Retorna el anterior faqCategoria para un $idEshop y $orden
     *
     * @param integer $idEshop
     * @param integer $orden
     *
     * @return faqCategoria
     */
    public function getPrev( $idEshop, $orden )
    {
        $q = $this->createQuery('fc');
        
        if ( $idEshop ) {
            $q->addwhere('fc.id_eshop = ?', array( $idEshop ) );
        } else {
            $q->addwhere('fc.id_eshop IS NULL');
        }
        
        return $q->addWhere('fc.orden > ?', array( $orden ) )
                 ->orderBy('fc.orden ASC')
                 ->limit(1)
                 ->fetchOne();
    }
    
    /**
     * Retorna el siguiente faqCategoria para un $idEshop y $orden
     *
     * @param integer $idEshop
     * @param integer $orden
     *
     * @return faqCategoria
     */
    public function getNext( $idEshop, $orden )
    {
        $q = $this->createQuery('fc');
        
        if ( $idEshop ) {
            $q->addwhere('fc.id_eshop = ?', array( $idEshop ) );
        } else {
            $q->addwhere('fc.id_eshop IS NULL');
        }
        
        return $q->addwhere('fc.orden < ?', array( $orden ) )
                 ->orderBy('fc.orden DESC')
                 ->limit(1)
                 ->fetchOne();
    }
    
}