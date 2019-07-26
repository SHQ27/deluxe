<?php


class stockTable extends Doctrine_Table
{
       
	/**
	* Retorna una instancia de stockTable;
	* 
	* @return stockTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('stock');
    }
    
	/**
	* Retorna el stock para un productoItem en un origen determinado
	* 
	* @return integer
	*/
	public function getStockDisponible($idProductoItem, $origen)
	{
		$q = $this->createQuery('s')
			      ->select( 'SUM(s.cantidad)' )
    			  ->addWhere('s.id_producto_item = ?', $idProductoItem)
    			  ->addWhere('s.origen = ?', $origen);
		
		return (int) $q->fetchOne( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	* Retorna el stock para un idStock
	* 
	* @return integer idStock
	*/
	public function getByIdStock($idStock)
	{
		return $this->createQuery('s')
    			    ->addWhere('s.id_stock = ?', idStock)
    			    ->fetchOne();
	}
	
	
	/**
	* Retorna todas las ocurrencias de stock para un productoItem
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProductoItem($idProductoItem)
	{
		return $this->createQuery('s')
    			    ->addWhere('s.id_producto_item = ?', $idProductoItem)
    			    ->execute();
	}
	
	/**
	* Elimina todos los movimientos de un productoItem
	*  
	* @return Doctrine_Collection
	*/
	public function deleteByIdProductoItem($idProductoItem)
	{
		$this->createQuery('s')
					->delete()
    			    ->addWhere('s.id_producto_item = ?', $idProductoItem)
    			    ->execute();
    			    
	}
	
	/**
	* Retorna todos los IdProductoItem que tuvieron movimientos entre dos fechas
	* 
	* @return Doctrine_Collection
	*/
	public function listIdProductoItemByFechas($desde, $hasta)
	{		
		return $this->createQuery('s')
					->select( 's.id_producto_item' )
					->distinct()
    			    ->addWhere('? <= DATE_FORMAT(s.fecha, \'%Y-%m-%d\') AND DATE_FORMAT(s.fecha, \'%Y-%m-%d\') <= ?', array( $desde, $hasta ) )
    			    ->fetchArray();
	}
	
	/**
	* Retorna todos los movimientos entre dos fechas
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdProductoItemAndFechas($idProductoItem, $desde, $hasta)
	{		
		return $this->createQuery('s')
					->addWhere('s.id_producto_item = ?', $idProductoItem)
    			    ->addWhere('? <= DATE_FORMAT(s.fecha, \'%Y-%m-%d\') AND DATE_FORMAT(s.fecha, \'%Y-%m-%d\') <= ?', array( $desde, $hasta ) )
    			    ->orderBy('s.id_producto_item ASC, s.fecha ASC')
    			    ->execute();
	}
	
	/**
	 * Retorna la fecha con horas, minutos y segundos del movimiento de stock por reseteo de una campaña para un $idProductoItem en una fecha determinada
	 *
	 * @return string
	 */
	public function getInstanteReseteo($idProductoItem, $fechaFinCampana)
	{	    
	    $fechaReseteo = date("Y-m-d", strtotime($fechaFinCampana));
	    
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        
        return $q->fetchOne("
                SELECT fecha FROM stock
                WHERE id_producto_item = ? and id_stock_tipo = ? and date(fecha) >= ?
                ORDER BY fecha ASC",
                array( $idProductoItem, stockTipo::SISTEMA_RESETEO_CAMPANA, $fechaReseteo )
        );
	}
	
	/**
	 * Retorna el stock disponible de un $idProductoItem inmediatamente antes del reseteo de una campaña
	 * 
	 * @return int
	 */
	public function getStockReseteado($idProductoItem, $origen, $instanteReseteo)
	{	
	    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
	
	    return $q->fetchOne("
	            SELECT cantidad * -1, id_stock_tipo FROM stock 
	            WHERE id_producto_item = ? and origen = ? and fecha = ?",
	            array( $idProductoItem, $origen, $instanteReseteo )
	    );
	}

	/**
	 * Retorna el stock de refuerzo al momento de cargar el ultimo stock de resfuerzo
	 * 
	 * @return int
	 */
	public function getUltimoRefuerzo($idProductoItem)
	{	
	    $q = Doctrine_Manager::getInstance()->getCurrentConnection();

	    $referencia = $q->fetchRow("
					 SELECT s_s.fecha, s_s.id_stock_tipo FROM stock AS s_s 
					 INNER JOIN stock_tipo AS s_st ON s_s.id_stock_tipo = s_st.id_stock_tipo 
					 WHERE s_s.id_producto_item = ? and s_s.origen = ? AND (s_st.es_de_sistema = false OR s_s.id_stock_tipo = ? OR s_s.id_stock_tipo = ?) 
					 ORDER BY s_s.fecha DESC LIMIT 1",
	            array( $idProductoItem, producto::ORIGEN_REFUERZO, stockTipo::SISTEMA_CARGA_MASIVA, stockTipo::SISTEMA_RESETEO_REFUERZO )
	    );

		$fecha = $referencia['fecha'];
		$idStockTipo = $referencia['id_stock_tipo'];
		
		if ( $idStockTipo == stockTipo::SISTEMA_RESETEO_REFUERZO ) {
			$sql = "SELECT SUM(cantidad) FROM stock WHERE id_producto_item = ? and origen = ? and fecha < ?";
		} else {
			$sql = "SELECT SUM(cantidad) FROM stock WHERE id_producto_item = ? and origen = ? and fecha <= ?";
		}

	    return $q->fetchOne($sql, array( $idProductoItem, producto::ORIGEN_REFUERZO, $fecha ) );
	}

	/**
	 * Retorna true si un $idPedidoProductoItem fue vendido como stock de refuerzo
	 * 
	 * @return int
	 */
	public function tieneRefuerzo($idPedidoProductoItem)
	{	
        return (bool) $this->createQuery('s')
                           ->addWhere('s.id_pedido_producto_item = ?', $idPedidoProductoItem)
                           ->addWhere('s.origen = ?', producto::ORIGEN_REFUERZO )
                           ->addWhere('( s.id_stock_tipo = ? OR s.id_stock_tipo = ? )', array( stockTipo::SISTEMA_REACTIVACION_PEDIDO, stockTipo::SISTEMA_VENTA ) )
                           ->count();
	}
    
}