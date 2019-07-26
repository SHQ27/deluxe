<?php

class pmDateHelper
{
	static protected $instance;
	
	protected $config;

	protected function __construct()
	{
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new pmDateHelper();
		}
		
		return self::$instance;
	}

	public function sumarDiasHabiles($dias, $formato = 'd/m/Y', $initial_timestamp = null)
	{
		$i = 0;
		
		$initial_timestamp = ($initial_timestamp)? $initial_timestamp : time(); 
		
		$fecha = mktime( 0, 0, 0, date("m", $initial_timestamp), date("d", $initial_timestamp), date("Y", $initial_timestamp) );
		
		if ( date("N", $fecha) >= 6 )
		{
			$diaSemana = date("N", $fecha);
			$fecha = $fecha + ( 86400 * ( 8 - $diaSemana ) ); 
		}
		
		while ( $i < $dias )
		{
			$fecha = $fecha + 86400;

			if ( date("N", $fecha) < 6 )
			{
				$i++;
			}    		
		}
		
		return date($formato, $fecha);  
	}	
	
	public function restarDiasHabiles($dias, $formato = 'd/m/Y', $initial_timestamp = null)
	{
		$i = 0;
		
		$initial_timestamp = ($initial_timestamp)? $initial_timestamp : time(); 
		
		$fecha = mktime( 0, 0, 0, date("m", $initial_timestamp), date("d", $initial_timestamp), date("Y", $initial_timestamp) );
		
		if ( date("N", $fecha) >= 6 )
		{
			$diaSemana = date("N", $fecha);
			$fecha = $fecha + ( 86400 * ( 5 - $diaSemana ) ); 
		}
				
		while ( $i < $dias )
		{
			$fecha = $fecha - 86400;

			if ( date("N", $fecha) < 6 )
			{
				$i++;
			}    		
		}
		
		return date($formato, $fecha);
	}
	
	public function fechasBySemana($nSemana, $anio)
	{	    
	    return array (
	            'from' => date('m/d/Y', strtotime($anio."W".$nSemana."1")),
	            'to' => date('m/d/Y', strtotime($anio."W".$nSemana."7")) );
	}

}



