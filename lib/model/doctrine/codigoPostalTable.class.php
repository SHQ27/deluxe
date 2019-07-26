<?php


class codigoPostalTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('codigoPostal');
    }

    
    /**
     * Retorna un bool segun si el valor existe en la tabla de codigos postales
     *
     * @param integer $valor
     *
     * @return bool
     */
    public function exists($valor)
    {
        return (bool) $this->createQuery('cp')
        ->addWhere('cp.valor = ?', $valor)
        ->count();
    }

    public function listAll()
    {
        return $this->createQuery('cp')
                    ->select('cp.valor')
                    ->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }
    
    public function getCpByState($state, $cp)
    {
        return (bool) $this->createQuery('cp')
        ->addWhere('cp.id_provincia = ?', $state)
        ->addWhere('cp.valor = ?', $cp)
        ->count();
    }
    
}