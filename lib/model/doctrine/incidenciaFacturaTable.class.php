<?php


class incidenciaFacturaTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('incidenciaFactura');
    }

    public function listarNoCorrelativas()
    {
        return $this->createQuery('i')
                ->addWhere('i.resuelta = ?', false)
                ->execute();
    }

    public function getByValor ($value)
    {
        return $this->createQuery('i')
                ->addWhere('i.valor = ?', $value)
                ->limit(1)
                ->fetchOne();
    }
}