<?php

require_once dirname(__FILE__).'/../lib/notificacionesBackendGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/notificacionesBackendGeneratorHelper.class.php';

/**
 * notificacionesBackend actions.
 *
 * @package    deluxebuys
 * @subpackage notificacionesBackend
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class notificacionesBackendActions extends autoNotificacionesBackendActions
{
    public function executeStart(sfWebRequest $request)
    {
    }
    
    public function executeVer(sfWebRequest $request)
    {
        $notificacionBackend = $this->getRoute()->getObject();
        
        $notificacionBackend->getResponse();
        $notificacionBackend->setVisto(true);
        $notificacionBackend->save();
        
        $method = 'ver' . $notificacionBackend->getTipo();
        $this->$method($notificacionBackend);
        
        $this->notificacionBackend = $notificacionBackend;
        
        $this->setTemplate('ver' . $notificacionBackend->getTipo() );
    }
    
    protected function verCRONO($notificacionBackend)
    {
        $tempFile = $notificacionBackend->getResponse();
        
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Length: ".filesize($tempFile));
        header('Content-Disposition: attachment; filename="reporteCronologico.xls"');
        
        readfile($tempFile);
        @unlink($tempFile);
        exit;
    }

    protected function verLIIVA($notificacionBackend)
    {
        $tempFile = $notificacionBackend->getResponse();
        
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Length: ".filesize($tempFile));
        header('Content-Disposition: attachment; filename="libro_iva_venta.xls"');
        
        readfile($tempFile);
        @unlink($tempFile);
        exit;
    }

    protected function verCIVEN($notificacionBackend)
    {
        $tempFile = $notificacionBackend->getResponse();
        $zipName = str_replace(sfConfig::get('sf_temp_dir') . '/', '', $tempFile);
        
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header('Content-Type: application/zip');
        header("Content-Length: ".filesize($tempFile));
        header('Content-Disposition: attachment; filename="' . $zipName . '"');
        
        readfile($tempFile);
        @unlink($tempFile);
        exit;
    }

    protected function verHOJRU($notificacionBackend)
    {
        $tempFile = $notificacionBackend->getResponse();
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header('Content-Type: text/html');
        header("Content-Length: ".filesize($tempFile));
        header('Content-Disposition: attachment; filename="hoja_de_ruta.html"');
        
        readfile($tempFile);
        @unlink($tempFile);
        exit;
    }


    
    protected function verPSCML($notificacionBackend) { }
    
    protected function verPPUML($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();
        $ids = $response['ids'];
        
        $this->productos = productoTable::getInstance()->listByIdProductos( $ids );
        $this->result = $response['result'];
    }
    
    protected function verPEDST($notificacionBackend)
    {
        $ids = $notificacionBackend->getResponseArray();
    
        $this->productos = productoTable::getInstance()->listByIdProductos( $ids );
    }
    
    protected function verPEDPR($notificacionBackend)
    {
        $ids = $notificacionBackend->getResponseArray();
    
        $this->productos = productoTable::getInstance()->listByIdProductos( $ids );
    }

    protected function verCACSV($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();
                
        $status = $response['status'];
        
        $productos = array();
        $errors = array();
        if ($status )
        {
            $productos = productoTable::getInstance()->listByIdProductos( $response['idsProducto'] );
        }
        else
        {
            $errors = $response['errors'];
        }
        
        $this->errors = $errors;
        $this->productos = $productos;
        $this->status = $status;
        $this->nombreCampana = $response['nombreCampana'];
    }

    protected function verPECSV($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();
                
        $status = $response['status'];
        
        $productos = array();
        $errors = array();
        if ($status )
        {
            $productos = productoTable::getInstance()->listByIdProductos( $response['idsProducto'] );
        }
        else
        {
            $errors = $response['errors'];
        }
        
        $this->errors = $errors;
        $this->productos = $productos;
        $this->status = $status;
    }
    
    protected function verPSOUT($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();
        $ids = array_keys( $response['detalle'] );
    
        $this->productos = productoTable::getInstance()->listByIdProductos( $ids );
        $this->data = $response;
    }
    
    protected function verPNOUT($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();
        $ids = array_keys( $response['detalle'] );

        $this->productos = productoTable::getInstance()->listByIdProductos( $ids );
        $this->data = $response;
    }

    protected function verPIMPO($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();

        $this->error = $response['error'];
    }
    
    public function executeCheck(sfWebRequest $request)
    {
        $cantidad = notificacionBackendTable::getInstance()->count();
        return $this->renderText($cantidad);
    }

    protected function verRECAM($notificacionBackend)
    {
        $response = unserialize( $notificacionBackend->getResponse() );

        $this->data = $response['data'];
        $this->campana = $response['campana'];
        $this->restaurarRefuerzo = $response['restaurarRefuerzo'];
        $this->idProductoItemsConFaltantes = $response['idProductoItemsConFaltantes'];
    }

    protected function verPRENV($notificacionBackend)
    {
        $response = $notificacionBackend->getResponseArray();

        if ( $response['ok'] ) {
            $this->ok = explode(',', $response['ok']);    
        } else {
            $this->ok = array();
        }

        if ( $response['error'] ) {
            $this->error = explode(',', $response['error']);
        } else {
            $this->error = array();
        }
        

        
    }

    protected function verMENSA($notificacionBackend)
    {
    }
    
}
