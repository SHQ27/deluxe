<?php


class descuentoRestriccionTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de descuentoRestriccionTable;
     *
     * @return descuentoRestriccionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('descuentoRestriccion');
    }
    
    /**
     * Retorna el listado de restricciones de un descuento para un tipo determinado
     *
     * @param integer $idDescuento
     * @param string $tipo
     *
     * @return Doctrine_Collection
     */
    public function listByCompoundKey($idDescuento, $tipo)
    {
        return $this->createQuery('dr')
        ->select('dr.*')
        ->addwhere('dr.id_descuento= ?', $idDescuento)
        ->addwhere('dr.tipo = ?', $tipo)
        ->execute();
    }
    
    /**
     * Retorna una restricciones en particular
     *
     * @param integer $idDescuento
     * @param string $tipo
     * @param integer $valor
     * @return descuentoRestriccion
     */
    public function getOne($idDescuento, $tipo, $valor = null)
    {
        $q =  $this->createQuery('dr')
                   ->select('dr.*')
                   ->addwhere('dr.id_descuento= ?', $idDescuento)
                   ->addwhere('dr.tipo = ?', $tipo);
        
        if ( $valor ) $q->addwhere('dr.valor = ?', $valor);        
        
        return $q->fetchOne();
    }
    
    /**
     * Elimina las restricciones de un descuento para un tipo determinado
     *
     * @param integer $idDescuento
     * @param string $tipo
     *
     * @return Doctrine_Collection
     */
    public function deleteByCompoundKey($idDescuento, $tipo)
    {
        return $this->createQuery('dr')
        ->delete()
        ->addwhere('dr.id_descuento= ?', $idDescuento)
        ->addwhere('dr.tipo = ?', $tipo)
        ->execute();
    }
    
    /**
     * Retorna true si existe al menos uno de los valores
     *
     * @param integer $idDescuento
     * @param string $tipo
     * @param array $valores
     *
     * @return bool
     */
    public function existsOne($idDescuento, $tipo, $valores)
    {
        return (bool) $this->createQuery('dr')
                            ->addwhere('dr.id_descuento= ?', $idDescuento)
                            ->addwhere('dr.tipo = ?', $tipo)
                            ->whereIn('dr.valor', $valores)
                            ->count();
    }

    /**
     * Retorna true si el tipo de restriccion es exclutente
     * 
     * @param integer $idDescuento
     * @param string $tipo
     *
     * @return bool
     */
    public function esRestriccionExcluyente($idDescuento, $tipo)
    {
        return (bool) $this->createQuery('dr')
                    ->select('dr.excluir')
                    ->addwhere('dr.id_descuento = ?', $idDescuento)
                    ->addwhere('dr.tipo = ?', $tipo)
                    ->addwhere('dr.excluir = true')
                    ->count();
    }

    /**
     * Retorna true si el tipo de restriccion es exclutente
     * 
     * @param integer $idDescuento
     * @param string $tipo
     * @param bool $excluir
     *
     * @return bool
     */
    public function validarGrupo($idDescuento, $tipo, $valores, $excluir)
    {
        $valores = array_unique( $valores );

        if ( $excluir && !$valores) {
            return true;
        }
        
        $coincidentes = $this->createQuery('dr')
                             ->select('dr.excluir')
                             ->addwhere('dr.id_descuento = ?', $idDescuento)
                             ->addwhere('dr.tipo = ?', $tipo)
                             ->addwhere('dr.excluir = ?',  $excluir)
                             ->whereIn('dr.valor', $valores)
                             ->count();

        if ( $excluir ) {
            return $coincidentes == 0;
        } else {
            return $coincidentes == count($valores);
        }
    }
    



}