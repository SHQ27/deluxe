<?php


class ncreditoWsRequestTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de ncreditoWsRequestTable;
     *
     * @return ncreditoWsRequestTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ncreditoWsRequest');
    }
    
    /**
     * Retorna la ultima ejecucion de un WS para un $idNCredito
     *
     * @param int  $idNCredito
     *
     * @return ncreditoWsRequest
     */
    public function getLastByIdNCredito( $idNCredito )
    {
        return $this->createQuery('ncwr')
        ->innerJoin('ncwr.ncreditoWsRequestNcredito ncwrnc')
        ->addWhere('ncwrnc.id_ncredito= ?', array( $idNCredito ) )
        ->orderBy('ncwr.fecha DESC')
        ->limit(1)
        ->fetchOne();
    }
    
}