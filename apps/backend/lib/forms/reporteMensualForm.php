<?php

class reporteMensualForm extends sfFormSymfony
{
    // Se definen variables de estilo y formato
    protected $formatCurrencyCell = '$#,##0.00';
    
    protected $headerCellStyle = array(
        'font' => array('bold' => true, 'size' => '10', 'color' => array('rgb' => 'FFFFFF')),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '333333')
        ),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'))));
    
    protected $boldCellStyle = array(
        'font' => array('bold' => true, 'size' => "10"),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'))));
    
    protected $dataCellStyle = array(
        'font' => array('size' => "10"),
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => '000000'))));
    
    protected $greenCellStyle = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '8ED6B7')
        ));
    
    protected $yellowCellStyle = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'F2E768')
        ));
    
    protected $redCellStyle = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'F2687B')
        ));
        
    
    // Variables para gestion de phpexcel
        
    protected $phpExcel;
    
    protected $sheetIndex = 0;
    
    
    
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
	    
		$this->getWidgetSchema()->setNameFormat('reporteMensual[%s]');

  	}
  	
  	  	
	public function download()
	{	    
		set_time_limit(0);
		
		$idEshop = $this->getValue('id_eshop');
		$mes = $this->getValue('mes');
		$explode = explode('-', $mes);
		$desde = $mes;
		$hasta = date('Y-m-d', mktime(0,0,0, $explode[1]+1, 0, $explode[0] ));
		

	    // Seteos generales de PHPExcel
		$this->phpExcel = new PHPExcel();
		$this->phpExcel->removeSheetByIndex(0);
						
		// Armado del reportes segun eShop elegido
		if ( $idEshop == eshop::ESHOP_DELUXE ) {
		    $this->reporteDeluxe( $desde, $hasta );
		} else {
		    $this->reporteEshop($desde, $hasta, $idEshop);
		}
		
		// Dejo la primer hoja activa 
		$this->phpExcel->setActiveSheetIndex(0);
		
		// Se imprime		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_mensual.xls"');
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel5');
		$writer->save('php://output');
		exit;
	}	
	
	protected function reporteEshop($desde, $hasta, $idEshop)
	{
	    $eshop = eshopTable::getInstance()->getById( $idEshop );
	    
	    $this->phpExcel->getProperties()->setCreator( $eshop->getDenominacion() );
	    
	    $this->reporteVentasXDia( $desde, $hasta, $idEshop );
	    $this->reporteVentasXProvincia( $desde, $hasta, $idEshop );
	    $this->reporteDescuentos( $desde, $hasta, $idEshop );
	    $this->reporteDevolucionesYFaltantes( $desde, $hasta, $idEshop );
	    $this->reporteEnvio( $desde, $hasta, $idEshop );
	    $this->reporteDetalleFallados( $desde, $hasta, $idEshop );
	    $this->reporteDetalleDevoluciones( $desde, $hasta, $idEshop );
	    $this->reporteDetalleFaltantes( $desde, $hasta, $idEshop );
	    $this->reporteMarketing( $desde, $hasta, $idEshop );
	    $this->reporteMasVendidos( $desde, $hasta, $idEshop );
	    $this->reporteMenosVendidos( $desde, $hasta, $idEshop );
	    $this->reporteDocumentosNoFiscales( $desde, $hasta, $idEshop );	    
	}
	
	protected function reporteDeluxe( $desde, $hasta )
	{
	    $this->phpExcel->getProperties()->setCreator("DeluxeBuys");
	    
	    $this->reporteVentas( $desde, $hasta );
	    $this->reporteVentasXDia( $desde, $hasta );
	    $this->reporteVentasXProvincia( $desde, $hasta );
	    $this->reporteDescuentos( $desde, $hasta );
	    $this->reporteDevolucionesYFaltantes( $desde, $hasta );
	    $this->reporteFormaPago( $desde, $hasta );
	    $this->reporteEnvio( $desde, $hasta );
	    $this->reporteDetalleFallados( $desde, $hasta );
	    $this->reporteDetalleDevoluciones( $desde, $hasta );
	    $this->reporteDetalleFaltantes( $desde, $hasta );
	    $this->reporteMarketing( $desde, $hasta );
	    $this->reporteMasVendidos( $desde, $hasta );
	    $this->reporteMenosVendidos( $desde, $hasta );
	}
	
	
	protected function reporteVentas( $desde, $hasta )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex($this->sheetIndex);
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    
	    $activeSheet->setTitle('Ventas');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getVentasReporteMensual($desde, $hasta);
	    
	    $totalPrecioConIva = $reporte['totalPrecioConIva'];
	    $data = $reporte['data'];
	    
	    $activeSheet->setCellValue('A3', 'Campaña');
	    $activeSheet->setCellValue('B3', 'Venta Con IVA');
	    $activeSheet->setCellValue('C3', 'Venta Sin IVA');
	    $activeSheet->setCellValue('D3', 'Costo Con IVA');
	    $activeSheet->setCellValue('E3', 'Costo Sin IVA');
	    $activeSheet->setCellValue('F3', 'Unidades');
	    $activeSheet->setCellValue('G3', 'Cliente');
	    $activeSheet->setCellValue('H3', 'Pedido');
	    $activeSheet->setCellValue('I3', 'Porc.');
	    $activeSheet->setCellValue('J3', 'TP');
	    $activeSheet->setCellValue('K3', 'Repeticion de Compra');
	    $activeSheet->setCellValue('L3', 'Unid. x Pedido');
	    $activeSheet->setCellValue('M3', 'Margen %');
	    $activeSheet->setCellValue('N3', 'MarkUp');
	    $activeSheet->setCellValue('O3', 'Margen');
	    
	    $activeSheet->getStyle('A3:O3')->getAlignment()->setWrapText(true);
	    
	    $activeSheet->getColumnDimension('A')->setWidth(30);
	    $activeSheet->getColumnDimension('B')->setWidth(12);
	    $activeSheet->getColumnDimension('C')->setWidth(12);
	    $activeSheet->getColumnDimension('D')->setWidth(12);
	    $activeSheet->getColumnDimension('E')->setWidth(12);
	    $activeSheet->getColumnDimension('F')->setWidth(8);
	    $activeSheet->getColumnDimension('G')->setWidth(8);
	    $activeSheet->getColumnDimension('H')->setWidth(8);
	    $activeSheet->getColumnDimension('I')->setWidth(6);
	    $activeSheet->getColumnDimension('J')->setWidth(8);
	    $activeSheet->getColumnDimension('K')->setWidth(10);
	    $activeSheet->getColumnDimension('L')->setWidth(8);
	    $activeSheet->getColumnDimension('M')->setWidth(8);
	    $activeSheet->getColumnDimension('M')->setWidth(8);
	    $activeSheet->getColumnDimension('O')->setWidth(12);
	    
	    $activeSheet->getRowDimension('3')->setRowHeight(40);
	    
	    
	    $activeSheet->getStyle('A3:O3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    
	    $primerTercio = (int) count($data) / 3;
	    $segundoTercio = $primerTercio * 2;
	    
	    foreach( $data as $row )
	    {
	        if ( isset( $row['marca'] ) )
	        {
	            $activeSheet->setCellValue('A'.$i, $row['marca']);
	            $activeSheet->getStyle('A'.$i.':O'.$i)->applyFromArray($this->dataCellStyle);
	        }
	        else
	        {
	            $activeSheet->setCellValue('A'.$i, $row['fuente']);
	            $activeSheet->getStyle('A'.$i.':O'.$i)->applyFromArray($this->boldCellStyle);
	        }
	    
	        $activeSheet->setCellValue('B'.$i, $row['precio_con_iva']);
	        $activeSheet->setCellValue('C'.$i, $row['precio_sin_iva']);
	        $activeSheet->setCellValue('D'.$i, $row['costo_con_iva']);
	        $activeSheet->setCellValue('E'.$i, $row['costo_sin_iva']);
	        $activeSheet->setCellValue('F'.$i, $row['unidades']);
	        $activeSheet->setCellValue('G'.$i, $row['clientes']);
	        $activeSheet->setCellValue('H'.$i, $row['pedidos']);
	    
	        if ( $totalPrecioConIva > 0 )
	        {
	            $activeSheet->setCellValue('I'.$i, round( ($row['precio_con_iva'] / $totalPrecioConIva) * 100) . '%' );
	        }
	    
	    
	        if ( $row['pedidos'] > 0 )
	        {
	            $activeSheet->setCellValue('J'.$i, round($row['precio_con_iva']/$row['pedidos'], 2) );
	            $activeSheet->setCellValue('L'.$i, round($row['unidades']/$row['pedidos'], 2) );
	        }
	        else
	        {
	            $activeSheet->setCellValue('J'.$i, 0 );
	            $activeSheet->setCellValue('L'.$i, 0 );
	        }
	    
	        if ( $row['clientes'] > 0 )
	        {
	            $activeSheet->setCellValue('K'.$i, round($row['pedidos']/$row['clientes'], 2) );
	        }
	        else
	        {
	            $activeSheet->setCellValue('K'.$i, 0 );
	        }
	    
	        if ( $row['precio_sin_iva'] > 0 )
	        {
	            $activeSheet->setCellValue('M'.$i, round( (( $row['precio_sin_iva'] - $row['costo_sin_iva'] ) / $row['precio_sin_iva']) * 100) );
	        }
	        else
	        {
	            $activeSheet->setCellValue('M'.$i, 0 );
	        }
	    
	        if ( $row['costo_sin_iva'] > 0 )
	        {
	            $activeSheet->setCellValue('N'.$i, round( (( $row['precio_sin_iva'] / $row['costo_sin_iva'] ) - 1) * 100) );
	        }
	        else
	        {
	            $activeSheet->setCellValue('N'.$i, 0 );
	        }
	    
	    
	        $activeSheet->setCellValue('O'.$i, round( $row['precio_sin_iva'] - $row['costo_sin_iva'], 2) );
	    
	        $activeSheet->getStyle('B'.$i.':E'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        $activeSheet->getStyle('J'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        $activeSheet->getStyle('O'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	        if ( $i <= $primerTercio ) {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->greenCellStyle);
	        } else if ( $i <= $segundoTercio ) {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->yellowCellStyle);
	        } else {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->redCellStyle);
	        }
	    
	        $i++;
	    }
	}
	
		
	protected function reporteVentasXDia( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Ventas x Dia');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getVentasxDiaReporteMensual($desde, $hasta, $idEshop);
	    
	    $totalVentasConIva = $reporte['totalVentasConIva'];
	    $data = $reporte['data'];
	    
	    $activeSheet->setCellValue('A3', 'Fecha');
	    $activeSheet->setCellValue('B3', 'Venta Con IVA');
	    $activeSheet->setCellValue('C3', 'Descuentos');
	    $activeSheet->setCellValue('D3', 'Envio');
	    $activeSheet->setCellValue('E3', 'Total Facturado');
	    $activeSheet->setCellValue('F3', 'Unidades');
	    $activeSheet->setCellValue('G3', 'Pedidos');
	    $activeSheet->setCellValue('H3', 'Porc.');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(20);
	    $activeSheet->getColumnDimension('B')->setWidth(12);
	    $activeSheet->getColumnDimension('C')->setWidth(12);
	    $activeSheet->getColumnDimension('D')->setWidth(12);
	    $activeSheet->getColumnDimension('E')->setWidth(15);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	    $activeSheet->getColumnDimension('G')->setWidth(12);
	    $activeSheet->getColumnDimension('H')->setWidth(8);
	    
	    $activeSheet->getStyle('A3:H3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    $totales = array('venta_con_iva' => 0, 'descuentos' => 0, 'envio' => 0, 'total_facturado' => 0, 'unidades' => 0, 'pedidos' => 0);
	    
	    foreach( $data as $row )
	    {
	        $timestamp = strtotime($row['fecha']);
	    
	        $activeSheet->setCellValue('A'.$i, ucfirst( strftime('%A', $timestamp) ) . ' ' . date('d/m/Y', $timestamp));
	        $activeSheet->setCellValue('B'.$i, $row['venta_con_iva']);
	        $activeSheet->setCellValue('C'.$i, $row['descuentos']);
	        $activeSheet->setCellValue('D'.$i, $row['envio']);
	        $activeSheet->setCellValue('E'.$i, $row['total_facturado']);
	        $activeSheet->setCellValue('F'.$i, $row['unidades']);
	        $activeSheet->setCellValue('G'.$i, $row['pedidos']);
	    
	        $totales['venta_con_iva'] += $row['venta_con_iva'];
	        $totales['descuentos'] += $row['descuentos'];
	        $totales['envio'] += $row['envio'];
	        $totales['total_facturado'] += $row['total_facturado'];
	        $totales['unidades'] += $row['unidades'];
	        $totales['pedidos'] += $row['pedidos'];
	    
	        $porc = 0;
	        if ( $totalVentasConIva > 0 )
	        {
	            $porc = round( ($row['venta_con_iva'] / $totalVentasConIva) * 100, 2);
	            $activeSheet->setCellValue('H'.$i, $porc . '%' );
	        }
	    
	        $activeSheet->getStyle('B'.$i.':E'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        $activeSheet->getStyle('A'.$i.':H'.$i)->applyFromArray($this->dataCellStyle);
	    
	        if ( $porc <= 3 ) {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->redCellStyle);
	        } else if ( $porc <= 6 ) {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->yellowCellStyle);
	        } else {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->greenCellStyle);
	        }
	    
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('B'.$i, $totales['venta_con_iva']);
	    $activeSheet->setCellValue('C'.$i, $totales['descuentos']);
	    $activeSheet->setCellValue('D'.$i, $totales['envio']);
	    $activeSheet->setCellValue('E'.$i, $totales['total_facturado']);
	    $activeSheet->setCellValue('F'.$i, $totales['unidades']);
	    $activeSheet->setCellValue('G'.$i, $totales['pedidos']);
	    $activeSheet->setCellValue('H'.$i, '100%' );
	    $activeSheet->getStyle('A'.$i.':H'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('B'.$i.':E'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	
	protected function reporteVentasXProvincia( $desde, $hasta, $idEshop = null )
	{
	     
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex($this->sheetIndex);
	    $this->sheetIndex++;
	     
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Ventas x Provincia');
	     
	    $reporte = reporteCronologicoTable::getInstance()->getVentasxProvinciaReporteMensual($desde, $hasta, $idEshop);
	     
	    $totalVentasConIva = $reporte['totalVentasConIva'];
	    $data = $reporte['data'];
	     
	    $activeSheet->setCellValue('A3', 'Provincia');
	    $activeSheet->setCellValue('B3', 'Venta Con IVA');
	    $activeSheet->setCellValue('C3', 'Descuentos');
	    $activeSheet->setCellValue('D3', 'Envio');
	    $activeSheet->setCellValue('E3', 'Total Facturado');
	    $activeSheet->setCellValue('F3', 'Unidades');
	    $activeSheet->setCellValue('G3', 'Pedidos');
	    $activeSheet->setCellValue('H3', 'Porc.');
	     
	    $activeSheet->getColumnDimension('A')->setWidth(20);
	    $activeSheet->getColumnDimension('B')->setWidth(12);
	    $activeSheet->getColumnDimension('C')->setWidth(12);
	    $activeSheet->getColumnDimension('D')->setWidth(12);
	    $activeSheet->getColumnDimension('E')->setWidth(15);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	    $activeSheet->getColumnDimension('G')->setWidth(12);
	    $activeSheet->getColumnDimension('H')->setWidth(8);
	    
	    $activeSheet->getStyle('A3:H3')->applyFromArray($this->headerCellStyle);
	     
	    $i = 4;
	    $totales = array('venta_con_iva' => 0, 'descuentos' => 0, 'envio' => 0, 'total_facturado' => 0, 'unidades' => 0, 'pedidos' => 0);
	     
	    foreach( $data as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['provincia']);
	        $activeSheet->setCellValue('B'.$i, $row['venta_con_iva']);
	        $activeSheet->setCellValue('C'.$i, $row['descuentos']);
	        $activeSheet->setCellValue('D'.$i, $row['envio']);
	        $activeSheet->setCellValue('E'.$i, $row['total_facturado']);
	        $activeSheet->setCellValue('F'.$i, $row['unidades']);
	        $activeSheet->setCellValue('G'.$i, $row['pedidos']);
	         
	        $totales['venta_con_iva'] += $row['venta_con_iva'];
	        $totales['descuentos'] += $row['descuentos'];
	        $totales['envio'] += $row['envio'];
	        $totales['total_facturado'] += $row['total_facturado'];
	        $totales['unidades'] += $row['unidades'];
	        $totales['pedidos'] += $row['pedidos'];
	         
	        $porc = 0;
	        if ( $totalVentasConIva > 0 )
	        {
	            $porc = round( ($row['venta_con_iva'] / $totalVentasConIva) * 100, 2);
	            $activeSheet->setCellValue('H'.$i, $porc . '%' );
	        }
	         
	        $activeSheet->getStyle('B'.$i.':E'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        $activeSheet->getStyle('A'.$i.':H'.$i)->applyFromArray($this->dataCellStyle);
	         
	        if ( $porc <= 4 ) {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->redCellStyle);
	        } else if ( $porc <= 9 ) {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->yellowCellStyle);
	        } else {
	            $activeSheet->getStyle('A'.$i)->applyFromArray($this->greenCellStyle);
	        }
	         
	        $i++;
	    }
	     
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('B'.$i, $totales['venta_con_iva']);
	    $activeSheet->setCellValue('C'.$i, $totales['descuentos']);
	    $activeSheet->setCellValue('D'.$i, $totales['envio']);
	    $activeSheet->setCellValue('E'.$i, $totales['total_facturado']);
	    $activeSheet->setCellValue('F'.$i, $totales['unidades']);
	    $activeSheet->setCellValue('G'.$i, $totales['pedidos']);
	    $activeSheet->setCellValue('H'.$i, '100%' );
	    $activeSheet->getStyle('A'.$i.':H'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('B'.$i.':E'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	
	protected function reporteDescuentos( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Descuentos');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getDescuentosReporteMensual($desde, $hasta, $idEshop);
	    
	    $activeSheet->setCellValue('A3', 'Motivo de Descuento');
	    $activeSheet->setCellValue('B3', 'Código');
	    $activeSheet->setCellValue('C3', 'Unidades');
	    $activeSheet->setCellValue('D3', 'Monto');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(25);
	    $activeSheet->getColumnDimension('B')->setWidth(12);
	    $activeSheet->getColumnDimension('C')->setWidth(8);
	    $activeSheet->getColumnDimension('D')->setWidth(12);
	    
	    $activeSheet->getStyle('A3:D3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    $montoTotal = 0;
	    $unidadesTotal = 0;
	    foreach( $reporte as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['descuento_motivo']);
	        $activeSheet->setCellValue('B'.$i, $row['descuento_codigo']);
	        $activeSheet->setCellValue('C'.$i, $row['unidades']);
	        $activeSheet->setCellValue('D'.$i, $row['monto']);
	    
	        $activeSheet->getStyle('A'.$i.':D'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	        $unidadesTotal += $row['unidades'];
	        $montoTotal += $row['monto'];
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('C'.$i, $unidadesTotal);
	    $activeSheet->setCellValue('D'.$i, $montoTotal);
	    
	    $activeSheet->getStyle('A'.$i.':D'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	}
	
	protected function reporteDevolucionesYFaltantes( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Devoluciones y Faltantes');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getDevolucionesReporteMensual($desde, $hasta, $idEshop);
	    
	    $activeSheet->setCellValue('A3', 'Motivo de Descuento');
	    $activeSheet->setCellValue('B3', 'Submotivo');
	    $activeSheet->setCellValue('C3', 'Unidades');
	    $activeSheet->setCellValue('D3', 'Devolución en MP');
	    $activeSheet->setCellValue('E3', 'Unid. en MP');

	    $activeSheet->getColumnDimension('A')->setWidth(20);
	    $activeSheet->getColumnDimension('B')->setWidth(25);
	    $activeSheet->getColumnDimension('C')->setWidth(9);
	    $activeSheet->getColumnDimension('D')->setWidth(15);
	    $activeSheet->getColumnDimension('E')->setWidth(14);	    
	    
	    $activeSheet->getStyle('A3:E3')->applyFromArray($this->headerCellStyle);
	    
	    if ( !$idEshop ) {
	        $activeSheet->setCellValue('F3', 'Credito en Cuenta');
	        $activeSheet->setCellValue('G3', 'Unid. en Cuenta');

	        $activeSheet->getColumnDimension('F')->setWidth(15);
	        $activeSheet->getColumnDimension('G')->setWidth(14);
	        
	        $activeSheet->getStyle('F3:G3')->applyFromArray($this->headerCellStyle);
	    }
	    
	    $i = 4;
	    $unidadesTotal = 0;
	    $montoTotalMP = 0;
	    $unidadesMP = 0;
	    $montoTotalCuenta = 0;
	    $unidadesCuenta = 0;
	    foreach( $reporte as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['bonificacion_motivo']);
	        $activeSheet->setCellValue('B'.$i, $row['bonificacion_submotivo']);
	        $activeSheet->setCellValue('C'.$i, $row['unidades']);
	        $activeSheet->setCellValue('D'.$i, $row['devolucion_mp']);
	        $activeSheet->setCellValue('E'.$i, $row['unidades_mp']);
	        
	        if ( !$idEshop ) {
    	        $activeSheet->setCellValue('F'.$i, $row['devolucion_cuenta']);
    	        $activeSheet->setCellValue('G'.$i, $row['unidades_cuenta']);
	        }
	    
	        $activeSheet->getStyle('A'.$i.':E'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        
	        if ( !$idEshop ) {
	            $activeSheet->getStyle('F'.$i.':G'.$i)->applyFromArray($this->dataCellStyle);
	            $activeSheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        }
	    
	        $unidadesTotal += $row['unidades'];
	        $montoTotalMP += $row['devolucion_mp'];
	        $unidadesMP += $row['unidades_mp'];
	        $montoTotalCuenta += $row['devolucion_cuenta'];
	        $unidadesCuenta += $row['unidades_cuenta'];
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('C'.$i, $unidadesTotal);
	    $activeSheet->setCellValue('D'.$i, $montoTotalMP);
	    $activeSheet->setCellValue('E'.$i, $unidadesMP);

	    $activeSheet->getStyle('A'.$i.':E'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	    if ( !$idEshop ) {
    	    $activeSheet->setCellValue('F'.$i, $montoTotalCuenta);
    	    $activeSheet->setCellValue('G'.$i, $unidadesCuenta);
    	    
    	    $activeSheet->getStyle('F'.$i.':G'.$i)->applyFromArray($this->boldCellStyle);
    	    $activeSheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    }
	   
	}
	
	protected function reporteFormaPago( $desde, $hasta )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Forma de Pago');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getFormaPagoReporteMensual($desde, $hasta);
	    
	    $totalVentas = $reporte['totalVentas'];
	    $data = $reporte['data'];
	    
	    $activeSheet->setCellValue('A3', 'Forma De Pago');
	    $activeSheet->setCellValue('B3', 'Ventas');
	    $activeSheet->setCellValue('C3', 'Pedidos');
	    $activeSheet->setCellValue('D3', 'Porcentaje');
	    
	    
	    $activeSheet->getColumnDimension('A')->setWidth(15);
	    $activeSheet->getColumnDimension('B')->setWidth(25);
	    $activeSheet->getColumnDimension('C')->setWidth(14);
	    $activeSheet->getColumnDimension('D')->setWidth(14);
	    
	    $activeSheet->getStyle('A3:D3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    $ventasTotal = 0;
	    $pedidosTotal = 0;
	    foreach( $data as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['forma_pago']);
	        $activeSheet->setCellValue('B'.$i, $row['ventas']);
	        $activeSheet->setCellValue('C'.$i, $row['pedidos']);
	        $activeSheet->setCellValue('D'.$i, round( ($row['ventas'] / $totalVentas) * 100, 2) . '%' );
	    
	        $activeSheet->getStyle('A'.$i.':D'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('B'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	        $ventasTotal += $row['ventas'];
	        $pedidosTotal += $row['pedidos'];
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('B'.$i, $ventasTotal);
	    $activeSheet->setCellValue('C'.$i, $pedidosTotal);
	    $activeSheet->setCellValue('D'.$i, '100%');
	    
	    $activeSheet->getStyle('A'.$i.':D'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('B'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	protected function reporteEnvio( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Envios');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getEnvioReporteMensual($desde, $hasta, $idEshop);
	    
	    $activeSheet->setCellValue('A3', 'Dinero ingresado por Envio con IVA');
	    $activeSheet->setCellValue('A4', 'Costo por Envio con IVA');
	    $activeSheet->setCellValue('A5', 'Pedidos');
	    $activeSheet->setCellValue('A6', 'Pedidos a sucursal');
	    $activeSheet->setCellValue('A7', 'Pedidos a Domicilio');
	    
	    $activeSheet->setCellValue('A9', 'Envío Gratis - Costo');
	    $activeSheet->setCellValue('A10', 'Envío Gratis - Pedidos');
	    
	    $activeSheet->setCellValue('A12', 'Logística Inversa - Costo');
	    $activeSheet->setCellValue('A13', 'Logística Inversa - Devoluciones');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(40);
	    $activeSheet->getStyle('A3:A7')->applyFromArray($this->headerCellStyle);
	    $activeSheet->getStyle('A9:A10')->applyFromArray($this->headerCellStyle);
	    $activeSheet->getStyle('A12:A13')->applyFromArray($this->headerCellStyle);
	    
	    $activeSheet->setCellValue('B3', $reporte['envio']);
	    $activeSheet->setCellValue('B4', $reporte['costo_envio']);
	    $activeSheet->setCellValue('B5', $reporte['pedidos']);
	    $activeSheet->setCellValue('B6', $reporte['pedidos_domicilio']);
	    $activeSheet->setCellValue('B7', $reporte['pedidos_sucursal']);
	    
	    $activeSheet->setCellValue('B9', $reporte['costo_envio_gratis']);
	    $activeSheet->setCellValue('B10', $reporte['pedidos_envio_gratis']);
	    
	    $activeSheet->setCellValue('B12', $reporte['logistica_inversa_costo']);
	    $activeSheet->setCellValue('B13', $reporte['logistica_inversa_devoluciones']);
	    
	    
	    $activeSheet->getColumnDimension('B')->setWidth(20);
	    
	    $activeSheet->getStyle('B3:B4')->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    $activeSheet->getStyle('B3:B7')->applyFromArray($this->dataCellStyle);
	    $activeSheet->getStyle('B9:B10')->applyFromArray($this->dataCellStyle);
	    $activeSheet->getStyle('B9')->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    $activeSheet->getStyle('B12:B13')->applyFromArray($this->dataCellStyle);
	    $activeSheet->getStyle('B12')->getNumberFormat()->setFormatCode($this->formatCurrencyCell);	    
	}
	
	protected function reporteDetalleFallados( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Detalle de Fallados');
	    
	    
	    $reporte = falladoTable::getInstance()->getDetalleFalladosReporteMensual($desde, $hasta, $idEshop);
	    
	    
	    $activeSheet->setCellValue('A3', 'Marca');
	    $activeSheet->setCellValue('B3', 'Codigo');
	    $activeSheet->setCellValue('C3', 'Producto');
	    $activeSheet->setCellValue('D3', 'Unidades');
	    $activeSheet->setCellValue('E3', 'Precio Unitario sin IVA');
	    $activeSheet->setCellValue('F3', 'Costo con IVA');
	    $activeSheet->setCellValue('G3', 'Costo sin IVA');
	    $activeSheet->setCellValue('H3', 'Costo Prom. con IVA');
	    $activeSheet->setCellValue('I3', 'Costo Prom. sin IVA');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(20);
	    $activeSheet->getColumnDimension('B')->setWidth(25);
	    $activeSheet->getColumnDimension('C')->setWidth(25);
	    $activeSheet->getColumnDimension('D')->setWidth(10);
	    $activeSheet->getColumnDimension('E')->setWidth(12);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	    $activeSheet->getColumnDimension('G')->setWidth(12);
	    $activeSheet->getColumnDimension('H')->setWidth(12);
	    $activeSheet->getColumnDimension('I')->setWidth(12);
	    
	    $activeSheet->getRowDimension('3')->setRowHeight(40);
	    $activeSheet->getStyle('A3:I3')->getAlignment()->setWrapText(true);
	    $activeSheet->getStyle('A3:I3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    $unidadesTotal = 0;
	    $costoConIvaTotal = 0;
	    $costoSinIvaTotal = 0;
	    foreach( $reporte as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['marca']);
	        $activeSheet->setCellValue('B'.$i, $row['codigo']);
	        $activeSheet->setCellValue('C'.$i, $row['producto']);
	        $activeSheet->setCellValue('D'.$i, $row['unidades']);
	        $activeSheet->setCellValue('E'.$i, $row['precio_unitario_sin_iva']);
	        $activeSheet->setCellValue('F'.$i, $row['costo_con_iva']);
	        $activeSheet->setCellValue('G'.$i, $row['costo_sin_iva']);
	        $activeSheet->setCellValue('H'.$i, ( $row['unidades'] ) ? $row['costo_con_iva'] / $row['unidades'] : 0 );
	        $activeSheet->setCellValue('I'.$i, ( $row['unidades'] ) ? $row['costo_sin_iva'] / $row['unidades'] : 0 );
	    
	        $activeSheet->getStyle('A'.$i.':I'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('E'.$i.':I'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	        $unidadesTotal += $row['unidades'];
	        $costoConIvaTotal += $row['costo_con_iva'];
	        $costoSinIvaTotal += $row['costo_sin_iva'];
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('D'.$i, $unidadesTotal);
	    $activeSheet->setCellValue('E'.$i, $costoConIvaTotal);
	    $activeSheet->setCellValue('F'.$i, $costoSinIvaTotal);
	    
	    $activeSheet->getStyle('A'.$i.':I'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('F'.$i.':I'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	protected function reporteDetalleDevoluciones( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Detalle de Devoluciones');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getDetalleDevolucionesReporteMensual($desde, $hasta, $idEshop);
	    
	    $activeSheet->setCellValue('A3', 'Motivo');
	    $activeSheet->setCellValue('B3', 'Marca');
	    $activeSheet->setCellValue('C3', 'Codigo');
	    $activeSheet->setCellValue('D3', 'Producto');
	    $activeSheet->setCellValue('E3', 'Unidades');
	    $activeSheet->setCellValue('F3', 'Precio Unitario sin IVA');
	    $activeSheet->setCellValue('G3', 'Costo con IVA');
	    $activeSheet->setCellValue('H3', 'Costo sin IVA');
	    $activeSheet->setCellValue('I3', 'Costo Prom. con IVA');
	    $activeSheet->setCellValue('J3', 'Costo Prom. sin IVA');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(30);
	    $activeSheet->getColumnDimension('B')->setWidth(20);
	    $activeSheet->getColumnDimension('C')->setWidth(25);
	    $activeSheet->getColumnDimension('D')->setWidth(25);
	    $activeSheet->getColumnDimension('E')->setWidth(10);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	    $activeSheet->getColumnDimension('G')->setWidth(12);
	    $activeSheet->getColumnDimension('H')->setWidth(12);
	    $activeSheet->getColumnDimension('I')->setWidth(12);
	    $activeSheet->getColumnDimension('J')->setWidth(12);
	    
	    $activeSheet->getRowDimension('3')->setRowHeight(40);
	    $activeSheet->getStyle('A3:J3')->getAlignment()->setWrapText(true);
	    $activeSheet->getStyle('A3:J3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    $unidadesTotal = 0;
	    $costoConIvaTotal = 0;
	    $costoSinIvaTotal = 0;
	    foreach( $reporte as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['bonificacion_submotivo']);
	        $activeSheet->setCellValue('B'.$i, $row['marca']);
	        $activeSheet->setCellValue('C'.$i, $row['codigo']);
	        $activeSheet->setCellValue('D'.$i, $row['producto']);
	        $activeSheet->setCellValue('E'.$i, $row['unidades']);
	        $activeSheet->setCellValue('F'.$i, $row['precio_unitario_sin_iva']);
	        $activeSheet->setCellValue('G'.$i, $row['costo_con_iva']);
	        $activeSheet->setCellValue('H'.$i, $row['costo_sin_iva']);
	        $activeSheet->setCellValue('I'.$i, ( $row['unidades'] ) ? $row['costo_con_iva'] / $row['unidades'] : 0 );
	        $activeSheet->setCellValue('J'.$i, ( $row['unidades'] ) ? $row['costo_sin_iva'] / $row['unidades'] : 0 );
	    
	        $activeSheet->getStyle('A'.$i.':J'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('F'.$i.':J'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	        $unidadesTotal += $row['unidades'];
	        $costoConIvaTotal += $row['costo_con_iva'];
	        $costoSinIvaTotal += $row['costo_sin_iva'];
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('E'.$i, $unidadesTotal);
	    $activeSheet->setCellValue('G'.$i, $costoConIvaTotal);
	    $activeSheet->setCellValue('H'.$i, $costoSinIvaTotal);
	    
	    $activeSheet->getStyle('A'.$i.':J'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('G'.$i.':J'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	protected function reporteDetalleFaltantes( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('Detalle de Faltantes');
	    
	    $reporte = reporteCronologicoTable::getInstance()->getDetalleFaltantesReporteMensual($desde, $hasta, $idEshop);
	    
	    $activeSheet->setCellValue('A3', 'Marca');
	    $activeSheet->setCellValue('B3', 'Codigo');
	    $activeSheet->setCellValue('C3', 'Producto');
	    $activeSheet->setCellValue('D3', 'Unidades');
	    $activeSheet->setCellValue('E3', 'Precio Unitario sin IVA');
	    $activeSheet->setCellValue('F3', 'Costo con IVA');
	    $activeSheet->setCellValue('G3', 'Costo sin IVA');
	    $activeSheet->setCellValue('H3', 'Costo Prom. con IVA');
	    $activeSheet->setCellValue('I3', 'Costo Prom. sin IVA');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(20);
	    $activeSheet->getColumnDimension('B')->setWidth(25);
	    $activeSheet->getColumnDimension('C')->setWidth(25);
	    $activeSheet->getColumnDimension('D')->setWidth(10);
	    $activeSheet->getColumnDimension('E')->setWidth(12);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	    $activeSheet->getColumnDimension('G')->setWidth(12);
	    $activeSheet->getColumnDimension('H')->setWidth(12);
	    $activeSheet->getColumnDimension('I')->setWidth(12);
	    
	    $activeSheet->getRowDimension('3')->setRowHeight(40);
	    $activeSheet->getStyle('A3:I3')->getAlignment()->setWrapText(true);
	    $activeSheet->getStyle('A3:I3')->applyFromArray($this->headerCellStyle);
	    
	    $i = 4;
	    $unidadesTotal = 0;
	    $costoConIvaTotal = 0;
	    $costoSinIvaTotal = 0;
	    foreach( $reporte as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, $row['marca']);
	        $activeSheet->setCellValue('B'.$i, $row['codigo']);
	        $activeSheet->setCellValue('C'.$i, $row['producto']);
	        $activeSheet->setCellValue('D'.$i, $row['unidades']);
	        $activeSheet->setCellValue('E'.$i, $row['precio_unitario_sin_iva']);
	        $activeSheet->setCellValue('F'.$i, $row['costo_con_iva']);
	        $activeSheet->setCellValue('G'.$i, $row['costo_sin_iva']);
	        $activeSheet->setCellValue('H'.$i, ( $row['unidades'] ) ? $row['costo_con_iva'] / $row['unidades'] : 0 );
	        $activeSheet->setCellValue('I'.$i, ( $row['unidades'] ) ? $row['costo_sin_iva'] / $row['unidades'] : 0 );
	    
	        $activeSheet->getStyle('A'.$i.':I'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('E'.$i.':I'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	    
	        $unidadesTotal += $row['unidades'];
	        $costoConIvaTotal += $row['costo_con_iva'];
	        $costoSinIvaTotal += $row['costo_sin_iva'];
	    
	        $i++;
	    }
	    
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('D'.$i, $unidadesTotal);
	    $activeSheet->setCellValue('E'.$i, $costoConIvaTotal);
	    $activeSheet->setCellValue('F'.$i, $costoSinIvaTotal);
	    
	    $activeSheet->getStyle('A'.$i.':I'.$i)->applyFromArray($this->boldCellStyle);
	    $activeSheet->getStyle('F'.$i.':I'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	protected function reporteMarketing( $desde, $hasta, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	    
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    $activeSheet->setTitle('MKT');
	    	    
	    $activeSheet->getRowDimension('3')->setRowHeight(15);
	    $activeSheet->getRowDimension('4')->setRowHeight(15);
	    $activeSheet->getRowDimension('5')->setRowHeight(15);
	    $activeSheet->getRowDimension('6')->setRowHeight(15);
	    
	    $activeSheet->setCellValue('A3', 'Usuarios suscriptos (Newsletter)');
	    $activeSheet->setCellValue('A4', 'Usuarios Registrados');
	    $activeSheet->setCellValue('A5', 'Usuarios nuevos que compraron');
	    $activeSheet->setCellValue('A6', 'Usuarios que repitieron la compra');
	    
	    $activeSheet->getColumnDimension('A')->setWidth(30);
	    $activeSheet->getColumnDimension('B')->setWidth(10);
	    
	    $activeSheet->getStyle('A3:A6')->applyFromArray($this->headerCellStyle);
	    
	    $suscriptos = newsletterTable::getInstance()->getCount($desde, $hasta, $idEshop);
	    $usuarios = usuarioTable::getInstance()->getCount($desde, $hasta, $idEshop);
	    
	    $activeSheet->setCellValue('B3', $suscriptos);
	    $activeSheet->setCellValue('B4', $usuarios['registrados']);
	    $activeSheet->setCellValue('B5', $usuarios['compraron']);
	    $activeSheet->setCellValue('B6', $usuarios['repitieron']);
	}
	
	protected function reporteProductosVendidos( $desde, $hasta, $orden, $idEshop = null )
	{
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	
	    $activeSheet = $this->phpExcel->getActiveSheet();
	    
	    if ( $orden == 'DESC' ) {
	        $activeSheet->setTitle('Más Vendidos');
	    } else {
	        $activeSheet->setTitle('Menos Vendidos');
	    }
	
	    $reporte = reporteCronologicoTable::getInstance()->getProductosVendidosReporteMensual($desde, $hasta, $orden, $idEshop);
	
	    $activeSheet->setCellValue('A3', 'Código');
	    $activeSheet->setCellValue('B3', 'Producto');
	    $activeSheet->setCellValue('C3', 'Marca');
	    $activeSheet->setCellValue('D3', 'Unidades');
	    $activeSheet->setCellValue('E3', 'Precio con IVA');
	    $activeSheet->setCellValue('F3', 'Precio sin IVA');
	
	    $activeSheet->getColumnDimension('A')->setWidth(16);
	    $activeSheet->getColumnDimension('B')->setWidth(35);
	    $activeSheet->getColumnDimension('C')->setWidth(15);
	    $activeSheet->getColumnDimension('D')->setWidth(8);
	    $activeSheet->getColumnDimension('E')->setWidth(12);
	    $activeSheet->getColumnDimension('F')->setWidth(12);
	
	    $activeSheet->getStyle('A3:F3')->applyFromArray($this->headerCellStyle);
	
	    $i = 4;
	    $unidadesTotal = 0;
	    $precioConIva = 0;
	    $precioSinIva = 0;
	    foreach( $reporte as $row )
	    {
	        $activeSheet->setCellValue('A'.$i, trim( $row['codigo_producto'] ) );
	        $activeSheet->setCellValue('B'.$i, trim( $row['producto'] ) );
	        $activeSheet->setCellValue('C'.$i, $row['marca']);
	        $activeSheet->setCellValue('D'.$i, $row['unidades']);
	        $activeSheet->setCellValue('E'.$i, $row['precio_con_iva']);
	        $activeSheet->setCellValue('F'.$i, $row['precio_sin_iva']);
	
	        $activeSheet->getStyle('A'.$i.':F'.$i)->applyFromArray($this->dataCellStyle);
	        $activeSheet->getStyle('E'.$i.':F'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	
	        $unidadesTotal += $row['unidades'];
	        $precioConIva += $row['precio_con_iva'];
	        $precioSinIva += $row['precio_sin_iva'];
	
	        $i++;
	    }
	
	    $activeSheet->setCellValue('A'.$i, 'Total');
	    $activeSheet->setCellValue('D'.$i, $unidadesTotal);
	    $activeSheet->setCellValue('E'.$i, $precioConIva);
	    $activeSheet->setCellValue('F'.$i, $precioSinIva);
	
        $activeSheet->getStyle('A'.$i.':F'.$i)->applyFromArray($this->boldCellStyle);
        $activeSheet->getStyle('E'.$i.':F'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	}
	
	protected function reporteMasVendidos( $desde, $hasta, $idEshop = null )
	{
	    $this->reporteProductosVendidos( $desde, $hasta, 'DESC', $idEshop );
	}

	protected function reporteMenosVendidos( $desde, $hasta, $idEshop = null )
	{
	    $this->reporteProductosVendidos( $desde, $hasta, 'ASC', $idEshop );
	}
	
	protected function reporteDocumentosNoFiscales( $desde, $hasta, $idEshop = null )
	{
	    $facturaCellStyle = array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('argb' => '000000')
	            )
	        ),
	        'font' => array(
	            'color' => array('rgb'=>'000000'), 'size' => '10',
	        ),
	    );
	    
	    $nCreditoCellStyle = array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN,
	                'color' => array('argb' => '000000')
	            )
	        ),
	        'font' => array(
	            'color' => array('rgb'=>'FF0000'), 'size' => '10',
	        ),
	    );
	    
	    $this->phpExcel->createSheet(NULL, $this->sheetIndex);
	    $this->phpExcel->setActiveSheetIndex( $this->sheetIndex );
	    $this->sheetIndex++;
	     
	    $activeSheet = $this->phpExcel->getActiveSheet();
	
	    $activeSheet->setTitle('Documentos No Fiscales');

	    $data = reciboEshopTable::getInstance()->listRecibos($idEshop, $desde, $hasta);
	     
	    $activeSheet->setCellValue('A3', 'Fecha');
	    $activeSheet->setCellValue('B3', 'ID Pedido');
	    $activeSheet->setCellValue('C3', 'Fecha de Pago');	    
	    $activeSheet->setCellValue('D3', 'Cliente');
	    $activeSheet->setCellValue('E3', 'Jurisdicción');
	    $activeSheet->setCellValue('F3', 'Neto Gravado');
	    $activeSheet->setCellValue('G3', 'IVA');
	    $activeSheet->setCellValue('H3', 'Total');
	    $activeSheet->setCellValue('I3', 'Costo Mercaderia');
	    $activeSheet->setCellValue('J3', 'Costo de Envio Ingresado por el cliente');	    
	    $activeSheet->setCellValue('K3', 'Forma de Pago');
	     
	    $activeSheet->getColumnDimension('A')->setWidth(14);
	    $activeSheet->getColumnDimension('B')->setWidth(10);
	    $activeSheet->getColumnDimension('C')->setWidth(18);
	    $activeSheet->getColumnDimension('D')->setWidth(25);
	    $activeSheet->getColumnDimension('E')->setWidth(20);
	    $activeSheet->getColumnDimension('F')->setWidth(10);
	    $activeSheet->getColumnDimension('G')->setWidth(10);
	    $activeSheet->getColumnDimension('H')->setWidth(10);
	    $activeSheet->getColumnDimension('I')->setWidth(15);
	    $activeSheet->getColumnDimension('J')->setWidth(35);
	    $activeSheet->getColumnDimension('K')->setWidth(15);
	     
	    $activeSheet->getStyle('A3:K3')->applyFromArray($this->headerCellStyle);
	     
	    $i = 4;
	    foreach( $data as $row )
	    {
	        $importe = $row['importe'];
	        
	        if ( $row['tipo'] == 'FACTURA' )
	        {
	            $activeSheet->getStyle('A' . $i . ':K' . $i . '')->applyFromArray($facturaCellStyle);
	        }
	        else
	        {
	            $importe = $importe * -1;
	            $activeSheet->getStyle('A' . $i . ':K' . $i . '')->applyFromArray($nCreditoCellStyle);
	        }
	        
	        $baseImponible = $importe / 1.21;
	        $baseImponibleRedondeado = round($baseImponible, 2, PHP_ROUND_HALF_EVEN);
	        
	        $importeIva = $baseImponible * 0.21;
	        $importeIvaRedondeado = round($importeIva, 2, PHP_ROUND_HALF_EVEN);
	        
	        $activeSheet->setCellValue('A'.$i, trim( $row['fecha'] ) );
	        $activeSheet->setCellValue('B'.$i, trim( $row['id_pedido'] ) );
	        $activeSheet->setCellValue('C'.$i, $row['fecha_pago']);
	        $activeSheet->setCellValue('D' . $i, $row['nombre'] . ' ' . $row['apellido'] );
	        $activeSheet->setCellValue('E' . $i, $row['provincia'] );
	        $activeSheet->setCellValue('F' . $i, $baseImponibleRedondeado );
	        $activeSheet->setCellValue('G' . $i, $importeIvaRedondeado );
	        $activeSheet->setCellValue('H' . $i, $baseImponibleRedondeado +  $importeIvaRedondeado );
	        $activeSheet->setCellValue('I' . $i, $row['costo_mercaderia'] );
	        $activeSheet->setCellValue('J' . $i, $row['envio'] );
	        $activeSheet->setCellValue('K' . $i, $row['forma_pago']);
	         
	        $activeSheet->getStyle('F'.$i.':K'.$i)->getNumberFormat()->setFormatCode($this->formatCurrencyCell);
	        $i++;	         
	    }
	}
	
		
}