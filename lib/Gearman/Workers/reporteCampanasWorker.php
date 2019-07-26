<?php

class Net_Gearman_Job_ReporteCampanasWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {                      
        $params = $arg['params'];        
        $downloadEnabled = ($params['action'] == 'Descargar');
        $idsCampana = $params['campanas'];

        $data = array();
        if ( count( $idsCampana ) )
        {
            $result = reporteCampanaTable::getInstance()->getReporte( $idsCampana );

            $finalizadas = array();            
            foreach( $result as $row )
            {
                $data[ $row->getIdCampana() ] = $row;
                $finalizadas[] = $row->getIdCampana();
            }
        }
        
        $noFinalizadas = array_diff($idsCampana, $finalizadas);
        
        foreach( $noFinalizadas as $idCampana )
        {
            $result = campanaTable::getInstance()->getReporteCampana( $idCampana );
                        
            $reporteCampana = reporteCampanaTable::getInstance()->fillObject( $idCampana, $result );
                        
            $data[ $idCampana ] = $reporteCampana;
        }        
        
        if (!$downloadEnabled) return array('type' => 'VER_ONLINE', 'data' => serialize($data));
        
        // Armado del Excel
        $phpExcel = new PHPExcel();
    
        $phpExcel->getProperties()->setCreator("DeluxeBuys");
        $activeSheet = $phpExcel->setActiveSheetIndex(0);
    
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
    
        $activeSheet->setCellValue('A1', "Campaña");
        $activeSheet->getColumnDimension('A')->setWidth(40);
        
        $activeSheet->setCellValue('B1', "Rubro");
        $activeSheet->getColumnDimension('B')->setWidth(25);
    
        $activeSheet->setCellValue('C1', "Fecha");
        $activeSheet->getColumnDimension('C')->setWidth(40);
    
        $activeSheet->setCellValue('D1', "Ped.");
        $activeSheet->getColumnDimension('D')->setWidth(12);
    
        $activeSheet->setCellValue('E1', "U. Vend.");
        $activeSheet->getColumnDimension('E')->setWidth(12);
    
        $activeSheet->setCellValue('F1', "U. Prom.\nx Pedido");
        $activeSheet->getColumnDimension('F')->setWidth(12);
    
        $activeSheet->setCellValue('G1', "Total\nFact.");
        $activeSheet->getColumnDimension('G')->setWidth(12);
    
        $activeSheet->setCellValue('H1', "PDB");
        $activeSheet->getColumnDimension('H')->setWidth(12);
    
        $activeSheet->setCellValue('I1', "Costo\nTotal");
        $activeSheet->getColumnDimension('I')->setWidth(12);
    
        $activeSheet->setCellValue('J1', "Margen\nBruto");
        $activeSheet->getColumnDimension('J')->setWidth(12);
    
        $activeSheet->setCellValue('K1', "Margen\nProm.");
        $activeSheet->getColumnDimension('K')->setWidth(12);
    
        $activeSheet->setCellValue('L1', "Total\nstock");
        $activeSheet->getColumnDimension('L')->setWidth(12);
    
        $activeSheet->setCellValue('M1', "Ejecución\nde stock");
        $activeSheet->getColumnDimension('M')->setWidth(12);
    
        $activeSheet->setCellValue('N1', "Top 5 productos");
        $activeSheet->getColumnDimension('N')->setWidth(40);
    
        $activeSheet->setCellValue('O1', "Ticket\nProm.");
        $activeSheet->getColumnDimension('O')->setWidth(12);
    
        $activeSheet->setCellValue('P1', "Obj. de\nFact.");
        $activeSheet->getColumnDimension('P')->setWidth(12);
    
        $activeSheet->setCellValue('Q1', "Resultado");
        $activeSheet->getColumnDimension('Q')->setWidth(12);
    
        $activeSheet->setCellValue('R1', "Condicion\nFiscal");
        $activeSheet->getColumnDimension('R')->setWidth(12);
    
        $activeSheet->setCellValue('S1', "Ped. H");
        $activeSheet->getColumnDimension('S')->setWidth(12);
    
        $activeSheet->setCellValue('T1', "Ped. M");
        $activeSheet->getColumnDimension('T')->setWidth(12);
    
    
        $activeSheet->getStyle('A1:T1')->applyFromArray($headerCellStyle);
    
        $i = 2;
        foreach ($data as $reporteCampana)
        {            
            $campana = $reporteCampana->getCampana();
                                                
            $activeSheet->setCellValue('A' . $i, $campana->getDenominacion() );
            $activeSheet->setCellValue('B' . $i, $reporteCampana->getRubro() );
            $activeSheet->setCellValue('C' . $i, date('d/m/Y', strtotime( $campana->getFechaInicio() ) ) . ' al ' . date('d/m/Y', strtotime( $campana->getFechaFin() ) ) );
            $activeSheet->setCellValue('D' . $i, $reporteCampana->getCantidadPedidos() );
            $activeSheet->setCellValue('E' . $i, $reporteCampana->getUnidadesVendidas() );
            $activeSheet->setCellValue('F' . $i, $reporteCampana->getUnidadesPromedioPedido() );
            $activeSheet->setCellValue('G' . $i, '$' . $reporteCampana->getTotalFacturado() );
            $activeSheet->setCellValue('H' . $i, '$' . $reporteCampana->getPdb() );
            $activeSheet->setCellValue('I' . $i, '$' . $reporteCampana->getCostoTotal() );
            $activeSheet->setCellValue('J' . $i, '$' . $reporteCampana->getMargenBruto() );
            $activeSheet->setCellValue('K' . $i, $reporteCampana->getMargenPromedio() );
            $activeSheet->setCellValue('L' . $i, $reporteCampana->getTotalStock() );
            
                        
            $activeSheet->setCellValue('M' . $i, $reporteCampana->getEjecucionDeStock() );
            $activeSheet->setCellValue('N' . $i, $reporteCampana->getTopProductos() );
    
            $activeSheet->setCellValue('O' . $i, '$' . $reporteCampana->getTicketPromedio() );
            $activeSheet->setCellValue('P' . $i, $reporteCampana->getObjetivoFacturacion() );
            $activeSheet->setCellValue('Q' . $i, $reporteCampana->getObjetivoResultado() );
            $activeSheet->setCellValue('R' . $i, $reporteCampana->getCondicionFiscal() );
            $activeSheet->setCellValue('S' . $i, $reporteCampana->getCantidadPedidoHombre() );
            $activeSheet->setCellValue('T' . $i, $reporteCampana->getCantidadPedidoMujer() );
    
            $activeSheet->getStyle("A$i:T$i")->applyFromArray($dataCellStyle);
            $i++;
        }
    
        $tempFile = sfConfig::get('sf_temp_dir') . '/reporte_campanas_' . time();
        
        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save($tempFile);

        return array('type' => 'DESCARGAR', 'tempFile' => $tempFile);
    }
}