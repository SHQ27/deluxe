<?php

class reporteMarketingForm extends sfFormSymfony
{  
	protected $formatCurrencyCell = '$#,##0.00';

  	public function configure()
  	{  		
  	    // Widget para eShops
  	    $choices = array();
  	    $eshops = eshopTable::getInstance()->listAll();
  	    $choices[ eshop::ESHOP_DELUXE ] = 'Deluxe Buys';
  	    foreach ($eshops as $eshop)
  	    {
  	        $choices[$eshop->getIdEshop()] = $eshop->getDenominacion();
  	    }
  	    $this->setWidget( 'id_eshop', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
  	    $this->GetWidget( 'id_eshop' )->setLabel('eShop');
  	    $this->setValidator( 'id_eshop', new sfValidatorChoice( array( 'choices' => array_keys($choices), 'required' => false ) ) );
  	    
  	    // Mes
  	    $choices = array();
  	     
  	    $dateLimit = mktime (0, 0, 0, 5, 1, 2010);
  	     
  	    $i = 0;
  	    do
  	    {
  	        $date = mktime (0, 0, 0, date('m') - $i, 1, date('Y'));
  	        $i++;
  	         
  	        $choices[ date('Y-m-d', $date) ] = ucfirst( strftime("%B %Y", $date) );
  	    }
  	    while( $date >= $dateLimit );
  	     
  	    array_pop($choices);
  	     
  	    
      	$this->setWidget( 'mes', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
      	$this->setValidator( 'mes', new sfValidatorPass() );
	    
		$this->getWidgetSchema()->setNameFormat('reporteMarketing[%s]');

  	}
  	
  	  	
	public function download()
	{	    
		set_time_limit(0);
		
		$idEshop = $this->getValue('id_eshop');
		$idEshop = ( $idEshop == eshop::ESHOP_DELUXE ) ? null : $idEshop;

		$mes = $this->getValue('mes');
		$explode = explode('-', $mes);
		$desde = $mes;
		$hasta = date('Y-m-d', mktime(0,0,0, $explode[1]+1, 0, $explode[0] ));

        $rawData = pedidoTable::getInstance()->getReporteMarketing($idEshop, $desde, $hasta);

	    // Seteos generales de PHPExcel
    	$headerCellStyle = array(
	        'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FFFFFF')),
		    'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        ),
	        'fill' => array(
	            'type' => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('rgb' => '333333')
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('argb' => '000000'))));

