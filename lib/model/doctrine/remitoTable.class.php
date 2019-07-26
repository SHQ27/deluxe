<?php


class remitoTable extends Doctrine_Table
{
	/**
	 * Retorna una instancia de remitoTable;
	 *
	 * @return remitoTable
	 */
	public static function getInstance()
	{
		return Doctrine_Core::getTable('remito');
	}

	/**
	 * Retorna un remito
	 *
	 * @param integer $idRemito
	 *
	 * @return remito
	 */
	public function getByIdRemito($idRemito)
	{
		return $this->createQuery('r')
		->addWhere('r.id_remito= ?', $idRemito)
		->fetchOne();
	}

	/**
	 * Retorna un listado de remitos segun el array de ids enviado como parametro
	 *
	 * @param integer $idsRemito
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIdsRemito($idsRemito, $orderBy = null)
	{
		$q = $this->createQuery('r')
				  ->innerJoin('r.remitoPedido rp')
				  ->innerJoin('rp.pedido p')
		          ->andWhereIn('r.id_remito', $idsRemito);
		
		if ( $orderBy ) {
			$q->addOrderBy($orderBy, 'ASC');
		}

		return $q->execute();
	}
	
	/**
	 * Retorna todos los remitos que coinciden con el array de idsPedido enviado por parametro
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIdsPedido( $idsPedido )
	{
		return $this->createQuery('r')
					->innerJoin('r.remitoPedido rp')
				  	->whereIn('rp.id_pedido', $idsPedido)
				  	->execute();
	}

	/**
	 * Retorna todos los ultimo remitos que coinciden con el array de idsPedido enviado por parametro
	 *
	 * @return Doctrine_Collection
	 */
	public function ultimosRemitosByIdsPedido( $idsPedido, $orderBy = null)
	{
		$q = $this->createQuery('r')
				  ->select('rp.id_pedido, max(r.id_remito) as id, r.id_remito as desechable')
				  ->innerJoin('r.remitoPedido rp')
				  ->innerJoin('rp.pedido p')
				  ->addWhere('p.fecha_baja is null')
				  ->addWhere('p.codigo_envio is not null')
				  ->whereIn('rp.id_pedido', $idsPedido);

		$q->groupBy('rp.id_pedido');

		if ( $orderBy ) {
			$q->addOrderBy($orderBy, 'ASC');
		}
				
		$idsRemitos = $q->fetchArray();

		if ( !count($idsRemitos) ) {
			return array();
		}

		$ids = array();
		foreach ($idsRemitos as $row) {
			$ids[] = $row['id'];
		}

		return $this->listByIdsRemito($ids, $orderBy);
	}

}