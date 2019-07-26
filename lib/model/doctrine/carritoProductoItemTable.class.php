<?php


class carritoProductoItemTable extends Doctrine_Table
{   
	/**
	* Retorna una instancia de carritoProductoItemTable;
	* 
	* @return carritoProductoItemTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('carritoProductoItem');
    }
    
	/**
	* Retorna todos los productoItem en un carrito que corresponden con la session enviada por parametro
	* 
	* @param integer $idSession
	* 
	* @return Doctrine_Collection
	*/
	public function getByIdCarritoProductoItem( $idCarritoProductoItem )
	{
		return $this->findOneBy('id_carrito_producto_item', $idCarritoProductoItem);
	}
    
	
	/**
	* Elimina todos los productoItems en el carrito de una session o un array de sessiones
	*  
	*/
    public function deleteAllByIdSession( $idsSession )
	{
	    $idsSession = ( is_array($idsSession) ) ? $idsSession : array($idsSession);
	    
	    return $this->createQuery('c')
            	    ->delete()
            	    ->andWhereIn('c.id_session', $idsSession )
            	    ->execute();
	}
	
	/**
	* Retorna todos los productoItem en el carrito que corresponden con la session enviada por parametro
	* 
	* @param integer $idSession
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdSession( $idSession )
	{
		return $this->createQuery('c')
    			    ->addWhere('c.id_session= ?', array( $idSession ) )
    			    ->execute();
	}
	
	/**
	 * Retorna todos los productoItem en el carrito que corresponden con la session enviada por parametro para el carrito rapido
	 *
	 * @param integer $idSession
	 *
	 * @return Doctrine_Collection
	 */
	public function listForCarritoRapido( $idSession )
	{
	    return $this->createQuery('c')
	    ->innerJoin('c.productoItem pi')
	    ->innerJoin('pi.producto p')
	    ->innerJoin('p.marca m')
	    ->innerJoin('p.productoCategoria pc')
	    ->addWhere('c.id_session= ?', array( $idSession ) )
	    ->execute();
	}
	
