<?php

class Logger {

    protected $path;
    
    protected $fileName = 'deluxebuys.log';

    public function __construct($path) {
        
        if (empty($path)) {
            Throw new Exception("La ruta no es valida.");
        }
        
        if (!file_exists($path)) {
            Throw new Exception("La ruta no existe.");
        }
        
        if (!is_writeable($path)) {
            Throw new Exception("Este directorio no tiene los permisos suficientes.");
        }
        
        $this->path = $this->parsePath($path);
    }	

    protected function parsePath($path) {
        $strLenght = strlen($path);
        $lastChar = substr($path, $strLenght - 1, $strLenght);
        $path = $lastChar != "/" ? $path . "/" : $path;

        if ( is_dir($path) ) {
            return $path . $this->fileName;
        } else {
            return $path;
        }
    }

    protected function save($line) {
        $fhandle = fopen($this->path, "a+");
        fwrite($fhandle, $line);
        fclose($fhandle);
    }

    public function addLine($line) {
        $line = is_array($line) ? print_r($line, true) : $line;
        $line = date("d-m-Y h:i:s") . ": $line\n";
        $this->save($line);
    }
}
