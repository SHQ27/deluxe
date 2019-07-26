<?php

/**
 *
 * @package    deluxebuys
 * @subpackage carrito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class abstractCarritoActions extends deluxebuysActions
{ 
    
    /**
     * Executes paso1 action
     *
     * @param sfRequest $request A request object
     */
    protected function createPaso1($request)
    {
        $session = sessionTable::getInstance()->getSession();
        $this->carritoProductoItems = carritoProductoItemTable::getInstance()->listByIdSession( $session->getIdSession() );
    
        $this->tieneOfertas = sessionTable::getInstance()->hayOfertas( $session->getIdSession() );
         
        $this->dataMezcla = carritoProductoItemTable::getInstance()->verificarMezcla( $session->getIdSession() );
    }
    

    
    protected function createPaso2($request)
    {
        // Obtengo la session del usuario
        $usuario = $this->getUser()->getCurrentUser();
        $session = sessionTable::getInstance()->getSession();
        
        // Obtengo las provincias
        $provincias = provinciaTable::getInstance()->listAll();

        // Si no tiene productos cargados debe volver al paso 1
        $carritoProductoItems = carritoProductoItemTable::getInstance()->listByIdSession( $session->getIdSession() );
        if (!count($carritoProductoItems)) $this->redirect('@carrito');
         
        // Obtengo los productosItem en el carrito
        $pesoTotalCarrito = carritoProductoItemTable::getInstance()->getPesoByIdSesion( $session->getIdSession() );
    
        // Preparo el array con la informacion de envio en el carrito
        $this->carritoEnvio = carritoEnvioTable::getInstance()->getByIdSession( $session->getIdSession() );
         
        $arrayCarritoEnvio = ($this->carritoEnvio)? $this->carritoEnvio->convertToArray() : array();
    
        // Preparo el array con la informacion de envio por default asociada al usuario en mi cuenta
        $direccionEnvioDefault = $usuario->getDireccionEnvioDefault();
        $arrayDireccionEnvioDefault = $direccionEnvioDefault->convertToArray();
         

        // Seteo de variables en el template
        $this->carritoProductoItems = $carritoProductoItems;
        $this->arrayCarritoEnvio = ($arrayCarritoEnvio)? json_encode($arrayCarritoEnvio) : 'false';
        $this->arrayDireccionEnvioDefault = ($arrayDireccionEnvioDefault)? json_encode($arrayDireccionEnvioDefault) : 'false';
        $this->pesoTotalCarrito = $pesoTotalCarrito;
        $this->tipoEnvio = ( isset( $arrayCarritoEnvio['tipo'] ) ) ? $arrayCarritoEnvio['tipo'] : null;
        $this->usuario = $usuario;
        $this->provincias = $provincias;
        
         
        $this->tieneOfertas = sessionTable::getInstance()->hayOfertas( $session->getIdSession() );    
         
        $campana = campanaTable::getInstance()->getCampanaEnCarrito( $session->getIdSession() );
        $this->idCampana = ( $campana ) ? $campana->getIdCampana() : "0";
    }
    
    /**
     * Executes savePaso2 action
     *
     * @param sfRequest $request A request object
     */
    public function executeSavePaso2(sfWebRequest $request)
    {
          $eshop = eshopTable::getInstance()->getCurrent();
          $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

          $session = sessionTable::getInstance()->getSession();
          carritoEnvioTable::getInstance()->deleteAllByIdSession( $session->getIdSession() );
    
          $tipoEnvio = $request->getParameter('tipoEnvio');
          $nombre = $request->getParameter('nombre');
          $apellido = $request->getParameter('apellido');
          $codigoPostal = $request->getParameter('codigoPostal');
          $calle = $request->getParameter('calle');
          $numero = $request->getParameter('numero');
          $piso = $request->getParameter('piso');
          $depto = $request->getParameter('depto');
          $idLocalidad = $request->getParameter('idLocalidad');
          $localidad = $request->getParameter('localidad');
          $idProvincia = $request->getParameter('idProvincia');
          $cotizacion = $request->getParameter('cotizacion');
        

          // Validacion
          $isError = (!$nombre || !$apellido || !$idProvincia || !$cotizacion);

          if ($tipoEnvio == carritoEnvio::SUCURSAL )
          {
              if ( !$idLocalidad ) $isError = true;
          }
          else
          {
              if (!$calle || !$numero || !$localidad || !$codigoPostal ) $isError = true;
                
              if (!is_numeric($numero) || strlen($numero) > 5)
              {
                  echo json_encode(array('status'=>'KO', 'message' => 'El número debe ser un dato numérico'));
                  return sfView::NONE;
              }
                
              if ( !codigoPostalTable::getInstance()->exists($codigoPostal) )
              {
                  echo json_encode(array('status'=>'KO', 'message' => 'El codigo postal debe existir y ser un valor de 4 digitos'));
                  return sfView::NONE;
              }
              else if ( !cpValidatorHelper::getInstance()->validate($idProvincia, $codigoPostal) )
              {
                  echo json_encode(array('status'=>'KO', 'message' => 'El codigo postal no pertenece a la provincia seleccionada'));
                  return sfView::NONE;
              } 
          }
    
          if ($isError)
          {
              echo json_encode(array('status'=>'KO', 'message' => 'Quedan datos sin completar'));
              return sfView::NONE;
          }
    
          $this->carritoEnvio = new carritoEnvio();
    
          $this->carritoEnvio->setIdSession( $session->getIdSession() );
          $this->carritoEnvio->setTipo( $tipoEnvio );
    
          $envioPackData['tipo']         = $tipoEnvio;
          $envioPackData['nombre']       = $nombre;
          $envioPackData['apellido']     = $apellido;
          $envioPackData['idProvincia']  = $idProvincia;
          $envioPackData['cotizacion']   = $cotizacion;


          if ($tipoEnvio == carritoEnvio::SUCURSAL )
          {
              $envioPackData['idLocalidad'] = $idLocalidad;

              $cotizacion = explode('_', $cotizacion);
              $envioPackData['correo']    = $cotizacion[0];
              $envioPackData['servicio']    = $cotizacion[1];
              $envioPackData['idSucursal']  = $cotizacion[2];
          }
          else
          {
              $envioPackData['calle']        = $calle;
              $envioPackData['numero']       = $numero;
              $envioPackData['piso']         = $piso;
              $envioPackData['depto']        = $depto;
              $envioPackData['codigoPostal'] = $codigoPostal;
              $envioPackData['localidad']    = $localidad;
              $envioPackData['servicio']     = $cotizacion;

              $peso = carritoProductoItemTable::getInstance()->getPesoByIdSesion( $session->getIdSession() );


              if ( $idEshop ) {

                $idCorreo = EnvioPack::getInstance( $idEshop )->reglaCorreoESHOPS(
                  $codigoPostal,
                  $peso,
                  $envioPackData['servicio'],
                  $idEshop
                );                

              } else {

                $idCorreo = EnvioPack::getInstance( $idEshop )->reglaCorreoDELUXE(
                  $codigoPostal,
                  $peso,
                  $envioPackData['servicio']
                );

              }

              $envioPackData['correo']       = $idCorreo;
                
              // Guardo la direccion como direccion asignada al usuario
              $usuario = sfContext::getInstance()->getUser()->getCurrentUser();
                
              $direccionEnvio = $usuario->getDireccionEnvioDefault();
              $direccionEnvio->setIdUsuario( $usuario->getIdUsuario() );
              $direccionEnvio->setLocalidad( $localidad );
              $direccionEnvio->setIdProvincia( $idProvincia );
              $direccionEnvio->setCalle( $calle );
              $direccionEnvio->setNumero( $numero );
              $direccionEnvio->setPiso( $piso );
              $direccionEnvio->setDepto( $depto );
              $direccionEnvio->setCodigoPostal( $codigoPostal );
              $direccionEnvio->save();
                
          }

          $this->carritoEnvio->setEnviopackData( json_encode( $envioPackData ) );
          $this->carritoEnvio->save();
    
          echo json_encode(array('status'=>'OK'));
          return sfView::NONE;
    }
    
    protected function createPaso3($request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

        $this->chargeCartData($request);
         
        // Alerta por categorias sin devolucion
        if ( $eshop ) {
            $devolucionRestringidaData     = $eshop->getDevolucionRestringidaData();
            $idCategoriasRestringidas      = $devolucionRestringidaData['ids'];
            $mensajeCategoriasRestringidas = $devolucionRestringidaData['mensaje'];
        } else {
            $idCategoriasRestringidas      = json_decode( sfConfig::get('app_categoriaDevolucionRestringida_ids'), true);
            $mensajeCategoriasRestringidas = sfConfig::get('app_categoriaDevolucionRestringida_mensaje');
        }

        $mostrarAlertaRopaInterior = false;
        foreach ($this->carritoProductoItems as $carritoProductoItem)
        {
            $idCategoria = $carritoProductoItem->getProductoItem()->getProducto()->getIdProductoCategoria();             
            if ( in_array( $idCategoria , $idCategoriasRestringidas) )
            {
                $mostrarAlertaRopaInterior = true;
                break;
            }
        }
        
        $this->mensajeCategoriasRestringidas = $mensajeCategoriasRestringidas;
        $this->mostrarAlertaRopaInterior     = $mostrarAlertaRopaInterior;
         
        $usuario = $this->getUser()->getCurrentUser();
         
        // Promociones de Pago
        $test = $request->getParameter('test', false);

        if ( $test ) {
          $promosPago = promoPagoTable::getInstance()->listAll( $idEshop );
        } else {
          $promosPago = promoPagoTable::getInstance()->listVigentes( $idEshop );
        }
        
        $this->promosPago = $promosPago;


        // Obtengo el form y si hay post lo ejecuto
        $form = new CarritoPaso3Form( array('tipoDocumento' => $usuario->getTipoDocumento() , 'documento' => $usuario->getDocumento() ) );
         
        $havePost = $request->isMethod('post');
    
        if ( $havePost )
        {
            $params = $request->getParameter($form->getName());
             
            $form->bind( $params );
    
            if ( $form->isValid() )
            {
                 
                $cuotas = ( isset( $params['cuotas'][ $params['tipoPago'] ] ) ) ? $params['cuotas'][ $params['tipoPago'] ] : 1;
                 
                $form->save();
                $this->redirect( $this->getController()->genUrl(array('sf_route' => 'carrito_generar_pedido', 'tipoPago' => $params['tipoPago'], 'cuotas' => $cuotas), false ) );
            }
        }
    
        $this->form = $form;
        $this->eshop = eshopTable::getInstance()->getCurrent();
        $this->codigoDescuentoDefault = $this->getContext()->getRequest()->getCookie('codigo_descuento');

        // Se elimina la cookie
        $this->getContext()->getResponse()->setCookie('codigo_descuento', '', time() - 3600);
    }
    
    /**
     * Executes addProduct action
     *
     * @param sfRequest $request A request object
     */
    public function executeAddProduct(sfWebRequest $request)
    {
        $idProducto = $request->getParameter('idProducto');
        $idProductoTalle = $request->getParameter('idProductoTalle');
        $idProductoColor = $request->getParameter('idProductoColor');
        $cantidad = $request->getParameter('cantidad');
         
        $productoItem = productoItemTable::getInstance()->getByCompoundKey(
            $idProducto,
            $idProductoTalle,
            $idProductoColor
        );
    
         
        $session = sessionTable::getInstance()->getSession();
        $mostrarCartelMezcla = carritoProductoItemTable::getInstance()->mostrarCartelMezcla( $session->getIdSession(), $productoItem->getProducto() );
         
        if ( $mostrarCartelMezcla )
        {
            echo json_encode( array ( 'status' => 'KO', 'message' => 'MEZCLA' ));
            return sfView::NONE;
        }
         
        $stockDisponible = $productoItem->getCurrentStock();
    
        if ( $stockDisponible >= $cantidad )
        {
            $carritoProductoItem = carritoProductoItemTable::getInstance()->addProductoItem(  $productoItem, $cantidad  );
    
            $urlCarrito = $this->getController()->genUrl(array('sf_route' => 'carrito'), false );
            echo json_encode( array ( 'status' => 'OK', 'urlCarrito' => $urlCarrito ));
        }
        else
        {
            echo json_encode( array (
                'status' => 'KO',
                'message' => 'No hay stock disponible para comprar ' . $cantidad . ' unidades.'
            ));
        }
         
        return sfView::NONE;
    }
    
    
    /**
     * Executes update action
     *
     * @param sfRequest $request A request object
     */
    public function executeUpdate(sfWebRequest $request)
    {
        $idCarritoProductoItem = $request->getParameter('idCarritoProductoItem');
        $cantidad = $request->getParameter('cantidad');
         
        $carritoProductoItem = carritoProductoItemTable::getInstance()->getByIdCarritoProductoItem( $idCarritoProductoItem );
         
        $stockDisponible = $carritoProductoItem->getProductoItem()->getMyCurrentStock();
        if ( $stockDisponible >= $cantidad )
        {
            $carritoProductoItem->setCantidad( $cantidad );
            echo json_encode( array ( 'status' => 'OK', 'subTotal' => formatHelper::getInstance()->decimalNumber( $carritoProductoItem->getSubTotal(), 'c','' ) ));
        }
        else
        {
            $carritoProductoItem->setCantidad( $stockDisponible );
            echo json_encode( array (
                'status' => 'KO',
                'subTotal' => formatHelper::getInstance()->decimalNumber( $carritoProductoItem->getSubTotal(), 'c','' ),
                'stockDisponible' => $stockDisponible,
                'message' => 'No hay stock disponible para comprar ' . $cantidad . ' unidades.'
            ));
        }
         
        $carritoProductoItem->save();
         
        return sfView::NONE;
    }
    
    /**
     * Executes removeProducto action
     *
     * @param sfRequest $request A request object
     */
    public function executeRemoveProducto(sfWebRequest $request)
    {
        $idCarritoProductoItem = $request->getParameter('idCarritoProductoItem');
         
        $carritoProductoItem = carritoProductoItemTable::getInstance()->getByIdCarritoProductoItem( $idCarritoProductoItem );
        
        if ( $carritoProductoItem ) {
            $carritoProductoItem->delete();
        }
        return sfView::NONE;
    }
    
    
    
    /**
     * Executes addDescuento action
     *
     * @param sfRequest $request A request object
     */
    public function executeAddDescuento(sfWebRequest $request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $codigo = $request->getParameter('codigo');
        $infoAdicional = $request->getParameter('infoAdicional');
         
        $session = sessionTable::getInstance()->getSession();
        carritoDescuentoTable::getInstance()->deleteAllByIdSession( $session->getIdSession() );
        carritoBonificacionTable::getInstance()->deleteAllByIdSession( $session->getIdSession() );
         
        $descuento = descuentoTable::getInstance()->getAvailableByCodigo($codigo, $idEshop);
         
        if ($descuento)
        {
            $this->carritoDescuento = new carritoDescuento();
            $this->carritoDescuento->setIdDescuento( $descuento->getIdDescuento() );
            $this->carritoDescuento->setIdSession( $session->getIdSession() );
            $this->carritoDescuento->setInfoAdicional($infoAdicional);
            $this->carritoDescuento->save();
    
            $descuento->utilizar();
    
            echo json_encode( array ( 'status' => 'OK', 'monto' => $this->carritoDescuento->getMonto(true) ) );
        }
        else
        {
            echo json_encode( array ( 'status' => 'KO' ));
        }
         
        return sfView::NONE;
    }
    
    /**
     * Executes addBonificacion action
     *
     * @param sfRequest $request A request object
     */
    public function executeAddBonificacion(sfWebRequest $request)
    {
        $idBonificacion = $request->getParameter('idBonificacion');
         
        $usuario = sfContext::getInstance()->getUser()->getCurrentUser();
    
        if (!$usuario)
        {
            echo json_encode( array ( 'status' => 'KO' ));
            return sfView::NONE;
        }
          
        $bonificacion = bonificacionTable::getInstance()->getBonification($usuario->getIdUsuario(), $idBonificacion);
         
        $session = sessionTable::getInstance()->getSession();
        carritoBonificacionTable::getInstance()->deleteAllByIdSession( $session->getIdSession() );
        carritoDescuentoTable::getInstance()->deleteAllByIdSession( $session->getIdSession() );
         
        if ($bonificacion)
        {
            $this->carritoBonificacion = new carritoBonificacion();
            $this->carritoBonificacion->setIdBonificacion( $bonificacion->getIdBonificacion() );
            $this->carritoBonificacion->setIdSession( $session->getIdSession() );
            $this->carritoBonificacion->save();
    
            echo json_encode( array ( 'status' => 'OK', 'monto' => $this->carritoBonificacion->getMonto(true) ) );
        }
        else
        {
            echo json_encode( array ( 'status' => 'KO' ));
        }
         
        return sfView::NONE;
    }
    
    
    protected  function chargeCartData(sfWebRequest $request)
    {
        // Obtengo la session y los datos del usuario
        $this->session = sessionTable::getInstance()->getSession();
        $this->currentUser = $this->getUser()->getCurrentUser();
         
        // Si no tiene productos cargados debe volver al paso 1
        $carritoProductoItem = carritoProductoItemTable::getInstance()->listByIdSession( $this->session->getIdSession() );
        if (!count($carritoProductoItem))
        {
            $this->redirect('@carrito');
            exit;
        }

        // Si no tiene direccion de envio definida en el paso 2 se redirige al mismo.
        $this->carritoEnvio = carritoEnvioTable::getInstance()->getByIdSession( $this->session->getIdSession() );
        if (!$this->carritoEnvio)
        {
            $this->redirect('@carrito_paso_2');
            exit;
        }
          
        // Obtengo los productosItem en el carrito
        $this->carritoProductoItems = carritoProductoItemTable::getInstance()->listByIdSession( $this->session->getIdSession() );
    
        // Obtengo el costo de envio
        $this->carritoEnvio = carritoEnvioTable::getInstance()->getByIdSession( $this->session->getIdSession() );
        $this->costoEnvio = $this->carritoEnvio->getCosto( false );
        $this->costoEnvioDeluxe = $this->carritoEnvio->getCostoDeluxe( false );

        if ( $this->costoEnvioDeluxe == 0 ) {
          $this->costoEnvioDeluxe = $this->costoEnvio;
        }
    
        // Obtengo las bonificaciones y descuentos
        $this->bonificaciones = bonificacionTable::getInstance()->vigentesByIdUsuario( $this->currentUser->getIdUsuario() );
        $this->carritoDescuento = carritoDescuentoTable::getInstance()->getByIdSession( $this->session->getIdSession() );
        $this->carritoBonificacion = carritoBonificacionTable::getInstance()->getByIdSession( $this->session->getIdSession() );
    
        // Obtengo el monto de los productos
        $this->montoProductos = sessionTable::getInstance()->getMontoProductos( $this->session->getIdSession() );
    
        // Obtengo el monto de los descuentos y bonificaciones
        $this->montoBonificacion = ($this->carritoBonificacion)? $this->carritoBonificacion->getMonto(true) : 0;
        $this->montoDescuento = ($this->carritoDescuento)? $this->carritoDescuento->getMonto( true ) : 0;
    }
    
    protected function createGenerarPedido($request)
    {
        $eshop = eshopTable::getInstance()->getCurrent();
        $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
        
        $tipoPago = $request->getParameter('tipoPago');
        $cuotas = $request->getParameter('cuotas');

        if ( $tipoPago == 'MP' || $tipoPago == 'MPA' ) {
          // Pago via Mercado Pago
          $params = array();
          $idFormaPago = formaPago::MERCADOPAGO;
          $proveedorPago = null;
          $cuotas = 1;
          $remplazarDescuento = false;
        } else {
          // Pago via promocion de NPS o Decidir
          $promoPago = promoPagoTable::getInstance()->getById( $tipoPago );

          $cuotasDisponibles = explode(',', $promoPago->getCuotas());

          if ( count( $cuotasDisponibles ) == 1 ) {
            $cuotas = $cuotasDisponibles[0];
          }

          if ( !$promoPago->esValida( $idEshop, $cuotas ) ) {
            echo 'Eligió una oferta de pago no válida';
            exit;
          }

          // Codigo agregado temporalemente para la promo Ahora 12 de Naima
          if ( $promoPago->getIdPromoPago() == 113 ) {
            $cuotas = 7;
          }

          $params = $promoPago->getParams();
          $params = json_decode($params, true);

          $idFormaPago = $promoPago->getIdFormaPago();
          $proveedorPago = $promoPago->getProveedor();
          $remplazarDescuento = $promoPago->getIdDescuento();
        }

        /*
         * Si la promo tiene descuento se eliminan los descuentos
        * Y si el descuento de la promo lo maneja Deluxe $remplazarDescuento tiene un idDescuento
        * que debe aplicarse en el pedido.
        */
        if ( $remplazarDescuento )
        {
            $session = sessionTable::getInstance()->getSession();
              
            carritoDescuentoTable::getInstance()->clearAllByIdSession( $session->getIdSession() );
    
            if ( $remplazarDescuento !== true ) {
                $idDescuento = $remplazarDescuento;
                  
                $descuento = descuentoTable::getInstance()->findOneByIdDescuento( $idDescuento );
    
                $this->carritoDescuento = new carritoDescuento();
                $this->carritoDescuento->setIdDescuento( $descuento->getIdDescuento() );
                $this->carritoDescuento->setIdSession( $session->getIdSession() );
                $this->carritoDescuento->save();
            }
    
        }
         
        $this->chargeCartData($request);
         
        $conn = Doctrine_Manager::connection();
    
        try
        {
            $conn->beginTransaction();
             
            // Guardo el pedido
            $pedido = new pedido();
            $pedido->setIdEshop( $idEshop );
            $pedido->setIdUsuario( $this->currentUser->getIdUsuario() );
            $pedido->setIdFormaPago( $idFormaPago );
            $pedido->setNombre( $this->currentUser->getNombre() );
            $pedido->setApellido( $this->currentUser->getApellido() );
            $pedido->setTipoDocumento( $this->currentUser->getTipoDocumento() );
            $pedido->setDocumento( $this->currentUser->getDocumento() );
            $pedido->setEmail( $this->currentUser->getEmail() );
            $pedido->setTelefono( $this->currentUser->getTelefono() );
            $pedido->setCelular( $this->currentUser->getCelular() );
            $pedido->setObservaciones('');
  
            $envioPackData = json_decode( $this->carritoEnvio->getEnviopackData(), true );
            $pedido->setEnvioTipo(  $envioPackData['tipo'] );
            $pedido->setEnvioDestinatario( $envioPackData['nombre'] . ' ' . $envioPackData['apellido'] );
            
            if ( $envioPackData['tipo'] == carritoEnvio::SUCURSAL )
            {
                $pedido->setEnvioIdSucursal( $envioPackData['idSucursal'] );
            }
            else
            {
                $pedido->setEnvioCalle( $envioPackData['calle'] );
                $pedido->setEnvioNumero( $envioPackData['numero'] );
                $pedido->setEnvioPiso( $envioPackData['piso'] );
                $pedido->setEnvioDepto( $envioPackData['depto'] );
                $pedido->setEnvioCodigoPostal( $envioPackData['codigoPostal'] );
                $pedido->setEnvioLocalidad( $envioPackData['localidad'] );
            }

            $pedido->setEnvioCorreo( $envioPackData['correo'] );
            $pedido->setEnvioIdProvincia( $envioPackData['idProvincia'] );
            $pedido->setEnvioServicio( $envioPackData['servicio'] );

            $pedido->updateEnvioDetalle();
    
            $pedido->setCuotas( $cuotas );
    
            $pedido->setMontoEnvio( $this->costoEnvio );
            $pedido->setMontoEnvioDeluxe( $this->costoEnvioDeluxe );
    
            $pedido->setMontoProductos( $this->montoProductos );
            $pedido->setMontoBonificacion( $this->montoBonificacion );
            $pedido->setMontoDescuento( $this->montoDescuento );

              $data = $this->getContext()->getRequest()->getCookie(usuario::USER_SOURCE);
  
              if ( $data !== null )
              {
                  $data = json_decode( base64_decode( $data ), true );
  
                  $pedido->setSource( $data['source'] );
                  $pedido->setFechaSource( $data['fecha'] );
                  $pedido->setUtmCampaign( $data['utmCampaign'] );
                  $pedido->setUtmTerm( $data['utmTerm'] );
              }
            
            $pedido->save();
    
            // Guardo los productoItems del pedido
            foreach ($this->carritoProductoItems as $carritoProductoItem)
            {
                $productoItem = $carritoProductoItem->getProductoItem();
                $producto = $productoItem->getProducto();
                                    
                $pedidoProductoItem = new pedidoProductoItem();
                $pedidoProductoItem->setIdPedido( $pedido->getIdPedido() );
                $pedidoProductoItem->setIdProductoItem( $productoItem->getIdProductoItem() );
                $pedidoProductoItem->setCantidad( $carritoProductoItem->getCantidad() );
                $pedidoProductoItem->setPrecioLista( $producto->getPrecioLista() );
                $pedidoProductoItem->setPrecioDeluxe( $producto->getPrecioDeluxe() );
                $pedidoProductoItem->setCosto( !$producto->getEsOutlet() ? $producto->getCosto() : 0 );
                $pedidoProductoItem->setIdProductoTalle( $productoItem->getIdProductoTalle() );
                $pedidoProductoItem->setIdProductoColor( $productoItem->getIdProductoColor() );
                $pedidoProductoItem->setOrigen( $producto->getOrigen() );
                $pedidoProductoItem->addProductoItem();

                $productoItem->restaStock( $carritoProductoItem->getCantidad(), $producto->getOrigen(), stockTipo::SISTEMA_VENTA, $pedidoProductoItem->getIdPedidoProductoItem(), 'Pedido #' . $pedido->getIdPedido()  );
                  
                $listProductoCampana = productoCampanaTable::getInstance()->listActivasByIdProducto( $producto->getIdProducto() );
                foreach ($listProductoCampana as $productoCampana)
                {
                    $pedidoProductoItemCampana = new pedidoProductoItemCampana();
                    $pedidoProductoItemCampana->setIdPedidoProductoItem( $pedidoProductoItem->getIdPedidoProductoItem() );
                    $pedidoProductoItemCampana->setIdCampana( $productoCampana->getIdCampana() );
                    $pedidoProductoItemCampana->setIdMarca( $producto->getIdMarca() );
                    $pedidoProductoItemCampana->save();
                }
            }
    
            // Si existe, guardo el descuento del pedido
            if ($this->carritoDescuento)
            {
                $descuento = $this->carritoDescuento->getDescuento();
                $pedidoDescuento = new pedidoDescuento();
                $pedidoDescuento->setIdPedido( $pedido->getIdPedido() );
                $pedidoDescuento->setIdDescuento( $descuento->getIdDescuento() );
                $pedidoDescuento->setIdTipoDescuento( $descuento->getIdTipoDescuento() );
                $pedidoDescuento->setValor( $descuento->getValor() );
                $pedidoDescuento->setMonto( $this->carritoDescuento->getMonto( true ) );
                $pedidoDescuento->setInfoAdicional( $this->carritoDescuento->getInfoAdicional() );
                $pedidoDescuento->save();
            }
    
            // Si existe, guardo la bonificacion del pedido
            $bonificacion = null;
            if ($this->carritoBonificacion)
            {
                $bonificacion = $this->carritoBonificacion->getBonificacion();
                  
                $montoBonificacionLimitada = $this->carritoBonificacion->getMonto(true);
                $montoBonificacion = $this->carritoBonificacion->getMonto(false);
                  
                $pedidoBonificacion = new pedidoBonificacion();
                $pedidoBonificacion->setIdPedido( $pedido->getIdPedido() );
                $pedidoBonificacion->setIdBonificacion( $bonificacion->getIdBonificacion() );
                $pedidoBonificacion->setIdTipoDescuento( $bonificacion->getIdTipoDescuento() );
                $pedidoBonificacion->setValor( $montoBonificacionLimitada );
                $pedidoBonificacion->setMonto( $montoBonificacionLimitada );
                $pedidoBonificacion->save();
                  
                if ($montoBonificacion > $montoBonificacionLimitada && $bonificacion->getIdTipoDescuento() == tipoDescuento::MONTOFIJO)
                {
                    $bonificacion->setValor( $montoBonificacionLimitada );
                    $bonificacion->save();
    
                    $nuevaBonificacion = new bonificacion();
                    $nuevaBonificacion->setIdUsuario( $this->currentUser->getIdUsuario() );
                    $nuevaBonificacion->setIdTipoDescuento( tipoDescuento::MONTOFIJO );
                    $nuevaBonificacion->setIdTipoBonificacion( $bonificacion->getIdTipoBonificacion() );
                    $nuevaBonificacion->setValor( $montoBonificacion - $montoBonificacionLimitada );
                    $nuevaBonificacion->setFueUtilizada( false );
                    $nuevaBonificacion->setVencimiento( $bonificacion->getVencimiento() );
                    $nuevaBonificacion->save();
                }
                  
                $bonificacion->utilizar();
            }
    
            $pedido->updateTipoPedido();
    
    
            $pedido->setMontoTotal( $this->montoProductos + $this->costoEnvio - $this->montoBonificacion - $this->montoDescuento );
    
            /*
             * Se calcula el monto total a facturarse.
             * Las bonificaciones por reintegro no se restan del total facturable, el resto si.
             */
            if ( $bonificacion && $bonificacion->getIdTipoBonificacion() == tipoBonificacion::REINTEGRO )
            {
                $pedido->setMontoFacturacion( $this->montoProductos + $this->costoEnvio - $this->montoDescuento );
            }
            else
            {
                $pedido->setMontoFacturacion( $pedido->getMontoTotal() );
            }
    
            $pedido->setFechaLimitePago( $pedido->getFechaLimiteExtendida() );
            $pedido->save();
    
            // Vacio el carrito
            carritoBonificacionTable::getInstance()->deleteAllByIdSession( $this->session->getIdSession() );
            carritoDescuentoTable::getInstance()->clearAllByIdSession( $this->session->getIdSession() );
            carritoEnvioTable::getInstance()->deleteAllByIdSession( $this->session->getIdSession() );
            carritoProductoItemTable::getInstance()->deleteAllByIdSession( $this->session->getIdSession() );
        
            $conn->commit();

            if ( $pedido->getMontoTotal() > 5 )
            {
              $pagoProvider = PagoProvider::getInstance( $pedido->getIdFormaPago() );
              $pagoProvider->doCheckout( $pedido, $proveedorPago, $params );
            }
            else
            {
                $pedido->procesarPago();
                $successURL = sfContext::getInstance()->getController()->genUrl(array('sf_route' => 'pedido_ResultadoOperacion_correcto', 'idPedido' => $pedido->getIdPedido() ), true );
                header( 'Location: ' . $successURL);
            }
            exit;
    
        }
        catch(Doctrine_Exception $e)
        {
            $conn->rollback();
            throw new Exception("Fallo al guardar el pedido");
        }
    
    }
      
}
