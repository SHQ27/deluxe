<?php


class direccionEnvioTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de direccionEnvioTable;
	* 
	* @return direccionEnvioTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('direccionEnvio');
    }
    
	/**
	* Retorna la direccionEnvio asociada a un usuario
	*  
	* @return direccionEnvio
	*/
	public function getByIdUsuario( $idUsuario )
	{    			
    	return $this->findOneBy('id_usuario', $idUsuario);
	}
	
}