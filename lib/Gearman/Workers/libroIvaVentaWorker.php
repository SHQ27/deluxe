<?php

class Net_Gearman_Job_LibroIvaVentaWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        $idUsuario = $arg['idUsuario'];
        $periodo = $arg['periodo'];
        
        $desde = $periodo;
        
        $time = strtotime($periodo);
        $hasta = date('Y-m-d', mktime(0, 0 , 0, date('m',$time) + 1, 0, date('Y',$time) ) );
        
        $phpExcel = new PHPExcel();
        $phpExcel->getProperties()->setCreator("DeluxeBuys");
        $activeSheet = $phpExcel->setActiveSheetIndex(0);
        
        $activeSheet->setCellValue('A1', 'Deluxebuys - Libro IVA Ventas');
        $activeSheet->mergeCells('A1:D1');
        $activeSheet->mergeCells('A2:D2');
        
        $activeSheet->setCellValue('A3', 'Desde: ' . $desde);
        $activeSheet->mergeCells('A3:D3');
        
        $activeSheet->setCellValue('A4', 'Hasta: ' . $hasta);
        $activeSheet->mergeCells('A4:D4');
        
        $activeSheet->setCellValue('A7', 'Fecha');
        $activeSheet->setCellValue('B7', 'ID Pedido');
        $activeSheet->setCellValue('C7', 'Fecha de Pago');
        $activeSheet->setCellValue('D7', 'Cod. Comp.');
        $activeSheet->setCellValue('E7', 'Punto de Vta.');
        $activeSheet->setCellValue('F7', 'Comprobante');
        $activeSheet->setCellValue('G7', 'Cod. Doc.');
        $activeSheet->setCellValue('H7', 'Documento');
        $activeSheet->setCellValue('I7', 'Cliente');
        $activeSheet->setCellValue('J7', 'Jurisdicción');
        $activeSheet->setCellValue('K7', 'Neto Gravado');
        $activeSheet->setCellValue('L7', 'IVA');
        $activeSheet->setCellValue('M7', 'Total');
        $activeSheet->setCellValue('N7', 'Costo Mercaderia');
        $activeSheet->setCellValue('O7', 'Costo de Envio Ingresado por el cliente');
        $activeSheet->setCellValue('P7', 'Forma de Pago');
                

        $headerCellStyle = array(
                'font' => array('bold' => true, 'size' => '10'),
                'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                        'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('argb' => '000000'))));
        
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
        
        $formatCurrencyCell = '#,##0.00';
        
        $activeSheet->getStyle('A7:P7')->applyFromArray($headerCellStyle);

        $configWS = sfConfig::get('app_afip_ws');
        $puntoVenta = $configWS['punto_de_venta'];
        
        $documentos = facturaTable::getInstance()->libroIvaVenta($desde, $hasta);
        
        $i = 8;
        foreach ($documentos as $row)
        {
            $importe = $row['importe'];
        
            if ( $row['tipo'] == 'FACTURA' )
            {
                $activeSheet->getStyle('A' . $i . ':P' . $i . '')->applyFromArray($facturaCellStyle);
                $codigoComprobante = Afip_WSFE::FACTURA_B;
            }
            else
            {
                $importe = $importe * -1;
                $activeSheet->getStyle('A' . $i . ':P' . $i . '')->applyFromArray($nCreditoCellStyle);
                $codigoComprobante = Afip_WSFE::NOTA_DE_CREDITO_B;
            }
                    
            if ( $row['documento'] ) {
                $documento = $row['documento'];
                $codigoDocumento = constant( 'Afip_WSFE::TIPO_DOC_' . $row['tipo_documento'] );
            } else {
                $documento = '';
                $codigoDocumento = '';
            }


            $baseImponible = $importe / 1.21;
            $baseImponibleRedondeado = round($baseImponible, 2, PHP_ROUND_HALF_EVEN);
            
            $importeIva = $baseImponible * 0.21;
            $importeIvaRedondeado = round($importeIva, 2, PHP_ROUND_HALF_EVEN);
        

            $activeSheet->setCellValue('A' . $i, date('d/m/Y', strtotime($row['fecha']) ) );
            $activeSheet->setCellValue('B' . $i, $row['id_pedido'] );
            $activeSheet->setCellValue('C' . $i, ( $row['fecha_pago'] ) ? date('d/m/Y H:i', strtotime($row['fecha_pago']) ) : '' );
            $activeSheet->setCellValue('D' . $i, $codigoComprobante );
            $activeSheet->setCellValue('E' . $i, $puntoVenta );
            $activeSheet->setCellValue('F' . $i, $row['comprobante'] );
            $activeSheet->setCellValue('G' . $i, $codigoDocumento );
            $activeSheet->setCellValue('H' . $i, $documento );
            $activeSheet->setCellValue('I' . $i, $row['nombre'] . ' ' . $row['apellido'] );
            $activeSheet->setCellValue('J' . $i, $row['provincia'] );
            $activeSheet->setCellValue('K' . $i, $baseImponibleRedondeado );
            $activeSheet->setCellValue('L' . $i, $importeIvaRedondeado );
            $activeSheet->setCellValue('M' . $i, $baseImponibleRedondeado +  $importeIvaRedondeado );
            
            $activeSheet->setCellValue('N' . $i, $row['costo_mercaderia'] );
            $activeSheet->setCellValue('O' . $i, $row['envio'] );
            $activeSheet->setCellValue('P' . $i, $row['forma_pago'] );
            
            $activeSheet->getStyle('K' . $i . ':O' . $i)->getNumberFormat()->setFormatCode($formatCurrencyCell);
            
            $i++;
        }
        

        $tempFile = sfConfig::get('sf_temp_dir') . '/libro_iva_venta_' . time();
        @unlink( $tempFile );
        
        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save($tempFile);

        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_LIBRO_IVA_VENTAS );
        $notificacionBackend->setResponse( $tempFile );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
        
        return $tempFile;
    }
}