	/**
	 * Retorna el monto del articulo con menor valor del carrito
	 *
	 * @param integer $idSession
	 *
	 * @return float
	 */
	public function getMontoProductoMenorValor( $idSession )
	{
	    return $this->createQuery('c')
	    ->select('min(p.precio_deluxe)')
	    ->innerJoin('c.productoItem pi')
	    ->innerJoin('pi.producto p')
	    ->addWhere('c.id_session= ?', array( $idSession ) )
	    ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	* Retorna la cantidad en todos los carrito actuales de un productoItem determinado.
	* 
	* @param integer $idProductoItem
	* 
	* @return integer
	*/
	public function getCantidadByIdProductoItem( $idProductoItem )
	{
		$query = $this->createQuery('c')
					  ->select( 'sum(c.cantidad)' )
    			      ->addWhere('c.id_producto_item= ?', array( $idProductoItem ) );
		
		return (int) $query->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
		
	}
	
	
	/**
	* Retorna true si el $idProductoItem esta asociado a algun pedido
	* 
	* @param integer $idProductoItem
	* 
	* @return bool
	*/
	public function exist( $idProductoItem )
	{
		return (bool) $this->createQuery('c')
    			    ->addWhere('c.id_producto_item = ?', array( $idProductoItem ) )
    			    ->count();
	}
	
	/**
	* Retorna la cantidad en todos los carrito actuales de un productoItem determinado que no esten en una session determinada
	* 
	* @param integer $idProductoItem
	* 
	* @return integer
	*/
	public function getCantidadByIdProductoItemAndSession( $idProductoItem, $idSession )
	{
		return $this->createQuery('c')
					->select( 'sum(c.cantidad)' )
    			    ->addWhere('c.id_producto_item= ?', array( $idProductoItem ) )
    			    ->addWhere('c.id_session <> ?', array( $idSession ) )
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	/**
	* Retorna el peso total de todos los productos en el carrito de una session
	* 
	* @param integer $id_session
	* 
	* @return float
	*/
	public function getPesoByIdSesion( $idSession )
	{
		return (float)$this->createQuery('cpi')
					->select( 'sum(cpi.cantidad * p.peso)' )
					->innerJoin('cpi.productoItem pi ')
					->innerJoin('pi.producto p')
    			    ->addWhere('cpi.id_session = ?', array( $idSession ) )
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}
	
	
	/**
	* Agrega un productoItem al carrito, y si ya existe solo le suma la cantidad.
	*  
	* @return carritoProductoItem
	*/
	public function addProductoItem( $productoItem, $cantidad )
	{		
		$session = sessionTable::getInstance()->getSession();
		
		$carritoProductoItem =  $this->createQuery('c')
					->addWhere('c.id_producto_item= ?', array( $productoItem->getIdProductoItem() ) )
    			    ->addWhere('c.id_session= ?', array( $session->getIdSession() ) )
    			    ->fetchOne();
    			    
		if (!$carritoProductoItem)
		{
			$carritoProductoItem = new carritoProductoItem();
			$carritoProductoItem->setIdProductoItem( $productoItem->getIdProductoItem() );
  			$carritoProductoItem->setIdSession( $session->getIdSession() );
		}
		else
		{
			$cantidad = $cantidad + $carritoProductoItem->getCantidad();
		}
		
  		$carritoProductoItem->setCantidad( $cantidad );
  		$carritoProductoItem->save();
  		
  		return $carritoProductoItem;
	}
	
	/**
	* Edita un productoItem del carrito
	*  
	* @return carritoProductoItem
	*/
	public function editProductoItem( $idCarritoProductoItem, $idProductoTalle, $idProductoColor, $cantidad)
	{
		
		$carritoProductoItem = $this->getByIdCarritoProductoItem( $idCarritoProductoItem );
				
  		$productoItem = productoItemTable::getInstance()->getByCompoundKey(
  											$carritoProductoItem->getProductoItem()->getIdProducto(),
  											$idProductoTalle,
  											$idProductoColor
  										);
		
		$carritoProductoItem->setIdProductoItem( $productoItem->getIdProductoItem() );
  		$carritoProductoItem->setCantidad( $cantidad );
  		$carritoProductoItem->save();
  		
  		return $carritoProductoItem;
	}
	
	/**
	* Retorna el valor total de los productoItems en el carrito de una session
	* 
	* @param Doctrine_Collection $carritoProductoItem
	* 
	* @return float
	*/
	public function getTotalByIdSession( $idSession )
	{
		$total = 0;
		$carritoProductoItems = $this->listByIdSession( $idSession );
		
		foreach($carritoProductoItems as $carritoProductoItem)
		{
			$total += $carritoProductoItem->getSubTotal();
		}
		
		return $total;
	}    
	
	/**
	* Retorna el total de items de producto para una session
	* 
	* @param $idSession
	* 
	* @return integer
	*/
	public function getCantidadItemsByIdSession( $idSession )
	{
		return $this->createQuery('c')
					->select('SUM(c.cantidad)')
    			    ->addWhere('c.id_session= ?', array( $idSession ) )
    			    ->fetchOne( array(), doctrine_core::HYDRATE_SINGLE_SCALAR );
	}    
	
	
	/**
	 * Retorna true si debe mostrarse el cartel de aviso de mezcla 
	 *
	 * @return bool
	 */
	public function mostrarCartelMezcla( $idSession, $producto )
	{
		$status = $this->verificarMezcla($idSession);
		 		
		if ( $status['cantProductos'] == 0 )
		{
		    return false;
		}
		
		if ( $producto->getEsOutlet() )
		{
		    return !$status['outlet'];
		}
				
		$productoCampanas = $producto->getProductoCampana();
		if ( count( $productoCampanas ) == 0 )
		{
		    return !$status['stockPermanente'];
		}
		
		if ( $status['campana'] )
		{
		    $productoCampana = productoCampanaTable::getInstance()->getOne($producto->getIdProducto(), $status['campana']->getIdCampana() );
		    return !$productoCampana;
		}
		
		return true;
	}
	
	/**
	 * Retorna el resultado de la informacion de mezcla para calcular si debe mostrarse o no el cartel
	 *
	 * @return bool
	 */
	public function verificarMezcla( $idSession )
	{
		$data =  $this->createQuery('cpi')
		->select('cpi.id_carrito_producto_item, pi.id_producto_item, p.es_outlet, pc.id_campana, p.id_marca ')
		->innerJoin('cpi.productoItem pi')
		->innerJoin('pi.producto p')
		->leftJoin('p.productoCampana pc')
		->addWhere('cpi.id_session= ?', array( $idSession ) )
		->execute( array(), Doctrine::HYDRATE_SCALAR );
	
		$aux['esOutlet'] = $aux['idCampana'] = array();
	
		$cantProductos = 0;
		foreach ($data as $row)
		{
			$aux['esOutlet'][ $row["p_es_outlet"] ]		= $row["p_es_outlet"];
			$aux['idCampana'][ $row["pc_id_campana"] ]	= $row["pc_id_campana"];
			$cantProductos++;
		}
				
		$outlet = count( $aux['esOutlet'] ) == 1 && current($aux['esOutlet']) == true;
		
		$idCampana = current( $aux['idCampana'] );
		$idCampana = ( count( $aux['idCampana'] ) == 1 && $idCampana ) ? $idCampana : null;
		$campana   = ( $idCampana ) ? campanaTable::getInstance()->getById( $idCampana ) : false;
		
		$stockPermanente = !$outlet && !$campana;
		
		return array( 'outlet' => $outlet, 'campana' => $campana, 'stockPermanente' => $stockPermanente, 'cantProductos' => $cantProductos );	
	}
	
}