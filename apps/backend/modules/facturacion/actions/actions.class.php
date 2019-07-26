<?php

/**
 * facturacion actions.
 *
 * @package    deluxebuys
 * @subpackage aws
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facturacionActions extends sfActions
{
	
  /*
  *  Esta funcion sirve para utilizar toda la infraestructura de pedidos para las pantallas de Facturacion.
  */
  public function redirect($url, $statusCode = 302)
  {
    $url = ($url == '@pedido') ? '@facturacion' : $url;
    return parent::redirect($url,$statusCode);
  }	
	  
  public function executeGenerarNotaCredito(sfWebRequest $request)
  {
	$form = new generarNotaCreditoForm();
	
	if( $request->isMethod('post') )
	{		
		$form->bind( $request->getParameter('generarNotaCreditoForm') );
				
		if ( $form->isValid() )
		{
			if ( $form->generate() )
			{
			    $this->redirect('/backend/ncredito');
			}
			else
			{
			    $this->redirect('/backend/facturacion/notaDeCredito/generar');
			}
			exit;
		}
	}  	
	
	$this->form = $form;
  }
    
    
  public function executeDescargarFactura(sfWebRequest $request)
  {
  	$idPedido = $request->getParameter('idPedido');
  	$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  	
  	$factura = $pedido->getFactura();
  	
  	if ( $factura )
  	{
		$filePath = FacturaPDFFactory::getInstance()->getDownloadPath( $factura );
		$fileName = FacturaPDFFactory::getInstance()->getDownloadName( $factura );
	  	  	
	    header("Content-type: application/octet-stream");
	    header("Content-Disposition: attachment; filename=\"$fileName\"\n");
	    $fp=fopen( $filePath , "r");
	    fpassthru($fp);
  	}
    
    throw new sfStopException();
  }
  
  public function executeDescargarNCredito(sfWebRequest $request)
  {
      $idNCredito = $request->getParameter('idNCredito');
      $nCredito = ncreditoTable::getInstance()->findOneByIdNcredito( $idNCredito );
    
      $filePath = NCreditoPDFFactory::getInstance()->getDownloadPath( $nCredito );
      $fileName = NCreditoPDFFactory::getInstance()->getDownloadName( $nCredito );

      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=\"$fileName\"\n");
      $fp=fopen( $filePath , "r");
      fpassthru($fp);
  
      throw new sfStopException();
  }
  
  public function executeConsultar(sfWebRequest $request)
  {
	$form = new consultarComprobanteAfipForm();
	
	if( $request->isMethod('post') )
	{		
		$form->bind( $request->getParameter('consultarComprobanteAfipForm') );
				
		if ( $form->isValid() )
		{
			$this->result = $form->getResponse();
		}
	}
	
	$this->form = $form;
  }
  
  public function executeConsultarEstadoNCredito(sfWebRequest $request)
  {
  	$idsNCredito = $request->getParameter('idsNCredito');
  	$idsNCredito = explode(',', $idsNCredito);
  	
  	$notasCredito = ncreditoTable::getInstance()->listByIdNCredito($idsNCredito, true);
  	echo json_encode( $notasCredito ); 
  	return sfView::NONE;
  }
  
  
  public function executeLibroIvaVenta(sfWebRequest $request)
  {
      $libroIvaVentaForm = new libroIvaVentaForm();
  
      $this->data = false;
  
      if( $request->isMethod('post') )
      {
          $libroIvaVentaForm->bind( $request->getParameter('libroIvaVentaForm') );
            
          if ( $libroIvaVentaForm->isValid() )
          {
              $libroIvaVentaForm->process();
              $this->redirect('notificacion_backend_start');
              exit;
          }
  
      }
  
      $this->libroIvaVentaForm = $libroIvaVentaForm;
  }

  public function executeCitiVentas(sfWebRequest $request)
  {
      $citiVentasForm = new citiVentasForm();
  
      $this->data = false;
  
      if( $request->isMethod('post') )
      {
          $citiVentasForm->bind( $request->getParameter('citiVentasForm') );
            
          if ( $citiVentasForm->isValid() )
          {
              $citiVentasForm->process();
              $this->redirect('notificacion_backend_start');
              exit;
          }
  
      }
  
      $this->citiVentasForm = $citiVentasForm;
  }
}
