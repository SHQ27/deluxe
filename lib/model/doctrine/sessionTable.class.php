<?php

class sessionTable extends Doctrine_Table
{
	protected $session;
    
	/**
	* Retorna una instancia de sessionTable;
	* 
	* @return sessionTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Session');
    }
    
    public function getSession()
    {
    	
    	if (!$this->session)
    	{
	        $this->session = $this->findOneBy('id_session', session_id() );
	        
	        if (!$this->session)
	        {
	        	$usuario = sfContext::getInstance()->getUser()->getCurrentUser();
	        	$idUsuario = ( $usuario ) ? $usuario->getIdUsuario() : null;

	        	$session = new session();
	        	$session->setIdSession( session_id() );
	        	$session->setFechaUltimaAccion( date('Y-m-d H:i:s') );
	        	$session->setIdUsuario( $idUsuario );
	        	$session->save();
	        	
	        	$this->session = $session;
	        } else {
	        	$this->session->setFechaUltimaAccion( date('Y-m-d H:i:s') );
	        	$this->session->save();
	        }
    	}
        
        return $this->session;
    }
    
	/**
	* Retorna las sessiones expiradas
	* 
	* @return Doctrine_Collection
	*/
	public function listSessionesExpiradas($soloConCarritoDescuento = false)
	{
		$expiracionEnSegundos = sfConfig::get('app_carrito_minutosExpiracion') * 60;
		
		$q = $this->createQuery('s');
		$q->select('s.*');

		if ( $soloConCarritoDescuento ) {
		    $q->addSelect('cd.*, d.*');
		    $q->innerJoin('s.carritoDescuento cd');
		    $q->innerJoin('cd.descuento d');
		}
		
	    $q->addWhere('TIME_TO_SEC(TIMEDIFF(NOW(), s.fecha_ultima_accion)) > ?', $expiracionEnSegundos);
    			    
	    return $q->execute();
	}
	
	
	
	/**
	* Retorna el total en carrito entre productos 
	* 
	* @return Doctrine_Collection
	*/
	public function getMontoProductos($idSession)
	{
		return carritoProductoItemTable::getInstance()->getTotalByIdSession( $idSession );
	}
	
	/**
	* Retorna true si hay algun producto perteneciente a una campaña en el carrito de la session
	* 
	* @return Doctrine_Collection
	*/
	public function hayOfertas($idSession)	
    {	
		$cantProductoCampana =  $this->createQuery('s')
									->innerJoin('s.carritoProductoItem cpi')
									->innerJoin('cpi.productoItem pi')
									->innerJoin('pi.producto p')
									->innerJoin('p.productoCampana')
				    			    ->addWhere('s.id_session = ?', $idSession)
				    			    ->count();
				    			    				    			    
		return (bool)($cantProductoCampana);
	}

	/**
	* Retorna true si hay algun producto perteneciente a outlet en el carrito de la session
	* 
	* @return Doctrine_Collection
	*/
	public function hayOutlet($idSession)	
    {	
		$cantProductoCampana =  $this->createQuery('s')
									->innerJoin('s.carritoProductoItem cpi')
									->innerJoin('cpi.productoItem pi')
									->innerJoin('pi.producto p')
				    			    ->addWhere('s.id_session = ?', $idSession)
				    			    ->addWhere('p.es_outlet = true')
				    			    ->count();
				    			    				    			    
		return (bool)($cantProductoCampana);
	}
	
	
	/**
	 * Elimina todas las sessiones dada una session o un array de sessiones
	 *
	 */
	public function deleteAllByIdSession( $idsSession )
	{
	    $idsSession = ( is_array($idsSession) ) ? $idsSession : array($idsSession);
	
	    return $this->createQuery('s')
	    ->delete()
	    ->andWhereIn('s.id_session', $idsSession )
	    ->execute();
	}

    public function listForRemarkety($desde, $hasta, $limit, $page){
        
        $q = $this->createQuery('s')
        		  ->innerJoin('s.carritoProductoItem cp')
        		  ->leftJoin('s.carritoBonificacion cb')
        		  ->leftJoin('s.carritoDescuento cd')
        		  ->leftJoin('s.carritoEnvio ce')
        		  ->addWhere('s.id_usuario IS NOT NULL');  


        if ( $desde ) {
          $q->addWhere('s.fecha_ultima_accion >= ?', $desde);  
        }
        
        if ( $hasta ) {
          $q->addWhere('s.fecha_ultima_accion <= ?', $hasta);
        }

        $q->orderBy('s.fecha_ultima_accion asc');

      	return $q->limit($limit)
                 ->offset($limit * $page)
                 ->execute();
    }
	
}