<?php

class reporteComercialesForm extends sfFormSymfony
{
  	public function configure()
  	{  		
	    $this->setWidgets
	    (
	    	array
	    	(
				'periodo' => new sfWidgetFormFilterDate(array('from_date' => new pmWidgetFormDate(), 'to_date' => new pmWidgetFormDate(), 'with_empty' => false, 'template' => '<div class="selectPeriodo">from %from_date%<br/>to %to_date%</div>'))
	    	)
	    );
	    
		$this->getWidgetSchema()->setNameFormat('reporteComercialesForm[%s]');
	
	    $this->setValidators
	    (
	    	array
	    	(
		    	'periodo' => new sfValidatorDateTime(array('required' => true)),
	    	)
	    );
  	}

	public function process()
	{
		set_time_limit(0);
				
		$values = $this->getTaintedValues();
		
		$periodo['from'] = $values['periodo']['from']['year'] . '-' . sprintf('%02d', $values['periodo']['from']['month']) . '-' . sprintf('%02d', $values['periodo']['from']['day']);
		$periodo['to'] = $values['periodo']['to']['year'] . '-' . sprintf('%02d', $values['periodo']['to']['month']) . '-' . sprintf('%02d', $values['periodo']['to']['day']);
		
		if ( !$values['periodo']['from']['year'] || !$values['periodo']['to']['year'] ) return false;
				
		$comerciales = comercialTable::getInstance()->findAll();
		
		$totalFacturado   = 0;
		$unidadesVendidas = 0;
		$cantidadCampanas = 0;
		$precioDeluxe     = 0;
		$costo            = 0;
		$costoRI          = 0;
		$costoMonotributo = 0;
		$envio            = 0;
		
		foreach ($comerciales as $comercial)
		{
		    $reporte = campanaTable::getInstance()->getReporteByComercial($comercial->getIdComercial(), $periodo['from'], $periodo['to']);
		    		    
		    $data[$comercial->getIdComercial()] = array('comercial' => $comercial, 'reporte' => $reporte);
		    
		    $unidadesVendidas += $reporte['unidades_vendidas'];
		    $precioDeluxe     += $reporte['precio_deluxe'];
		    $costo            += $reporte['costo'];
		    $costoRI          += $reporte['costo_ri'];
		    $costoMonotributo += $reporte['costo_monotributo'];
		}
		 
		$general = campanaTable::getInstance()->getReporteComercialTotales($periodo['from'], $periodo['to']);
		        
        $general['unidades_vendidas'] = $unidadesVendidas;
        $general['precio_deluxe']     = $precioDeluxe;
        $general['costo']             = $costo;
        $general['costo_ri']          = $costoRI;
        $general['costo_monotributo'] = $costoMonotributo;
        
		$general['unidades_promedio'] = ( $general['cant_pedidos'] ) ? $general['unidades_vendidas'] / $general['cant_pedidos'] : 0;
		$general['ticket_promedio']   = ( $general['cant_pedidos'] ) ? $general['precio_deluxe'] / $general['cant_pedidos'] : 0;
		$general['margen_promedio']   = ( $general['costo'] ) ? sprintf('%d', ( ($general['precio_deluxe'] / $general['costo'] ) - 1 ) * 100 ) : 0;
		$general['desglose']          = campanaTable::getInstance()->getReporteComercialDesgloseTotal($periodo['from'], $periodo['to']);
		
		
		return array('general' => $general, 'reporte' => $data);
	}
}