<?php

/**
 * pedido actions.
 *
 * @package        deluxebuys
 * @subpackage     pedido
 * @author         Your name here
 * @version        SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class abstractPedidoActions extends deluxebuysActions
{
/**
  * Executes iniciar action
  *
  * @param sfRequest $request A request object
  */
  public function executeIniciar(sfWebRequest $request)
  {
    $this->eshop = eshopTable::getInstance()->getCurrent();

  	$idPedido = $request->getParameter('idPedido');
  	$checkoutURL = base64_decode( $request->getParameter('checkoutURL') );
  	
  	$pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );
  	$usuario = $this->getUser()->getCurrentUser();
  			
  	if ($usuario->getIdUsuario() !=	$pedido->getIdUsuario())
  	{
  		echo 'Está intentando realizar una acción no permitida.';
  		return sfView::NONE;
  	}

    if ( deviceHelper::getInstance()->isMobile() ) {
      $this->redirect($checkoutURL);
    } else {
      $this->checkoutURL = $checkoutURL;
    }
  }

  /**
   * Executes respuestaMercadoPago action
   *
   * @param sfRequest $request A request object
   */
   public function executeRespuestaMercadoPago(sfWebRequest $request)
   {
    $eshop = eshopTable::getInstance()->getCurrent();
    $id    = $_GET["id"];
    $topic = $_GET["topic"];

    // Obtengo la info de mercado pago
    if( $topic == 'payment' ) {            
        $references = PagoProvider::getInstance( formaPago::MERCADOPAGO )->getReferencesByPago( $id, $eshop );
    } else if($topic == 'merchant_order'){
        $references = PagoProvider::getInstance( formaPago::MERCADOPAGO )->getReferencesByMerchantOrder( $id, $eshop );
    }

    $idPedido = $references['idPedido'];
    $idMerchantOrder = $references['idMerchantOrder'];
     
    // Obtengo el pedido
    $pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
    
    if ($pedido)
    {   
      $response = PagoProvider::getInstance( formaPago::MERCADOPAGO )->consultar( $pedido->getIdPedido(), $idMerchantOrder );

      if ($response)
      {
        // Anoto la respuesta para luego procesarla en batch
        $pagoNotificacion = new pagoNotificacion();
        $pagoNotificacion->setIdFormaPago(formaPago::MERCADOPAGO);
        $pagoNotificacion->setMetodo(pagoNotificacion::ENVIADOMP);
        $pagoNotificacion->setIdPedido( $idPedido );
        $pagoNotificacion->setResponse( json_encode($response) );
        $pagoNotificacion->setProcesado(false);
        $pagoNotificacion->setId( $pedido->getIdPedido() );
        $pagoNotificacion->save();
      }
    }

     $status= "200";
     $status_header = 'HTTP/1.0 ' . $status . ' OK';
     header($status_header);
     exit;
   }
    
  /**
   * Executes retornoMercadoPago action
   *
   * @param sfRequest $request A request object
   */
  public function executeRetornoMercadoPago(sfWebRequest $request)
  {
      $idPedido = $request->getParameter('idPedido');
      $resultado = $request->getParameter('resultado');
      
      // Obtengo la info de mercado pago
      $response = PagoProvider::getInstance( formaPago::MERCADOPAGO )->consultar($idPedido);
      
      // Anoto la respuesta para luego procesarla en batch
      if ($response) {
        $pagoNotificacion = new pagoNotificacion();
        $pagoNotificacion->setIdFormaPago(formaPago::MERCADOPAGO);
        $pagoNotificacion->setMetodo(pagoNotificacion::RETORNO);
        $pagoNotificacion->setIdPedido( $idPedido );
        $pagoNotificacion->setResponse( json_encode($response) );
        $pagoNotificacion->setProcesado(false);
        $pagoNotificacion->setId( $idPedido );
        $pagoNotificacion->save();
      }

      $url = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_ResultadoOperacion_' . $resultado, 'idPedido' => $idPedido ), true );      
      header( 'Location: ' . $url);
      exit;
      
  }
  
  /**
   * Executes respuestaNPS action
   *
   * @param sfRequest $request A request object
   */
  public function executeRetornoNPS(sfWebRequest $request)
  {
      $idTransaccionNPS = $request->getParameter('psp_TransactionId');

      $idPedido = null;

      if ( $idTransaccionNPS ) {
        
        // Obtengo la info de NPS
        $response = PagoProvider::getInstance( formaPago::NPS )->consultar($idTransaccionNPS);
        
        $idPedido = $response->psp_Transaction->psp_MerchOrderId;
        
        $response = PagoProvider::getInstance( formaPago::NPS )->makeResponse( (array) $response->psp_Transaction );        
      }
            
      // Anoto la respuesta para luego procesarla en batch
      if ( $idPedido )
      {
          $pagoNotificacion = new pagoNotificacion();
          $pagoNotificacion->setIdFormaPago(formaPago::NPS);
          $pagoNotificacion->setMetodo(pagoNotificacion::RETORNO);
          $pagoNotificacion->setIdPedido( $idPedido );
          $pagoNotificacion->setResponse( json_encode($response) );
          $pagoNotificacion->setProcesado(false);
          $pagoNotificacion->setId($response['id_transaccion']);
          $pagoNotificacion->save();
          
          if( $response['codigo_respuesta'] == 0 )
          {
              $url = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_ResultadoOperacion_correcto', 'idPedido' => $idPedido ), true );
          }
          else
          {
              $url = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_ResultadoOperacion_fallo', 'idPedido' => $idPedido ), true );
          }      
      }
      else
      {
          $url = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_ResultadoOperacion_fallo', 'idPedido' => 0 ), true );
      }
      
      header( 'Location: ' . $url);
      exit;
  }
  
  
 /**
  * Executes resultadoOperacion action
  *
  * @param sfRequest $request A request object
  */
  public function executeResultadoOperacion(sfWebRequest $request)
  {
    $eshop = eshopTable::getInstance()->getCurrent();
    $this->eshop = $eshop;
        
    $idPedido = $request->getParameter('idPedido');
    $this->pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);

    $resultado = $request->getParameter('resultado');
  	  	
  	$this->setTemplate( 'resultado' . ucfirst($resultado) );
  }
  
 /**
  * Executes bajaRecordatorioOffline action
  *
  * @param sfRequest $request A request object
  */
  public function executeBajaRecordatorioOffline(sfWebRequest $request)
  {
  	$hash = $request->getParameter('hash');
  	$avisoPedido = avisoPedidoTable::getInstance()->getByHash( $hash );
  	
  	$this->pedido = $avisoPedido->getPedido();
  	$this->hash = $hash;

  }
  
 /**
  * Executes bajaRecordatorioOfflineOk action
  *
  * @param sfRequest $request A request object
  */
  public function executeBajaRecordatorioOfflineOk(sfWebRequest $request)
  {
  	$hash = $request->getParameter('hash');
  	$avisoPedido = avisoPedidoTable::getInstance()->getByHash( $hash );
  	$pedido = $avisoPedido->getPedido();
  	
  	$observacion = 'Baja del Pedido #' . $pedido->getIdPedido() . ', por eleccion del usuario al recibir el recordatorio de pago.';
  	$pedido->procesarBaja( $observacion );
  }

  /**
   * Executes respuestaDecidir action
   *
   * @param sfRequest $request A request object
   */
  public function executeRespuestaDecidir(sfWebRequest $request)
  {      
      // Obtengo la info de Decidir
      $response = PagoProvider::getInstance( formaPago::DECIDIR )->makeResponse( $_POST );
      $idPedido = $response['nroOperacion'];
      
      // Anoto la respuesta para luego procesarla en batch
      $pagoNotificacion = new pagoNotificacion();
      $pagoNotificacion->setIdFormaPago(formaPago::DECIDIR);
      $pagoNotificacion->setMetodo(pagoNotificacion::RETORNO);
      $pagoNotificacion->setIdPedido( $idPedido );
      $pagoNotificacion->setResponse( json_encode($response) );
      $pagoNotificacion->setProcesado(false);
      $pagoNotificacion->setId( $response['nroOperacion'] );
      $pagoNotificacion->save();

      header('HTTP/1.0 200 OK');
      exit;
  }
  
}