<?php


class campanaMarcaTable extends Doctrine_Table
{
	/**
	* Retorna una instancia de campanaMarcaTable;
	* 
	* @return campanaMarcaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('campanaMarca');
    }
    
    
	/**
	* Elimina todas las marcas de una campaña
	* 
	* @param number $idCampana
	* 
	* @return Doctrine_Collection 
	*/
    public function listByIdCampana($idCampana)
    {    
		return $this->createQuery('cm')
				    ->addwhere('cm.id_campana = ?', $idCampana)  
					->execute();
    }
    
	/**
	* Elimina todos los campanaMarca asociados a una campaña
	* 
	* @param number $idCampana
	* 
	*/
    public function deleteByIdCampana($idCampana)
    {        	
		$this->createQuery('cm')
				->delete()
			    ->addwhere('cm.id_campana = ?', $idCampana)  
				->execute();
    }
    
    /**
     * Retorna la campanaMarca que coincide con la clave compuesta
     *
     * @param integer $idCampana
     * @param integer $idMarca
     *
     * @return campanaMarca
     */
    public function getByCompoundKey( $idCampana, $idMarca )
    {
        return $this->createQuery('cm')
        ->addWhere('cm.id_campana= ?', array( $idCampana ) )
        ->addWhere('cm.id_marca= ?', array( $idMarca ) )
        ->fetchOne();
    }
    
    /**
     * Retorna el telefono asignado a la ultima campaña con telefono asignado para una marca enviado por parametro
     *
     * @param number $idMarca
     * 
     * @return string
     *
     */
    public function getTelefonoOC($idMarca)
    {
        return $this->createQuery('cm')
                    ->select('cm.telefono_orden_compra')
                    ->addwhere('cm.id_marca = ?', $idMarca)
                    ->addwhere('cm.telefono_orden_compra IS NOT NULL')
                    ->orderBy('cm.id_campana desc')
                    ->fetchOne(array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }
    
    /**
     * Retorna los mails asignados a la ultima campaña con mail asignado para una marca enviado por parametro
     *
     * @param number $idMarca
     *
     * @return string
     *
     */
    public function getEmailsOC($idMarca)
    {
        return $this->createQuery('cm')
        ->select('cm.email_orden_compra')
        ->addwhere('cm.id_marca = ?', $idMarca)
        ->addwhere('cm.email_orden_compra IS NOT NULL')
        ->orderBy('cm.id_campana desc')
        ->fetchOne(array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    }
    
    
    /**
     * Retorna el listado de campañas para las cuales debe enviarse el mail de OC a la marca
     *
     * @return Doctrine_Collection
     */
    public function pendientesDeEnvio()
    {
        $horasEsperaEnvioOrdenCompra = configuracionTable::getInstance()->getValor( configuracion::HORAS_ESPERA_ENVIO_ORDEN_COMPRA );
        $minutosEsperaEnvioOrdenCompra = $horasEsperaEnvioOrdenCompra * 60;
    
        return $this->createQuery('cm')
                    ->innerJoin('cm.campana c')
                    ->addWhere('TIMESTAMPDIFF(MINUTE, c.fecha_fin, NOW()) >= ?', $minutosEsperaEnvioOrdenCompra)
                    ->addWhere('cm.email_orden_compra IS NOT NULL')
                    ->addWhere('cm.enviar_aviso_orden_compra = ?', true)
                    ->addWhere('cm.ultimo_envio IS NULL')
                    ->execute();
    }
    
    /**
     * Retorna el listado de campañas para las cuales debe enviarse el mail de aviso a la marca para entrega de mercaderia
     *
     * @return Doctrine_Collection
     */
    public function pendientesDeEntrega()
    {
        $horasEsperaEnvioOrdenCompra = configuracionTable::getInstance()->getValor( configuracion::HORAS_ESPERA_ENVIO_ORDEN_COMPRA );
    
        return $this->createQuery('cm')
                    ->innerJoin('cm.campana c')
                    ->addWhere('TIMESTAMPDIFF(HOUR, c.fecha_fin, NOW()) > ?', $horasEsperaEnvioOrdenCompra)
                    ->addWhere('cm.email_orden_compra IS NOT NULL')
                    ->addWhere('cm.enviar_aviso_orden_compra = ?', true)
                    ->addWhere('cm.ultimo_envio IS NOT NULL')
                    ->addWhere('TIMESTAMPDIFF(HOUR, cm.ultimo_envio, NOW()) > 24 OR cm.ultimo_envio IS NULL' )
                    ->execute();
    }
    
}