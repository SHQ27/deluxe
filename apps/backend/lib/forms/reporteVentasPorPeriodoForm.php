<?php

class reporteVentasPorPeriodoForm extends sfFormSymfony
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
	    
		$this->getWidgetSchema()->setNameFormat('reporteVentasPorPeriodo[%s]');
	
	    $this->setValidators
	    (
	    	array
	    	(
		    	'periodo' => new sfValidatorDateTime(array('required' => true)),
	    	)
	    );
  	}

	public function download()
	{
		set_time_limit(0);
		
		$values = $this->getTaintedValues();
		
		$periodo['from'] = $values['periodo']['from']['year'] . '-' . sprintf('%02d', $values['periodo']['from']['month']) . '-' . sprintf('%02d', $values['periodo']['from']['day']);
		$periodo['to'] = $values['periodo']['to']['year'] . '-' . sprintf('%02d', $values['periodo']['to']['month']) . '-' . sprintf('%02d', $values['periodo']['to']['day']);
		
		if ( !$values['periodo']['from']['year'] || !$values['periodo']['to']['year'] ) return false;
		
		$reportes = reporteVentasPeriodoTable::getInstance()->listByPeriodo($periodo['from'], $periodo['to']);

		$totalDineroIngresadoFlash = $totalDineroIngresadoPermanente = $totalDineroIngresadoMixto = 0;
		$costoEnvioFlash = $costoEnvioPermanente = $costoEnvioMixto = 0;
		$descuentosUsadosFlash = $descuentosUsadosPermanente = $descuentosUsadosMixto = 0;
		$bonificacionesUsadosFlash = $bonificacionesUsadosPermanente = $bonificacionesUsadosMixto = 0;
		$cantidadPedidos050 = $cantidadPedidos50100 = $cantidadPedidos100200 = $cantidadPedidos200Mas = 0;
		$comisionesFlash = $comisionesPermanente = $comisionesMixto = 0;
		$ventaTotalFlash = $ventaTotalPermanente = 0;
		$costoMercaderiaFlash = $costoMercaderiaPermanente = 0;		
		$unidadesFlash = $unidadesPermanente = 0;
		$cantidadPedidosFlash = $cantidadPedidosPermanente = $cantidadPedidosMixto = 0;
		$primeraCompra = 0;
		$cantidadPedidos = 0;
		
		
		foreach ($reportes as $reporte)
		{
			$totalDineroIngresadoFlash			+= $reporte->getTotalDineroIngresadoFlash();
			$totalDineroIngresadoPermanente		+= $reporte->getTotalDineroIngresadoPermanente();
			$totalDineroIngresadoMixto			+= $reporte->getTotalDineroIngresadoMixto();
	
			$costoEnvioFlash					+= $reporte->getCostoEnvioFlash();
			$costoEnvioPermanente				+= $reporte->getCostoEnvioPermanente();
			$costoEnvioMixto					+= $reporte->getCostoEnvioMixto();
	
			$descuentosUsadosFlash				+= $reporte->getDescuentosUsadosFlash();
			$descuentosUsadosPermanente			+= $reporte->getDescuentosUsadosPermanente();
			$descuentosUsadosMixto				+= $reporte->getDescuentosUsadosMixto();
	
			$bonificacionesUsadosFlash			+= $reporte->getBonificacionesUsadosFlash(); 
			$bonificacionesUsadosPermanente		+= $reporte->getBonificacionesUsadosPermanente();
			$bonificacionesUsadosMixto			+= $reporte->getBonificacionesUsadosMixto();

			$cantidadPedidos050					+= $reporte->getCantidadPedidos050();
			$cantidadPedidos50100				+= $reporte->getCantidadPedidos50100();
			$cantidadPedidos100200				+= $reporte->getCantidadPedidos100200();
			$cantidadPedidos200Mas				+= $reporte->getCantidadPedidos200Mas();
	
			$ventaTotalFlash					+= $reporte->getVentaTotalFlash();
			$ventaTotalPermanente				+= $reporte->getVentaTotalPermanente();
	
			$costoMercaderiaFlash				+= $reporte->getCostoMercaderiaFlash();
			$costoMercaderiaPermanente			+= $reporte->getCostoMercaderiaPermanente();
			
			$unidadesFlash						+= $reporte->getUnidadesFlash();
			$unidadesPermanente					+= $reporte->getUnidadesPermanente();
			
			$cantidadPedidosFlash				+= $reporte->getCantidadPedidosFlash();
			$cantidadPedidosPermanente			+= $reporte->getCantidadPedidosPermanente();
			$cantidadPedidosMixto				+= $reporte->getCantidadPedidosMixto();			
	
			$primeraCompra						+= $reporte->getClientePrimeraCompra();
				
			$comisionesFlash 					+= $reporte->getComisionesFlash();
			$comisionesPermanente 				+= $reporte->getComisionesPermanente();
			$comisionesMixto 					+= $reporte->getComisionesMixto();		 
		}
				
		$phpExcel = new PHPExcel();
		
		$phpExcel->getProperties()->setCreator("DeluxeBuys");
		$activeSheet = $phpExcel->setActiveSheetIndex(0);
		 
		$formatCurrencyCell = '$#,##0.00';
		
		$headerCellStyle = array(
			  'font' => array('bold' => true),
		      'borders' => array(
		        'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN,
		          'color' => array('argb' => '000000'))));	
		
		$dataCellStyle = array(
		      'borders' => array(
		        'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN,
		          'color' => array('argb' => '000000'))));
		
		
		$activeSheet->setCellValue('A2', 'Informe General: del ' . $periodo['from'] . ' al ' . $periodo['to']);
		$activeSheet->mergeCells('A2:D2');
		
		$activeSheet->setCellValue('A4', 'Concepto');
		$activeSheet->getColumnDimension('A')->setWidth(25);
		$activeSheet->getStyle('A4')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B4', 'Flash Sales');
		$activeSheet->getColumnDimension('B')->setWidth(15);
		$activeSheet->getStyle('B4')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('C4', 'Permanente');
		$activeSheet->getColumnDimension('C')->setWidth(15);
		$activeSheet->getStyle('C4')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('D4', 'Mixto');
		$activeSheet->getColumnDimension('D')->setWidth(15);
		$activeSheet->getStyle('D4')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('E4', 'Total');
		$activeSheet->getColumnDimension('E')->setWidth(15);
		$activeSheet->getStyle('E4')->applyFromArray($headerCellStyle);
		
		
		$activeSheet->setCellValue('A5', 'Total Dinero Ingresado');
		$activeSheet->getStyle('A5')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B5', $totalDineroIngresadoFlash );
		$activeSheet->getStyle('B5')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C5', $totalDineroIngresadoPermanente );
		$activeSheet->getStyle('C5')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D5', $totalDineroIngresadoMixto );
		$activeSheet->getStyle('D5')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$totalDineroIngresado = $totalDineroIngresadoFlash + $totalDineroIngresadoPermanente + $totalDineroIngresadoMixto;
		$activeSheet->setCellValue('E5', $totalDineroIngresado );
		$activeSheet->getStyle('E5')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		
		
		$activeSheet->setCellValue('A6', 'Venta total');
		$activeSheet->getStyle('A6')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B6', $ventaTotalFlash);
		$activeSheet->getStyle('B6')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C6', $ventaTotalPermanente);
		$activeSheet->getStyle('C6')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D6', '-');
		$ventaTotal = $ventaTotalPermanente + $ventaTotalFlash;
		$activeSheet->setCellValue('E6', $ventaTotal);
		$activeSheet->getStyle('E6')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		$activeSheet->setCellValue('A7', 'Costo de Mercaderia');
		$activeSheet->getStyle('A7')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B7', $costoMercaderiaFlash);
		$activeSheet->getStyle('B7')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C7', $costoMercaderiaPermanente);
		$activeSheet->getStyle('C7')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D7', '-');
		$costoMercaderia = $costoMercaderiaPermanente + $costoMercaderiaFlash;
		$activeSheet->setCellValue('E7', $costoMercaderia );
		$activeSheet->getStyle('E7')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		$activeSheet->setCellValue('A8', 'Costo de Envío');
		$activeSheet->getStyle('A8')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B8', $costoEnvioFlash );
		$activeSheet->getStyle('B8')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C8', $costoEnvioPermanente );
		$activeSheet->getStyle('C8')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D8', $costoEnvioMixto );
		$activeSheet->getStyle('D8')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$costoEnvio = $costoEnvioFlash + $costoEnvioPermanente + $costoEnvioMixto;
		$activeSheet->setCellValue('E8', $costoEnvio );
		$activeSheet->getStyle('E8')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		$activeSheet->setCellValue('A9', 'Comisiones');
		$activeSheet->getStyle('A9')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B9', $comisionesFlash );
		$activeSheet->getStyle('B9')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C9', $comisionesPermanente );
		$activeSheet->getStyle('C9')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D9', $comisionesMixto );
		$activeSheet->getStyle('D9')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$comisiones = $comisionesFlash + $comisionesPermanente + $comisionesMixto;
		$activeSheet->setCellValue('E9', $comisiones);
		$activeSheet->getStyle('E9')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		$activeSheet->setCellValue('A10', 'Margen de Contribucion');
		$activeSheet->getStyle('A10')->applyFromArray($headerCellStyle);
		$activeSheet->getStyle('A10')->applyFromArray($headerCellStyle);
		$porc = (int) (($ventaTotalFlash / $costoMercaderiaFlash) * 100);
		$activeSheet->setCellValue('B10',  $porc. '%');
		
		if ( $costoMercaderiaPermanente ) {
		    $porc = (int) (($ventaTotalPermanente / $costoMercaderiaPermanente) * 100);
		} else {
		    $porc = 0;
		}
		
		$activeSheet->setCellValue('C10', $porc. '%' );
		$activeSheet->setCellValue('D10', '-');
		$porc = (int) (($ventaTotal / $costoMercaderia) * 100);
		$activeSheet->setCellValue('E10', $porc . '%' );
		
		$activeSheet->setCellValue('A11', 'Cantidad de Pedidos');
		$activeSheet->getStyle('A11')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B11',  $cantidadPedidosFlash );
		$activeSheet->setCellValue('C11',  $cantidadPedidosPermanente );
		$activeSheet->setCellValue('D11', $cantidadPedidosMixto );
		$cantidadPedidos = $cantidadPedidosFlash + $cantidadPedidosPermanente + $cantidadPedidosMixto;
		$activeSheet->setCellValue('E11', $cantidadPedidos );
		
		$activeSheet->setCellValue('A12', 'Unidades');
		$activeSheet->getStyle('A12')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B12', $unidadesFlash );
		$activeSheet->setCellValue('C12', $unidadesPermanente );
		$unidades = $unidadesFlash + $unidadesPermanente;
		$activeSheet->setCellValue('D12', '-');
		$activeSheet->setCellValue('e12', $unidades);
		
		$activeSheet->setCellValue('A13', 'Descuentos');
		$activeSheet->getStyle('A13')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B13', $descuentosUsadosFlash );
		$activeSheet->getStyle('B13')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C13', $descuentosUsadosPermanente );
		$activeSheet->getStyle('C13')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D13', $descuentosUsadosMixto );
		$activeSheet->getStyle('E13')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$descuentosUsados = $descuentosUsadosFlash + $descuentosUsadosPermanente + $descuentosUsadosMixto;
		$activeSheet->setCellValue('E13', $descuentosUsados );
		$activeSheet->getStyle('E13')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		$activeSheet->setCellValue('A14', 'Bonificaciones');
		$activeSheet->getStyle('A14')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B14', $bonificacionesUsadosFlash );
		$activeSheet->getStyle('B14')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C14', $bonificacionesUsadosPermanente );
		$activeSheet->getStyle('C14')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D14', $bonificacionesUsadosMixto );
		$activeSheet->getStyle('D14')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$bonificacionesUsados = $bonificacionesUsadosFlash + $bonificacionesUsadosPermanente +$bonificacionesUsadosMixto;
		$activeSheet->setCellValue('E14', $bonificacionesUsados );
		$activeSheet->getStyle('E14')->getNumberFormat()->setFormatCode($formatCurrencyCell);
				
		$activeSheet->setCellValue('A15', 'Ticket Promedio');
		$activeSheet->getStyle('A15')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B15', $totalDineroIngresadoFlash / $cantidadPedidosFlash );
		$activeSheet->getStyle('B15')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('C15', ( $cantidadPedidosPermanente ) ? $totalDineroIngresadoPermanente / $cantidadPedidosPermanente : 0 );
		$activeSheet->getStyle('C15')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('D15', ( $cantidadPedidosMixto ) ? $totalDineroIngresadoMixto / $cantidadPedidosMixto : 0 );
		$activeSheet->getStyle('D15')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		$activeSheet->setCellValue('E15', $totalDineroIngresado / $cantidadPedidos );
		$activeSheet->getStyle('E15')->getNumberFormat()->setFormatCode($formatCurrencyCell);
		
		$activeSheet->setCellValue('A16', 'Ganancia');
		$activeSheet->getStyle('A16')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('E16', $totalDineroIngresado - $costoMercaderia - $comisiones );
		$activeSheet->getStyle('E16')->getNumberFormat()->setFormatCode($formatCurrencyCell);
				
		$activeSheet->setCellValue('A19', 'Concepto');
		$activeSheet->getStyle('A19')->applyFromArray($headerCellStyle);
		$activeSheet->getStyle('B19')->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('A20', 'Pedidos de 0 a 50');
		$activeSheet->getStyle('A20')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B20', $cantidadPedidos050 );
		$activeSheet->getStyle('B20')->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('A21', 'Pedidos de 50 a 100');
		$activeSheet->getStyle('A21')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B21', $cantidadPedidos50100 );
		$activeSheet->getStyle('B21')->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('A22', 'Pedidos de 100 a 200');
		$activeSheet->getStyle('A22')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B22', $cantidadPedidos100200 );
		$activeSheet->getStyle('B22')->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('A23', 'Pedidos de mas de 200');
		$activeSheet->getStyle('A23')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B23', $cantidadPedidos200Mas );
		$activeSheet->getStyle('B23')->applyFromArray($dataCellStyle);

		$activeSheet->setCellValue('A25', 'Cliente que compraron por primera vez');
		$activeSheet->getStyle('A25')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('B25', $primeraCompra );
		$activeSheet->getStyle('B25')->applyFromArray($dataCellStyle);
		
		$activeSheet->setCellValue('H4', 'Meses Anteriores');
		$activeSheet->getStyle('H4')->applyFromArray($headerCellStyle);
		$activeSheet->getStyle('I4')->applyFromArray($headerCellStyle);
		$activeSheet->mergeCells('H4:I4');
		$activeSheet->setCellValue('H5', 'Mes');
		$activeSheet->getColumnDimension('H')->setWidth(15);
		$activeSheet->getStyle('H5')->applyFromArray($headerCellStyle);
		$activeSheet->setCellValue('I5','Total Dinero Ingresado');
		$activeSheet->getStyle('I5')->applyFromArray($headerCellStyle);
		$activeSheet->getColumnDimension('I')->setWidth(22);
		
		for($i = 5 ; $i <= 16 ; $i++ )
		{		
			$activeSheet->getStyle('B' . $i)->applyFromArray($dataCellStyle);
			$activeSheet->getStyle('C' . $i)->applyFromArray($dataCellStyle);
			$activeSheet->getStyle('D' . $i)->applyFromArray($dataCellStyle);
			$activeSheet->getStyle('E' . $i)->applyFromArray($dataCellStyle);
		}

		$month = $values['periodo']['from']['month'];
		
		for($i = 1 ; $i <= 10 ; $i++ )
		{
			$desde = mktime(0, 0, 0, $month - $i, 1,   $values['periodo']['from']['year'] );
			$fechaDesde = date('Y-m-d', $desde);
			
			$hasta = mktime(0, 0, 0, $month - $i + 1, 0,   $values['periodo']['from']['year'] );
			$fechaHasta = date('Y-m-d', $hasta);
			
			$totalDineroIngresado = (float) reporteVentasPeriodoTable::getInstance()->getTotalDineroIngresado($fechaDesde, $fechaHasta);
						
			if (!$totalDineroIngresado) continue;
						
			$formatDate = new sfDateFormat('es');
			
			$iCell = $i + 5;
			
			$fecha = ucfirst($formatDate->format($desde, 'MMMM')) . ' ' . date('Y', $desde);
			$activeSheet->setCellValue('H' . $iCell, $fecha);
			$activeSheet->getStyle('H' . $iCell)->applyFromArray($dataCellStyle);
			
			$activeSheet->setCellValue('I' . $iCell, $totalDineroIngresado);
			$activeSheet->getStyle('I' . $iCell )->getNumberFormat()->setFormatCode($formatCurrencyCell);
			$activeSheet->getStyle('I' . $iCell)->applyFromArray($dataCellStyle);
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte.xls"');
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
		$writer->save('php://output');
		exit;
	}
}