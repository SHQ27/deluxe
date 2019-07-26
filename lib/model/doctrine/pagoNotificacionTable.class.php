<?php


class pagoNotificacionTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de pagoNotificacionTable;
	* 
	* @return pagoNotificacionTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('pagoNotificacion');
    }
    
	/**
	* Retorna todos los pagoNotificacion sin procesar
	*  
	* @return Doctrine_Collection
	*/
    public function listSinProcesar()
    {
		return $this->createQuery('pn')
    			    ->addWhere('pn.procesado = ?', false)
    			    ->orderBy('pn.fecha ASC, pn.id_pago_notificacion ASC')	
    			    ->execute();
    }
    
    
	/**
	* Retorna el pagoNotificacion que coincide con la clave compuesta
	* 
	* @param integer $idFormaPago
	* @param integer $id
	* 
	* @return pagoNotificacion
	*/
	public function getByCompoundKey( $idFormaPago, $id )
	{
		return $this->createQuery('pn')
    			    ->addWhere('pn.id_forma_pago = ?', array( $idFormaPago ) )
    			    ->addWhere('pn.id = ?', array( $id ) )
    			    ->fetchOne();
	}
	
	/**
	 * Retorna todos los pagoNotificacion que coinciden con la clave compuesta
	 *
	 * @param integer $idFormaPago
	 * @param integer $id
	 *
	 * @return Doctrine_Collection
	 */
	public function listByCompoundKey( $idFormaPago, $id )
	{
	    return $this->createQuery('pn')
	    ->addWhere('pn.id_forma_pago = ?', array( $idFormaPago ) )
	    ->addWhere('pn.id = ?', array( $id ) )
	    ->execute();
	}
    
}