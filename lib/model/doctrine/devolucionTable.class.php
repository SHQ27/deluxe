<?php


class devolucionTable extends Doctrine_Table
{
	/**
	 * Retorna una instancia de devolucionTable;
	 *
	 * @return devolucionTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('devolucion');
	}
	
	/**
	 * Retorna una devolucion a partir de su id
	 *
	 * @param integer $idDevolucion
	 *
	 * @return devolucion
	 */
	public function getByIdDevolucion($idDevolucion)
	{
		return $this->createQuery('d')
		->addWhere('d.id_devolucion = ?', $idDevolucion)
		->fetchOne();
	}
	
	/**
	 * Retorna el listado de devoluciones en el historial de un usuario
	 *
	 * @param integer $idUsuario
	 *
	 * @return Doctrine_Collection
	 */
	public function listHistorial($idUsuario)
	{
		return $this->createQuery('d')
		->innerJoin('d.devolucionProductoItem dpi')
		->innerJoin('dpi.pedidoProductoItem ppi')
		->innerJoin('ppi.pedido p')
		->innerJoin('ppi.productoItem pi')
		->innerJoin('pi.producto pr')
		->innerJoin('pi.productoTalle pt')
		->innerJoin('pi.productoColor pc')
		->addWhere('d.id_usuario = ?', $idUsuario)
		->orderBy('d.fecha DESC')
		->execute();		
	}
	
	/**
	 * Update de la fecha de recibido seteando la fecha actual
	 *
	 * @param array $ids
	 *
	 */
	public function updateFechaRecibido($ids)
	{
		return $this->createQuery('d')
		->update()
		->set('fecha_recibido', 'now()')
		->whereIn('d.id_devolucion', $ids)
		->execute();
	}
	
	/**
	 * Retorna una array con los idPedido asociados a una devolucion
	 *
	 * @param integer $idDevolucion
	 *
	 * @return array
	 */
	public function getIdsPedidoByIdDevolucion($idDevolucion)
	{
	    return $this->createQuery('ppi')
            	     ->select('ppi.id_pedido')
            	     ->distinct()
            	     ->from('pedidoProductoItem ppi')
            	     ->innerJoin('ppi.devolucionProductoItem dpi')
            	     ->addWhere('dpi.id_devolucion = ?', $idDevolucion)
            	     ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
	}
	
}