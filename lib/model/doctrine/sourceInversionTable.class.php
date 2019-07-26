<?php


class sourceInversionTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de sourceInversionTable;
     *
     * @return sourceInversionTable
     */    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sourceInversion');
    }
    
    /**
     * Resumen de inversiones
     *
     * @param integer $idSource
     *
     * @return array
     */
    public function getResumen($idSource)
    {
        return $this->createQuery('si')
                    ->addSelect('SUM(si.valor) as valor')
                    ->addSelect('DATE_FORMAT(si.fecha, \'%Y-%m\') as periodo')
                    ->addSelect('COALESCE(e.denominacion, \'Deluxe Buys\') as eshop')
                    ->addSelect('si.id_eshop')
                    ->leftJoin('si.eshop e')
                    ->addWhere('si.id_source = ?', $idSource)
                    ->groupBy('si.id_eshop, periodo')
                    ->orderBy('periodo')
                    ->fetchArray();
    }
    
    
    /**
     * Resumen de inversiones
     *
     * @param integer $idSource
     *
     * @return array
     */
    public function getResumenByPeriodo($periodo, $idEshop)
    {
        $q = $this->createQuery('si')
                    ->addSelect('s.denominacion denominacion')
                    ->addSelect('si.id_eshop')
                    ->addSelect('SUM(si.valor) as valor')
                    ->leftJoin('si.source s')
                    ->addWhere('si.fecha = ?', $periodo);
        
    	if ( $idEshop ) {
    	    $q->addwhere('si.id_eshop = ?', $idEshop );
    	} else {
    	    $q->addwhere('si.id_eshop IS NULL');
    	}
                    
        return $q->groupBy('si.id_source, si.id_eshop')
                 ->orderBy('s.denominacion')
                 ->fetchArray();
    }    
        
}