<?php

class Net_Gearman_Job_ReporteCronologicoWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        // Recupero el id del usuario logueado al backend
        $idUsuario = $arg['idUsuario'];
        
        $periodo = $arg['periodo'];
        $idEshop = $arg['idEshop'];
        
        $eshop = eshopTable::getInstance()->getById( $idEshop );
        
        if ( $eshop ) {
            $eshop = $eshop->getDenominacion();
        } else {
            $eshop = 'Deluxe Buys';
            $idEshop = null;
        }
        
        $phpExcel = new PHPExcel();
        $phpExcel->getProperties()->setCreator("DeluxeBuys");
        $activeSheet = $phpExcel->setActiveSheetIndex(0);
        
        $activeSheet->setCellValue('A1', 'Deluxebuys - Planilla de pedidos');
        $activeSheet->mergeCells('A1:D1');
        $activeSheet->mergeCells('A2:D2');
        
        $activeSheet->setCellValue('A3', 'eShop: ' . $eshop);
        $activeSheet->mergeCells('A3:D3');
        
        $activeSheet->setCellValue('A4', 'Desde: ' . $periodo['from']);
        $activeSheet->mergeCells('A4:D4');
        
        $activeSheet->setCellValue('A5', 'Hasta: ' . $periodo['to']);
        $activeSheet->mergeCells('A5:D5');
        
        
        $activeSheet->setCellValue('A7', 'Accion');
        $activeSheet->setCellValue('B7', 'CodPedido');
        $activeSheet->setCellValue('C7', 'Fuente');
        $activeSheet->setCellValue('D7', 'Marca');
        $activeSheet->setCellValue('E7', 'Condicion Fiscal');
        $activeSheet->setCellValue('F7', 'Cod prod');
        $activeSheet->setCellValue('G7', 'Producto');
        $activeSheet->setCellValue('H7', 'Color');
        $activeSheet->setCellValue('I7', 'Talle');
        $activeSheet->setCellValue('J7', 'Categoria');
        $activeSheet->setCellValue('K7', 'Genero');
        $activeSheet->setCellValue('L7', 'Precio DB');
        $activeSheet->setCellValue('M7', 'Precio DB (Sin IVA)');
        
        $activeSheet->setCellValue('N7', 'Costo');
        $activeSheet->setCellValue('O7', 'Costo (Sin IVA)');
        
        $activeSheet->setCellValue('P7', 'Margen');
        $activeSheet->setCellValue('Q7', 'Cnt');
        
        $activeSheet->setCellValue('R6', 'Bonificacion');
        $activeSheet->mergeCells('R6:U6');
        $activeSheet->setCellValue('R7', 'Devolucion en MP');
        $activeSheet->setCellValue('S7', 'Credito Cta');
        $activeSheet->setCellValue('T7', 'Motivo');
        $activeSheet->setCellValue('U7', 'Sub Motivo');
        
        $activeSheet->setCellValue('V6', 'Descuento');
        $activeSheet->mergeCells('V6:X6');
        
        $activeSheet->setCellValue('V7', 'Descuento');
        $activeSheet->setCellValue('W7', 'Motivo de DTO');
        $activeSheet->setCellValue('X7', 'Codigo');
        $activeSheet->setCellValue('Y7', "Costo de Envio\nque paga Deluxe");
        $activeSheet->setCellValue('Z7', "Costo de Envio\nque paga Cliente");
        $activeSheet->setCellValue('AA7', 'Venta DB Total');
        $activeSheet->setCellValue('AB7', 'Total Facturado');
        
        $activeSheet->setCellValue('AC7', 'Cliente');
        $activeSheet->setCellValue('AD7', 'Tipo');
        $activeSheet->setCellValue('AE7', 'Documento');
        $activeSheet->setCellValue('AF7', 'E-mail');

        $activeSheet->setCellValue('AG7', 'Fecha');
        $activeSheet->setCellValue('AH7', 'Localidad');
        $activeSheet->setCellValue('AI7', 'Provincia');
        $activeSheet->setCellValue('AJ7', 'Forma de Pago');
        
        $headerCellStyle = array(
                'font' => array('bold' => true),
                'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                        'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('argb' => '000000'))));
        
        $dataCellStyle = array(
                'borders' => array(
                        'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('argb' => '000000')
                        )
                ),
                'font' => array(
                        'color' => array('rgb'=>'000000'),
                ),
        );
        
        $activeSheet->getStyle('A7:AJ7')->applyFromArray($headerCellStyle);
        $activeSheet->getStyle('R6:U6')->applyFromArray($headerCellStyle);
        $activeSheet->getStyle('V6:X6')->applyFromArray($headerCellStyle);
        
        $data = reporteCronologicoTable::getInstance()->getReporte($idEshop, $periodo['from'], $periodo['to']);
        
        $i = 8;
        foreach ($data as $reporteCronologico)
        {
            $activeSheet->setCellValue('A' . $i, $reporteCronologico->getAccion() );
            $activeSheet->setCellValue('B' . $i, $reporteCronologico->getIdPedido() );
            $activeSheet->setCellValue('C' . $i, $reporteCronologico->getFuente() );
            $activeSheet->setCellValue('D' . $i, $reporteCronologico->getMarca() );
            $activeSheet->setCellValue('E' . $i, $reporteCronologico->getCondicionFiscal() );
            $activeSheet->setCellValue('F' . $i, $reporteCronologico->getCodigoProducto() );
            $activeSheet->setCellValue('G' . $i, $reporteCronologico->getProducto() );
            $activeSheet->setCellValue('H' . $i, $reporteCronologico->getColor() );
            $activeSheet->setCellValue('I' . $i, $reporteCronologico->getTalle() );
            $activeSheet->setCellValue('J' . $i, $reporteCronologico->getCategoria() );
            $activeSheet->setCellValue('K' . $i, $reporteCronologico->getGenero() );
            $activeSheet->setCellValue('L' . $i, $reporteCronologico->getPrecioDeluxe() );
            $activeSheet->setCellValue('N' . $i, $reporteCronologico->getCosto() );
            
            
            if ( $reporteCronologico->getAccion() == 'Pedido Detalle' )
            {
                $activeSheet->setCellValue('M' . $i, round( $reporteCronologico->getPrecioDeluxe() / 1.21, 2 ) );
                
                if ( $reporteCronologico->getCondicionFiscal() == marca::COND_FISCAL_RI )
                {
                    $activeSheet->setCellValue('O' . $i, round( $reporteCronologico->getCosto() / 1.21, 2 ) );
                }
                else
              {
                   $activeSheet->setCellValue('O' . $i, round( $reporteCronologico->getCosto(), 2 ) );
                }
            }
        
            $margen = '-';
            if ( $reporteCronologico->getCosto() !=0 )
            {
                $margen = $reporteCronologico->getPrecioDeluxe() / $reporteCronologico->getCosto();
            }
        
            $activeSheet->setCellValue('P' . $i, $margen );
        
            $activeSheet->setCellValue('Q' . $i, $reporteCronologico->getCantidad() );
            $activeSheet->setCellValue('R' . $i, $reporteCronologico->getBonificacionDevolucionMp() );
            $activeSheet->setCellValue('S' . $i, $reporteCronologico->getBonificacionDevolucionDeluxe() );
            $activeSheet->setCellValue('T' . $i, $reporteCronologico->getBonificacionMotivo() );
            $activeSheet->setCellValue('U' . $i, $reporteCronologico->getBonificacionSubmotivo() );
            $activeSheet->setCellValue('V' . $i, $reporteCronologico->getDescuento() );
            $activeSheet->setCellValue('W' . $i, $reporteCronologico->getDescuentoMotivo() );
            $activeSheet->setCellValue('X' . $i, $reporteCronologico->getDescuentoCodigo() );
            $activeSheet->setCellValue('Y' . $i, $reporteCronologico->getCostoEnvioDeluxe() );
            $activeSheet->setCellValue('Z' . $i, $reporteCronologico->getCostoEnvio() );
            $activeSheet->setCellValue('AA' . $i, $reporteCronologico->getVentaDbTotal() );
            $activeSheet->setCellValue('AB' . $i, $reporteCronologico->getTotalFacturado() );
            $activeSheet->setCellValue('AC' . $i, $reporteCronologico->getCliente() );
            $activeSheet->setCellValue('AD' . $i, $reporteCronologico->getClienteTipoDocumento() );
            $activeSheet->setCellValue('AE' . $i, $reporteCronologico->getClienteDocumento() );
            $activeSheet->setCellValue('AF' . $i, $reporteCronologico->getClienteEmail() );
            $activeSheet->setCellValue('AG' . $i, $reporteCronologico->getDateTimeObject('fecha')->format("d/m/Y H:i:s") );
            $activeSheet->setCellValue('AH' . $i, $reporteCronologico->getLocalidad() );
            $activeSheet->setCellValue('AI' . $i, $reporteCronologico->getProvincia() );
            $activeSheet->setCellValue('AJ' . $i, $reporteCronologico->getFormaPago()  );
            
            $activeSheet->getStyle('A' . $i . ':AJ' . $i . '')->applyFromArray($dataCellStyle);
            $i++;
        }
        
        
        $tempFile = sfConfig::get('sf_temp_dir') . '/reporte_cronologico_' . time();
        
        $writer = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
        $writer->save($tempFile);
        
        
        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_REPORTE_CRONOLOGICO );
        $notificacionBackend->setResponse( $tempFile );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();
    }
}
