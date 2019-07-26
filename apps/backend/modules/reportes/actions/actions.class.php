<?php

/**
 * reportes actions.
 *
 * @package    deluxebuys
 * @subpackage reportes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportesActions extends sfActions
{    
  public function executeVentasXPeriodos(sfWebRequest $request)
  {
  	$reporteVentasPorPeriodoForm = new reporteVentasPorPeriodoForm();
  	
    if( $request->isMethod('post') )
  	{
  		$reporteVentasPorPeriodoForm->bind( $request->getParameter('reporteVentasPorPeriodo') );
  		
  		if ( $reporteVentasPorPeriodoForm->isValid() )
  		{
  			
  			if ( $reporteVentasPorPeriodoForm->download() === false )
  			{
  			    $this->getUser()->setFlash('ventasPorPeriodo_error', "Falta completar el rango de fechas");
  			}
  		}
  		
  	}  	
  	
  	$this->reporteVentasPorPeriodoForm = $reporteVentasPorPeriodoForm;
  }
  
  public function executeMensual(sfWebRequest $request)
  {
      $form = new reporteMensualForm();
       
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter('reporteMensual') );
  
          if ( $form->isValid() )
          {
              $form->download();
          }
  
      }
       
      $this->form = $form;
  }

  
  public function executeMarketing(sfWebRequest $request)
  {
      $form = new reporteMarketingForm();
       
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter('reporteMarketing') );
  
          if ( $form->isValid() )
          {
              $form->download();
          }
  
      }
       
      $this->form = $form;
  }


  
  public function executeCampanas(sfWebRequest $request)
  {
      $reporteCampanasForm = new reporteCampanasForm();
      
      if( $request->isMethod('post') )
      {
          $reporteCampanasForm->bind( $request->getParameter('reporteCampanas') );
                
          if ( $reporteCampanasForm->isValid() )
          {
              $this->data = $reporteCampanasForm->generar();
          }
            
      }
      
      $this->reporteCampanasForm = $reporteCampanasForm;
  }
  
  public function executeSuscriptos(sfWebRequest $request)
  {
      $usuariosSuscriptos = bonificacionTable::getInstance()->cantidadUsuariosSuscriptos(tipoBonificacion::SUSCRIPCION);
      $usuariosSuscriptosCompradores = pedidoBonificacionTable::getInstance()->cantidadUsuariosSuscriptosCompradores(tipoBonificacion::SUSCRIPCION);
      
      $this->suscriptos = array(
            'usuariosSuscriptos' => $usuariosSuscriptos,
            'usuariosSuscriptosCompradores' => $usuariosSuscriptosCompradores,
        );
  }
  
  public function executeVentaOnline(sfWebRequest $request)
  {
    $idUsuario = $_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id'];
  	$campanaUsuario = campanaUsuarioTable::getInstance()->findOneByIdSfGuardUser($idUsuario);
  	
  	if (!$campanaUsuario)
  	{
  		$this->deshabilitado = true;
  		return;
  	}
  	
  	$idCampana = $campanaUsuario->getIdCampana();
  	$campana = campanaTable::getInstance()->getById( $idCampana );
  	  	
  	$this->fechaInicio = strtotime($campana->getFechaInicio()) ;
  	$this->fechaFin    = strtotime($campana->getFechaFin());
  	  	
  	$datos = campanaTable::getInstance()->getReporteVenta($idCampana);
  	  	
  	$datosProcesados = array();
  	$datosProcesados['FP'] = array();
  	foreach($datos as $fecha => $row)
  	{
  		if ( $fecha >= date('Y-m-d', $this->fechaFin) )
  		{
  			foreach ($row as $idProductoItem => $venta)
  			{
  				if ( isset($datosProcesados['FP'][$idProductoItem]) )
  				{
  					$datosProcesados['FP'][$idProductoItem] += $venta;
  				}
  				else
  				{
  					$datosProcesados['FP'][$idProductoItem] = $venta;
  				}
  			}
  		}
  		else
  		{
  			$datosProcesados[$fecha] = $row;
  		}
  	}
  	$datos = $datosProcesados;
  	  	
  	$productoItems = array();
  	if ($datos)
  	{
	  	$idProductoItems = array();
	  	foreach($datos as $row)
	  	{
	  		foreach($row as $key=>$value)
	  		{
	  			$idProductoItems[] = $key;
	  			$idProductoItems = array_unique($idProductoItems);	  			
	  		}
	  	}	  	
	  	
	  	$objects = productoItemTable::getInstance()->listByIds( $idProductoItems );
	  	foreach( $objects as $productoItem) $productoItems[ $productoItem->getIdProductoItem() ] = $productoItem;
  	}

  	$this->productoItems = $productoItems;
  	$this->datos = $datos;
  	$this->campana = $campana;
  }
  
  public function executeComerciales(sfWebRequest $request)
  {
  	$reporteComercialesForm = new reporteComercialesForm();
  	
    if( $request->isMethod('post') )
  	{  	    
  		$reporteComercialesForm->bind( $request->getParameter('reporteComercialesForm') );
  		  		
  		if ( $reporteComercialesForm->isValid() )
  		{
  			$this->data = $reporteComercialesForm->process();
  			if ( $this->data === false )
  			{
  			    $this->getUser()->setFlash('reporteComercialesForm_error', "Falta completar el rango de fechas");
  			    unset($this->data);
  			}
  			
  		}
  		
  	}  	
  	
  	$this->reporteComercialesForm = $reporteComercialesForm;
  }
  
  public function executeCronologico(sfWebRequest $request)
  {      
      // Manejo del Form
      $reporteCronologicoForm = new reporteCronologicoForm();
  
      $this->data = false;
  
      if( $request->isMethod('post') )
      {
          $reporteCronologicoForm->bind( $request->getParameter('reporteCronologicoForm') );
          
          if ( $reporteCronologicoForm->isValid() )
          {
              $reporteCronologicoForm->process();
              $this->redirect('notificacion_backend_start');
              exit;
          }
      }
      
      $this->reporteCronologicoForm = $reporteCronologicoForm;
      
      // Historicos
      $reporteDirName = sfConfig::get('app_reporteCronologico_dir') . '/';
      $reportesHistorico = glob("{$reporteDirName}*.[xX][lL][sS]");
      
      $reportes = array();
      foreach( $reportesHistorico as $reporte )
      {
          $filename = str_replace($reporteDirName, '', $reporte);
          $data = explode('_',  substr($filename, 0, strlen($filename) - 4) );
          $year = $data[3];
          $week = $data[4];
          
          $rango = pmDateHelper::getInstance()->fechasBySemana($week, $year);
          $rango['from'] = date('d/m/Y', strtotime($rango['from']));
          $rango['to'] = date('d/m/Y', strtotime($rango['to']));
          
          $reportes[] = array('filename' => $filename, 'week' => $week, 'year' => $year, 'rango' => implode(' al ', $rango));
      }
      
      $reportes = array_reverse($reportes);
      
      $this->reportes = $reportes;      
  }

  public function executeDescargarCronologico(sfWebRequest $request)
  {
      $filename = base64_decode($request->getParameter('filename')) ;
      $filepath = sfConfig::get('app_reporteCronologico_dir') . '/' . $filename;
      
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
      header('Content-Type: application/vnd.ms-excel');
      header("Content-Length: ".filesize($tempFile));
      header('Content-Disposition: attachment; filename="' . $filename . '"');
      
      readfile($filepath);
  }
  
  public function executeCuponeras(sfWebRequest $request)
  {
      $reporteCuponerasForm = new reporteCuponerasForm();
  
      if( $request->isMethod('post') )
      {
          $reporteCuponerasForm->bind( $request->getParameter('reporteCuponerasForm') );
                    
          if ( $reporteCuponerasForm->isValid() )
          {
              $this->data = $reporteCuponerasForm->process();
          }
      }
  
      $this->reporteCuponerasForm = $reporteCuponerasForm;
  }
  
  public function executeAdNetworks(sfWebRequest $request)
  {
      $resultados = false;
      $form = new reporteAdNetworksForm();
      
      if( $request->isMethod('post') )
      {
          $form->bind( $request->getParameter('reporteAdNetworks') );
          
          if ( $form->isValid() )
          {              	
              $resultados = $form->generar();
          }
  
      }
       
      $this->form = $form;
      $this->resultados = $resultados;
  }
    
}
