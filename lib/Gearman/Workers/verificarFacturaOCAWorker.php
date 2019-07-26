<?php

class Net_Gearman_Job_VerificarFacturaOcaWorker extends Net_Gearman_Job_Pragmore
{
    public function run ($arg)
    {        
        $file = fopen( $arg['filepath'], "r");
                
        $headers = fgetcsv($file, 0, ";");
        
        $data = array();
        while (($row = fgetcsv($file, 0, ";")) !== FALSE)
        {
            if ( !isset($row[1]) || !isset($row[2])  ) return array('error' => 'El separador de columnas debe ser ";" para este CSV');
        
            $guiaEnvio = $row[1] . '00000000' . $row[2];
            $exists = pedidoTable::getInstance()->existGuiaEnvio($guiaEnvio);
        
            $data[] = array('row' => $row, 'exists' => $exists);
        }
        
        @unlink( $arg['filepath'] );
        
        return array('error' => false,'headers' => $headers, 'data' => $data);
        
    }
}
