<?php


class productoColorTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de productoColorTable;
	* 
	* @return productoColorTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('productoColor');
    }
        
	/**
	* Retorna el productoTalle que coincide con su denominacion
	* 
	* @return productoTalle
	*/
	public function getByDenominacion($denominacion)
	{
		return $this->createQuery('pc')
					->addWhere('pc.denominacion = ?', $denominacion)
					->fetchOne();
	}	
    
	/**
	 * 
	 * Retorna una lista de Todos los colores
	 * 
	 * @return productoColor
	 */
	public function listAll()
	{
		return $this->createQuery('pc')
					->orderBy('pc.denominacion ASC')
					->execute();
	}
		
}