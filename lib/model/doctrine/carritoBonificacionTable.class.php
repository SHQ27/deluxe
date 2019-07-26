<?php


class carritoBonificacionTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de carritoBonificacionTable;
	* 
	* @return carritoBonificacionTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('carritoBonificacion');
    }
    
	/**
	* Elimina todos las bonificaciones en el carrito de una session o un array de sessiones
	*  
	*/
	public function deleteAllByIdSession( $idsSession )
	{
	    $idsSession = ( is_array($idsSession) ) ? $idsSession : array($idsSession);
	    
    	return $this->createQuery('b')
					->delete()
					->andWhereIn('b.id_session', $idsSession )
					->execute();
	}
	
	/**
	* Retorna la bonificacion en el carrito de una session
	*  
	*/
	public function getByIdSession( $idSession )
	{    			
    	return $this->createQuery('b')
						->select()
						->addWhere('b.id_session = ?', $idSession )
						->fetchOne();
	}
    
}