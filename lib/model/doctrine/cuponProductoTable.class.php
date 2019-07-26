<?php


class cuponProductoTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de cuponProductoTable;
	* 
	* @return cuponProductoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('cuponProducto');
    }
    
	/**
	* Retorna todos los cuponProducto asociados a un cupon
	* 
	* @param number $idCupon
	* 
	* @return Doctrine_Collection
	*/
    public function listByIdCupon($idCupon)
    {    
		return $this->createQuery('cp')
				    ->addwhere('cp.id_cupon = ?', $idCupon)  
					->execute();
    }
    
	/**
	* Retorna un objeto cuponProducto para ser eliminado 
	* 
	* @param number $idProducto
	* @param number $idCupon
	* 
	* @return cuponProducto
	*/
    public function getOne($idProducto, $idCupon)
    {    
		return $this->createQuery('cp')
				    ->addwhere('cp.id_producto = ?', $idProducto)  
				    ->addwhere('cp.id_cupon = ?', $idCupon)
					->fetchOne();
    }
    
	/**
	* Retorna una collection con los cuponProductos asignados a cupones para el dia de hoy.
	*  
	* @return Doctrine_Collection
	*/
    public function listCuponesDeHoy()
    {
		return $this->createQuery('cp')
					->select('cp.*, c.*')
					->innerJoin('cp.cupon c')
					->addWhere('( DATE_FORMAT(now(), \'%Y-%m-%d\') >= c.fecha_desde AND DATE_FORMAT(now(), \'%Y-%m-%d\') <= c.fecha_hasta )')
					->execute();
    }
    
}