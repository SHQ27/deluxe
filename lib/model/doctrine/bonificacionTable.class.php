<?php


class bonificacionTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de bonificacionTable;
	* 
	* @return bonificacionTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('bonificacion');
    }
    
	/**
	* Retorna todas las bonifcaciones vigentes de un usuario
	*  
	* @return Doctrine_Collection
	*/
	public function vigentesByIdUsuario( $idUsuario )
	{    	
    	return $this->createQuery('b')
						->where('b.id_usuario = ?', $idUsuario)
						->addWhere('b.vencimiento IS NULL OR b.vencimiento > now()')
						->addWhere('b.fue_utilizada <> ?', true)
						->addWhere('b.es_interna = ?', false)
						->execute();
	}
	
	/**
	* Retorna todas las bonifcaciones externas de un usuario
	*  
	* @return Doctrine_Collection
	*/
	public function listExternasByIdUsuario( $idUsuario )
	{    	
    	return $this->createQuery('b')
						->where('b.id_usuario = ?', $idUsuario)
						->addWhere('b.es_interna = ?', false)
						->execute();
	}
	
	/**
	* Retorna la bonificacion solo si pertenece al usuario logueado
	*  
	* @return bonificacion
	*/
	public function getBonification( $idUsuario, $idBonificacion )
	{		
    	return $this->createQuery('b')
						->addWhere('b.id_bonificacion = ?', $idBonificacion)
						->addWhere('b.id_usuario= ?', $idUsuario)
						->fetchOne();
	}
	
	public function creditoUtilizado(usuario $usuario)
	{
	    $total = $this->createQuery('b')
	    	->innerJoin('b.pedidoBonificacion pb')
	        ->select('SUM(b.valor)')
	        ->where('b.id_usuario = ?', $usuario->getIdUsuario())
	        ->addWhere('b.es_interna = ?', false)
	        ->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
	    return $total ? $total : 0;	    
	}
	
	
	public function retrieveBackendList(Doctrine_Query $q)
	{
		$rootAlias = $q->getRootAlias();
		$q->addWhere($rootAlias . '.es_interna = ?', false);
		return $q;
	}
        
    public function cantidadUsuariosSuscriptos($tipoBonificacion)
    {
        return $this->createQuery('b')
        ->addWhere('b.id_tipo_bonificacion = ?', $tipoBonificacion)
        ->count();
    }
    
    public function tieneAltaBonificada($idUsuario)
    {
        return (bool) $this->createQuery('b')
                           ->addWhere('b.id_tipo_bonificacion = ?', tipoBonificacion::ALTA_USUARIO)
                           ->addWhere('b.id_usuario = ?', $idUsuario)
                           ->count();
    }
	
}