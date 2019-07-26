<?php


class carritoEnvioTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de carritoEnvioTable;
	* 
	* @return carritoEnvioTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('carritoEnvio');
    }
    
	/**
	* Elimina la direccion de envio almacenada en el carrito de una session o un array de sessiones
	*  
	*/
    public function deleteAllByIdSession( $idsSession )
	{
	    $idsSession = ( is_array($idsSession) ) ? $idsSession : array($idsSession);
	    
    	return $this->createQuery('ce')
				    ->delete()
					->andWhereIn('ce.id_session', $idsSession )
					->execute();
	}
	
	/**
	* Retorna la direccion de envio almacenada en el carrito de una session
	*  
	*/
	public function getByIdSession( $idSession )
	{    			
    	return $this->createQuery('ce')
						->select()
						->addWhere('ce.id_session = ?', $idSession)
						->fetchOne();
	}
    
}