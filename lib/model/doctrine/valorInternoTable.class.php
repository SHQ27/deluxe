<?php


class valorInternoTable extends Doctrine_Table
{
    
    /**
     * Retorna una instancia de valorInternoTable;
     *
     * @return valorInternoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('valorInterno');
    }

    /**
     *
     * @return valorInterno
     */
    public function getComprobanteNumberProcess()
    {
        return $this->createQuery('v')
                ->addWhere('v.id_valor_interno = ?', valorInterno::LAST_COMPROBANTE)
                ->fetchOne();
    }    
}
