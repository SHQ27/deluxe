<?php


class pedidoBonificacionTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de pedidoBonificacionTable;
	* 
	* @return pedidoBonificacionTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('pedidoBonificacion');
    }
    
    /**
     * Retorna true si la bonificacion enviada por parametro esta asociada a algun pedido
     *
     * @param $idBonificacion
     *
     * @return boolean
     */
    public function estaAsociada($idBonificacion)
    {
    	return (bool) $this->createQuery('b')
    				->addwhere('b.id_bonificacion = ?',$idBonificacion)
    				->count();
    }
    
    
    public function cantidadUsuariosSuscriptosCompradores($tipoBonificacion) {
            return $this->createQuery('pb')
            ->innerJoin('pb.pedido p')
            ->leftJoin('pb.bonificacion b')
            ->leftJoin('b.usuario u')
            ->addWhere('b.id_tipo_bonificacion = ?', $tipoBonificacion)
            ->addWhere('p.id_eshop IS NULL')
            ->count();
    }
}