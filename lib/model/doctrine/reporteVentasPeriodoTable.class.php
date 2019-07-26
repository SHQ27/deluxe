<?php


class reporteVentasPeriodoTable extends Doctrine_Table
{
	/**
	* Retorna una instancia de reporteVentasPeriodoTable;
	* 
	* @return reporteVentasPeriodoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('reporteVentasPeriodo');
    }
    
	/**
	* Retorna todos los reportes diarios entre dos fechas
	*  
	* @return Doctrine_Collection
	*/
    public function listByPeriodo($fechaDesde, $fechaHasta)
    {        
    	return $this->createQuery('r')
					->addWhere('? <= DATE(r.fecha) AND DATE(r.fecha) <= ?', array($fechaDesde, $fechaHasta) )
					->execute();
    } 

	/**
	* Retorna todos los reportes diarios entre dos fechas
	*  
	* @return Doctrine_Collection
	*/
    public function getTotalDineroIngresado($fechaDesde, $fechaHasta)
    {    	
    	return $this->createQuery('r')
    				->select('SUM(total_dinero_ingresado_flash + total_dinero_ingresado_permanente + total_dinero_ingresado_mixto)')
					->addWhere('? <= r.fecha AND r.fecha <= ?', array($fechaDesde, $fechaHasta) )
					->fetchOne( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
    } 
    
}