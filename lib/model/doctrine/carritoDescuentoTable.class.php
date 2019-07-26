<?php


class carritoDescuentoTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de carritoDescuentoTable;
	* 
	* @return carritoDescuentoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('carritoDescuento');
    }
    
	
	/**
	* Elimina todos los descuentos en el carrito de una session
	*  
	*/
    public function deleteAllByIdSession( $idSession )
	{
		$carritoDescuento = $this->getByIdSession( $idSession );
		if ($carritoDescuento)
		{
    		$carritoDescuento->getDescuento()->devolver();
    		$carritoDescuento->delete();
		}
	}
	
	
	/**
	* Elimina todos los descuentos en el carrito de una session
	*  
	*/
    public function clearAllByIdSession( $idSession )
	{
    	return $this->createQuery('d')
						->delete()
						->addWhere('d.id_session = ?', $idSession)
						->execute();
	}
		
	
	/**
	* Retorna el descuento en el carrito de una session
	*  
	*/
	public function getByIdSession( $idSession )
	{		
    	return $this->createQuery('d')
						->select()
						->addWhere('d.id_session = ?', $idSession)
						->fetchOne();
	}
	
	/**
	* Retorna la cantidad de apariciones de un descuento en todos los carritos
	*  
	*/
	public function quantityByIdDescuento( $idDescuento )
	{    			
    	return $this->createQuery('d')
						->addWhere('d.id_descuento = ?', $idDescuento)
						->count();
	}
    
}