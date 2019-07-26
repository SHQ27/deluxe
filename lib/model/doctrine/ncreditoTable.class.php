<?php


class ncreditoTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de ncreditoTable;
	* 
	* @return ncreditoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ncredito');
    }
    
	/**
	* Retorna el listado de todas las notas de credito pendientes de procesar
	* 
	* 
	* @return Doctrine_Collection
	*/
	public function listPendientes($limit = false)
	{
	    $configWS = sfConfig::get('app_afip_ws');
	    
		$q = $this->createQuery('nc')
				  ->addWhere('nc.procesada = ?', false)
				  ->addWhere('nc.entorno = ?', $configWS['env'] );

		if ($limit) $q->limit( $limit );
		
		return $q->execute();
	}
	
	/**
	* Retorna un array con el listado de todas las notas de credito que coincidan con el array de $idsNCredito enviado por parametro
	* 
	* @param array  $idsNCredito
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdNCredito($idsNCredito, $returnAsArray = false)
	{
		$q = $this->createQuery('nc')
			      ->whereIn('nc.id_ncredito', $idsNCredito);
		
		if ( $returnAsArray )
		{
		    return $q->execute( array(), doctrine::HYDRATE_ARRAY);
		}
		else
		{
		    return $q->execute();
		}
		
	}
	
	/**
	* Crea una nueva nota de credito, pendiente de procesarse, a partir de la informacion de un array de pedidos y el valor de la misma
	* 
	* @param array  $idsPedido
	* @param float $importe
	* 
	* @return Doctrine_Collection
	*/
	public function insert($idsPedidos, $importe)
	{
	    if ( $importe <= 0 ) return false;
	    
		$configWS = sfConfig::get('app_afip_ws');
			    
	    $facturas = facturaTable::getInstance()->listByIdPedido($idsPedidos, $configWS['env']);
	    
	    $conn = Doctrine_Manager::connection();
	    
	    try
	    {
	        $conn->beginTransaction();
	    
	        if ( count($facturas) )
	        {
	            $notaCredito = new ncredito();
	            $notaCredito->setProcesada(false);
	            $notaCredito->setImporte($importe);
	            $notaCredito->setEntorno( $configWS['env'] );
	            $notaCredito->save();
	        
	            foreach( $facturas as $factura )
	            {
	                $ncreditoFactura = new ncreditoFactura();
	                $ncreditoFactura->setIdFactura( $factura->getIdFactura() );
	                $ncreditoFactura->setIdNcredito( $notaCredito->getIdNcredito() );
	                $ncreditoFactura->save();
	            }
	        }
	    
	        $conn->commit();
	    
	        return true;
	    }
	    catch(Doctrine_Exception $e)
	    {
	        $conn->rollback();
	        return false;
	    }

	}	
    
}