		$dataCellStyle = array(
	        'font' => array('size' => "10"),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('argb' => '000000'))));

	    $boldCellStyle = array(
	        'font' => array('bold' => true, 'size' => "10"),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('argb' => '000000'))));

		$phpExcel = new PHPExcel();
		$phpExcel->getProperties()->setCreator("DeluxeBuys");


        // Solapa de Resumen
        $phpExcel->setActiveSheetIndex( 0 );
		$activeSheet = $phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Resumen');

        $resumen = array();
        $rowTotal = array();
        $rowTotal['ya-compro-ya-suscripto']	  = array( 'cantidad' => 0, 'monto' => 0 );
        $rowTotal['primera-compra-ya-suscripto'] = array( 'cantidad' => 0, 'monto' => 0 );
        $rowTotal['primera-compra-no-suscripto'] = array( 'cantidad' => 0, 'monto' => 0 );
        foreach ($rawData as $row) {
        	$source = $row['result_pedido_source'];

			if ( !isset( $resumen[ $source ] ) ) {
		        $resumen[ $source ]['ya-compro-ya-suscripto']	    = array( 'cantidad' => 0, 'monto' => 0 );
		        $resumen[ $source ]['primera-compra-ya-suscripto'] = array( 'cantidad' => 0, 'monto' => 0 );
		        $resumen[ $source ]['primera-compra-no-suscripto'] = array( 'cantidad' => 0, 'monto' => 0 );
        	}
        	
        	if (  $row['result_id_pedido'] != $row['result_id_primer_pedido'] ) {
        		$resumen[ $source ]['ya-compro-ya-suscripto']['cantidad']++;
        		$resumen[ $source ]['ya-compro-ya-suscripto']['monto'] += $row['result_pedido_monto_total'];

        		$rowTotal['ya-compro-ya-suscripto']['cantidad']++;
        		$rowTotal['ya-compro-ya-suscripto']['monto'] += $row['result_pedido_monto_total'];

        	} else {        		
				$diff = strtotime( $row['result_pedido_fecha_alta'] ) - strtotime( $row['result_suscripcion_fecha'] );
				$dias = floor( $diff / 86400 );

				if ( $dias > 7 ) {
					$resumen[ $source ]['primera-compra-ya-suscripto']['cantidad']++;
					$resumen[ $source ]['primera-compra-ya-suscripto']['monto'] += $row['result_pedido_monto_total'];

	        		$rowTotal['primera-compra-ya-suscripto']['cantidad']++;
	        		$rowTotal['primera-compra-ya-suscripto']['monto'] += $row['result_pedido_monto_total'];
				} else {
					$resumen[ $source ]['primera-compra-no-suscripto']['cantidad']++;
					$resumen[ $source ]['primera-compra-no-suscripto']['monto'] += $row['result_pedido_monto_total'];

					$rowTotal['primera-compra-no-suscripto']['cantidad']++;
	        		$rowTotal['primera-compra-no-suscripto']['monto'] += $row['result_pedido_monto_total'];
				}
        	}
        }

	    $activeSheet->setCellValue('A1', 'Source Pedido');
	    $activeSheet->setCellValue('B1', 'Ya Compraron / Ya Suscriptos');
	    $activeSheet->mergeCells('B1:D1');
	    $activeSheet->setCellValue('B2', 'Transacciones');
	    $activeSheet->setCellValue('C2', 'Monto');
	    $activeSheet->setCellValue('D2', 'Monto Prom.'); 

	    $activeSheet->setCellValue('E1', '1° Compra / Ya Suscriptos');
	    $activeSheet->mergeCells('E1:G1');
	    $activeSheet->setCellValue('E2', 'Transacciones');
	    $activeSheet->setCellValue('F2', 'Monto');
	    $activeSheet->setCellValue('G2', 'Monto Prom.');

	    $activeSheet->setCellValue('H1', '1° Compra / No Suscriptos');
	    $activeSheet->mergeCells('H1:J1');
	    $activeSheet->setCellValue('H2', 'Transacciones');
	    $activeSheet->setCellValue('I2', 'Monto');
	    $activeSheet->setCellValue('J2', 'Monto Prom.');

	    $activeSheet->setCellValue('K1', 'Total');
	    $activeSheet->mergeCells('K1:M1');
	    $activeSheet->setCellValue('K2', 'Transacciones');
	    $activeSheet->setCellValue('L2', 'Monto');
	    $activeSheet->setCellValue('M2', 'Monto Prom.');

	    $activeSheet->getColumnDimension('A')->setWidth(20);
	    $activeSheet->getColumnDimension('B')->setWidth(12);
	    $activeSheet->getColumnDimension('C')->setWidth(12);
	    $activeSheet->getColumnDimension('D')->setWidth(12);
	    $activeSheet->getColumnDimension('E')->setWidth(12);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	    $activeSheet->getColumnDimension('G')->setWidth(12);
	    $activeSheet->getColumnDimension('H')->setWidth(12);
	    $activeSheet->getColumnDimension('I')->setWidth(12);
	    $activeSheet->getColumnDimension('J')->setWidth(12);
	    $activeSheet->getColumnDimension('K')->setWidth(12);
	    $activeSheet->getColumnDimension('L')->setWidth(12);
	    $activeSheet->getColumnDimension('M')->setWidth(12);

	    $activeSheet->getStyle('A1:M2')->applyFromArray( $headerCellStyle );

			
		$i = 3;									
	    foreach ($resumen as $source => $data) {
	    	$this->excelResumenRow( $i, $activeSheet, $source, $data );
	    	$activeSheet->getStyle('A' . $i . ':M' . $i . '')->applyFromArray( $dataCellStyle );
	    	$i++;
	    }

	    $this->excelResumenRow( $i, $activeSheet, 'Total', $rowTotal );
	    $activeSheet->getStyle('A' . $i . ':M' . $i . '')->applyFromArray( $boldCellStyle );


        // Solapa de Detalle
	    $phpExcel->createSheet(null, 1);
	    $phpExcel->setActiveSheetIndex( 1 );
		$activeSheet = $phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Detalle');

	    $activeSheet->setCellValue('A1', 'ID Pedido');
	    $activeSheet->setCellValue('B1', 'Source Pedido');
	    $activeSheet->setCellValue('C1', 'Campaign Pedido');
	    $activeSheet->setCellValue('D1', 'Valor del Carrito (Monto)');
	    $activeSheet->setCellValue('E1', 'Id del Usuario'); 
	    $activeSheet->setCellValue('F1', 'Fecha de alta del Pedido');
	    $activeSheet->setCellValue('G1', 'Id del primer Pedido');
	    $activeSheet->setCellValue('H1', 'Fecha del Primer Pedido');
	    $activeSheet->setCellValue('I1', 'Fecha de Suscripción');
	    $activeSheet->setCellValue('J1', 'Source Suscripción');
	    $activeSheet->setCellValue('K1', 'Campaign Suscripción');
	    $activeSheet->setCellValue('L1', 'Fecha de Registración');
	    $activeSheet->setCellValue('M1', 'Source Registración');
	    $activeSheet->setCellValue('N1', 'Campaign Registración');

	    $activeSheet->getColumnDimension('A')->setWidth(15);
	    $activeSheet->getColumnDimension('B')->setWidth(20);
	    $activeSheet->getColumnDimension('C')->setWidth(20);
	    $activeSheet->getColumnDimension('D')->setWidth(20);
	    $activeSheet->getColumnDimension('E')->setWidth(20);
	    $activeSheet->getColumnDimension('F')->setWidth(20);
	    $activeSheet->getColumnDimension('G')->setWidth(20);
	    $activeSheet->getColumnDimension('H')->setWidth(20);
	    $activeSheet->getColumnDimension('I')->setWidth(20);
	    $activeSheet->getColumnDimension('J')->setWidth(20);
	    $activeSheet->getColumnDimension('K')->setWidth(20);
	    $activeSheet->getColumnDimension('L')->setWidth(20);
	    $activeSheet->getColumnDimension('M')->setWidth(20);
	    $activeSheet->getColumnDimension('N')->setWidth(20);

	    $activeSheet->getStyle('A1:N1')->applyFromArray( $headerCellStyle );

	    $i = 2;
	    foreach ($rawData as $row) {
			$activeSheet->setCellValue('A' . $i, $row['result_id_pedido'] );
			$activeSheet->setCellValue('B' . $i, $row['result_pedido_source'] );
			$activeSheet->setCellValue('C' . $i, $row['result_pedido_campaign'] );
			$activeSheet->setCellValue('D' . $i, $row['result_pedido_monto_total'] );
			$activeSheet->setCellValue('E' . $i, $row['result_id_usuario'] );
			$activeSheet->setCellValue('F' . $i, date( 'd/m/Y', strtotime($row['result_pedido_fecha_alta']) ) );
			$activeSheet->setCellValue('G' . $i, $row['result_id_primer_pedido'] );
			$activeSheet->setCellValue('H' . $i, date( 'd/m/Y', strtotime($row['result_fecha_primer_pedido']) ) );

			if ( $row['result_suscripcion_fecha'] && $row['result_suscripcion_fecha'] != '0000-00-00' ) {
				$activeSheet->setCellValue('I' . $i, date( 'd/m/Y', strtotime($row['result_suscripcion_fecha']) ) );	
			} else {
				$activeSheet->setCellValue('I' . $i, 'No registrada' );
			}
			
			$activeSheet->setCellValue('J' . $i, $row['result_suscripcion_source'] );
			$activeSheet->setCellValue('K' . $i, $row['result_suscripcion_campaign'] );
			$activeSheet->setCellValue('L' . $i, date( 'd/m/Y', strtotime($row['result_registracion_fecha']) ) );;
			$activeSheet->setCellValue('M' . $i, $row['result_registracion_source'] );
			$activeSheet->setCellValue('N' . $i, $row['result_registracion_campaign'] );

			$activeSheet->getStyle('D'.$i.':D'.$i)->getNumberFormat()->setFormatCode( $this->formatCurrencyCell );
			$activeSheet->getStyle('A' . $i . ':N' . $i . '')->applyFromArray( $dataCellStyle );

			$i++;
	    }

		// Dejo la primer hoja activa 
		$phpExcel->setActiveSheetIndex(0);
		
		// Se imprime		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_marketing.xls"');
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
		$writer->save('php://output');
		exit;
	}	

	protected function excelResumenRow( $i, $activeSheet, $source, $data ) {

    	$activeSheet->setCellValue('A' . $i, $source );

    	// Ya Compraron / Ya Suscriptos
    	$activeSheet->setCellValue('B' . $i, $data['ya-compro-ya-suscripto']['cantidad'] );
    	$activeSheet->setCellValue('C' . $i, $data['ya-compro-ya-suscripto']['monto'] );
    	$promedio = 0;
    	if ( $data['ya-compro-ya-suscripto']['cantidad'] ) {
    		$promedio = $data['ya-compro-ya-suscripto']['monto'] / $data['ya-compro-ya-suscripto']['cantidad'];
    	}

    	$activeSheet->setCellValue('D' . $i, $promedio );

    	// 1° Compra / Ya Suscriptos
    	$activeSheet->setCellValue('E' . $i, $data['primera-compra-ya-suscripto']['cantidad'] );
    	$activeSheet->setCellValue('F' . $i, $data['primera-compra-ya-suscripto']['monto'] );
		$promedio = 0;
    	if ( $data['primera-compra-ya-suscripto']['cantidad'] ) {
    		$promedio = $data['primera-compra-ya-suscripto']['monto'] / $data['primera-compra-ya-suscripto']['cantidad'];
    	}

    	$activeSheet->setCellValue('G' . $i, $promedio );

    	// 1° Compra / No Suscriptos
    	$activeSheet->setCellValue('H' . $i, $data['primera-compra-no-suscripto']['cantidad'] );
    	$activeSheet->setCellValue('I' . $i, $data['primera-compra-no-suscripto']['monto'] );
		$promedio = 0;
    	if ( $data['primera-compra-no-suscripto']['cantidad'] ) {
    		$promedio = $data['primera-compra-no-suscripto']['monto'] / $data['primera-compra-no-suscripto']['cantidad'];
    	}

    	$activeSheet->setCellValue('J' . $i, $promedio );

    	// Totales
    	$cantidad = $data['ya-compro-ya-suscripto']['cantidad'] + $data['primera-compra-ya-suscripto']['cantidad'] + $data['primera-compra-no-suscripto']['cantidad'];
    	$monto    = $data['ya-compro-ya-suscripto']['monto'] + $data['primera-compra-ya-suscripto']['monto'] + $data['primera-compra-no-suscripto']['monto'];
    	$activeSheet->setCellValue('K' . $i, $cantidad );
    	$activeSheet->setCellValue('L' . $i, $monto );
		$promedio = ( $cantidad ) ? $monto / $cantidad : 0;
    	$activeSheet->setCellValue('M' . $i, $promedio );

    	$activeSheet->getStyle('C'.$i.':D'.$i)->getNumberFormat()->setFormatCode( $this->formatCurrencyCell );
    	$activeSheet->getStyle('F'.$i.':G'.$i)->getNumberFormat()->setFormatCode( $this->formatCurrencyCell );
    	$activeSheet->getStyle('I'.$i.':J'.$i)->getNumberFormat()->setFormatCode( $this->formatCurrencyCell );
    	$activeSheet->getStyle('L'.$i.':M'.$i)->getNumberFormat()->setFormatCode( $this->formatCurrencyCell );   	
	}
	
	
		
}