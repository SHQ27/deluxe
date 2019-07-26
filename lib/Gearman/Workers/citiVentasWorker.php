<?php

class Net_Gearman_Job_CitiVentasWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {   
        $idUsuario = $arg['idUsuario'];
        $periodo = $arg['periodo'];
        
        $desde = $periodo;
        
        $time = strtotime($periodo);
        $hasta = date('Y-m-d', mktime(0, 0 , 0, date('m',$time) + 1, 0, date('Y',$time) ) );
    
        $configWS = sfConfig::get('app_afip_ws');
        $puntoVenta = $configWS['punto_de_venta'];

        $documentos = facturaTable::getInstance()->libroIvaVenta($desde, $hasta);
        
        $comprobantesVentas = '';
        $alicuotasComprobantesVentas = '';
        foreach ($documentos as $row)
        {
            $nroDocumento = trim($row['documento']);

            if ( !$nroDocumento ) {
                $tipoDocumento = 99;
            }else if ( $row['tipo_documento'] ) {
                $tipoDocumento = constant( 'Afip_WSFE::TIPO_DOC_' . $row['tipo_documento'] );    
            } else {
                $tipoDocumento = Afip_WSFE::TIPO_DOC_DNI;
            }
            
            $comprobantesVentas  .= date('Ymd', strtotime($row['fecha']));
            $comprobantesVentas  .= str_pad($row['tipo'] === 'NCREDITO' ? Afip_WSFE::NOTA_DE_CREDITO_B : Afip_WSFE::FACTURA_B, 3, '0', STR_PAD_LEFT);
            $comprobantesVentas  .= str_pad($puntoVenta, 5, '0', STR_PAD_LEFT);
            $comprobantesVentas  .= str_pad($row['comprobante'], 20, '0', STR_PAD_LEFT);
            $comprobantesVentas  .= str_pad($row['comprobante'], 20, '0', STR_PAD_LEFT);
            $comprobantesVentas  .= $tipoDocumento;
            $comprobantesVentas  .= str_pad($nroDocumento, 20, '0', STR_PAD_LEFT);


            $nombre = stringHelper::getInstance()->quitarAcentos($row['nombre'] . ' ' . $row['apellido']);

            $comprobantesVentas  .= str_pad(substr($nombre, 0, 30), 30, ' ', STR_PAD_RIGHT);
            $comprobantesVentas  .= str_pad(str_replace( '.', '', $row['importe'] ), 15, '0', STR_PAD_LEFT);
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= 'PES';
            $comprobantesVentas  .= '0001000000';
            $comprobantesVentas  .= '1';
            $comprobantesVentas  .= '0';
            $comprobantesVentas  .= '000000000000000';
            $comprobantesVentas  .= '00000000';
            $comprobantesVentas  .= "\n";

            $baseImponible = $row['importe'] / 1.21;
            $baseImponibleRedondeado = round($baseImponible, 2, PHP_ROUND_HALF_EVEN) * 100;

            $importeIva = $baseImponible * 0.21;
            $importeIvaRedondeado = round($importeIva, 2, PHP_ROUND_HALF_EVEN)  * 100;;

            $alicuotasComprobantesVentas .= str_pad($row['tipo'] === 'NCREDITO' ? Afip_WSFE::NOTA_DE_CREDITO_B : Afip_WSFE::FACTURA_B, 3, '0', STR_PAD_LEFT);
            $alicuotasComprobantesVentas .= str_pad($puntoVenta, 5, '0', STR_PAD_LEFT);
            $alicuotasComprobantesVentas .= str_pad($row['comprobante'], 20, '0', STR_PAD_LEFT);
            $alicuotasComprobantesVentas .= str_pad(round($baseImponibleRedondeado), 15, '0', STR_PAD_LEFT);
            $alicuotasComprobantesVentas .= '0005';
            $alicuotasComprobantesVentas .= str_pad(round($importeIvaRedondeado), 15, '0', STR_PAD_LEFT);
            $alicuotasComprobantesVentas .= "\n";
        }
        
        
        $tempFileComprobantesVentas          = sfConfig::get('sf_temp_dir') . '/comprobantes_ventas_' . time();
        file_put_contents($tempFileComprobantesVentas, $comprobantesVentas);

        $tempFileAlicuotasComprobantesVentas = sfConfig::get('sf_temp_dir') . '/alicuotas_comprobantes_' . time();
        file_put_contents($tempFileAlicuotasComprobantesVentas, $alicuotasComprobantesVentas);


        // Creo el zip
        $zipPath = sfConfig::get('sf_temp_dir') . '/citi-ventas-' . substr($periodo, 0, 7) . '.zip';

        $zip = new ZipArchive();
        $zip->open($zipPath, ZIPARCHIVE::CREATE);
        $zip->addFile( $tempFileComprobantesVentas, 'comprobantes_ventas.txt');
        $zip->addFile( $tempFileAlicuotasComprobantesVentas, 'alicuotas_comprobantes.txt');
        $zip->close();

        @unlink( $tempFileComprobantesVentas );
        @unlink( $tempFileAlicuotasComprobantesVentas );

        // Creo la notificacion
        $notificacionBackend = new notificacionBackend();
        $notificacionBackend->setTipo( notificacionBackend::TIPO_CITI_VENTAS );
        $notificacionBackend->setResponse( $zipPath );
        $notificacionBackend->setIdUsuario( $idUsuario );
        $notificacionBackend->save();

        
        return $zipPath;
    }
}
