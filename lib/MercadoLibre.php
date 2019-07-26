<?php

class MercadoLibre
{
	static protected $instance;
	protected $api = array();
	protected $accessToken = array();
	
	CONST DEFAULT_LISTING_TYPE = 'gold_special';

    protected function __construct( ) { }
    
    protected function connect( $idEshop = null )
    {
        $idEshop = ( $idEshop ) ? $idEshop : 0;
        
        // Si ya existe la conexion no vuelvo a pedirla
        if ( isset($this->api[$idEshop]) && isset($this->accessToken[$idEshop]) ) {
            return;
        }
        
        if ( $idEshop ) {
            $eshop = eshopTable::getInstance()->findOneByIdEshop( $idEshop );
            $clientId = $eshop->getMlClientId();
            $clientSecret = $eshop->getMlClientSecret();
        } else {
            $clientId = sfConfig::get('app_ml_client_id');
            $clientSecret = sfConfig::get('app_ml_client_secret');
        }
    
        $data = http_build_query( array(
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials'
        ) );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.mercadolibre.com/oauth/token' );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($data)));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
    
        $this->accessToken[$idEshop] = (string) $response['access_token'];
    
        $api = new Meli( $clientId, $clientSecret, $response['access_token'], $response['refresh_token'] );
    
        $this->api[$idEshop] = $api;
    }

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new MercadoLibre();
		}

		return self::$instance;
	}

	public function getAPI( $idEshop = null )
	{
	    $idEshop = ( $idEshop ) ? $idEshop : 0;
	    
	    $this->connect($idEshop);
        return $this->api[$idEshop];
	}
	
	public function getAccessToken( $idEshop = null )
	{
	    $idEshop = ( $idEshop ) ? $idEshop : 0;
	    
	    $this->connect($idEshop);
	    return $this->accessToken[$idEshop];
	}
	
	public function procesarPago( $pagoNotificacion )
	{
		$proveedorPagoResponse = $pagoNotificacion->getResponseArray();

		// Obtengo los datos del eshop
		$idEshop = $proveedorPagoResponse['idEshop'];
		$eshop = eshopTable::getInstance()->getById( $idEshop );
		
		// Hago la consulta a la API de ML
		$api = MercadoLibre::getInstance()->getAPI( $idEshop );
		$accessToken = MercadoLibre::getInstance()->getAccessToken( $idEshop );
		
		$orderId = $proveedorPagoResponse['order_id'];
		$order = $api->get('/orders/' . $orderId, array('access_token' => $accessToken ));
		$order = $order['body'];
		 		
		// Obtengo la provincia
		$provincia = provinciaTable::getInstance()->findOneByIdMercadoLibre( $order->shipping->receiver_address->state->id );
		
		// Obtengo los datos del producto
		$orderItem = $order->order_items;
		$orderItem = $orderItem[0];
		
		$publicacionML = publicacionMlTable::getInstance()->findOneByItemId( $orderItem->item->id );
		
		$dataMercadoLibre =  json_decode( $publicacionML->getDataMercadoLibre(), true );
		$variationId = (string) $orderItem->item->variation_id;
		$idProductoItem = $dataMercadoLibre[ $variationId ];
		 
		$productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );
		 
		$cantidad = $orderItem->quantity;
		$producto = $productoItem->getProducto();
		 
		$montoProductos = $producto->getPrecioDeluxe() * $cantidad;
		
		$codigoPostal = $order->shipping->receiver_address->zip_code;
		 
		$pesoTotalCarrito = $producto->getPeso() * $cantidad;
		 
		$costoEnvio = $order->shipping->cost;
		$costoEnvioDeluxe =  EnvioPack::getInstance( $idEshop )->costoDeluxe( $codigoPostal, 'oca', $pesoTotalCarrito, carritoEnvio::DOMICILIO, 'N' );
		 		
		// Obtengo el usuario por default para compras por ML
		$idUsuario = ( $idEshop ) ? $eshop->getMlIdUsuarioInterno() : 124429;
		
		// Guardo el pedido
		$pedido = new pedido();
		$pedido->setIdUsuario( $idUsuario );
		$pedido->setIdFormaPago( formaPago::MERCADOLIBRE );
		$pedido->setNombre( $order->buyer->first_name );
		$pedido->setApellido( $order->buyer->last_name );
		
		$tipoDocumento = $order->buyer->billing_info->doc_type;
		$tipoDocumento = ( $tipoDocumento ) ? $tipoDocumento : null;
		$pedido->setTipoDocumento( $tipoDocumento );
		
		$documento = $order->buyer->billing_info->doc_number;
		$documento = ( $documento ) ? $documento : null;
		$pedido->setDocumento( $documento );
		
		$pedido->setEmail( $order->buyer->email );
		$pedido->setTelefono( $order->buyer->phone->area_code . ' ' . $order->buyer->phone->number );
		$pedido->setCelular( null );
		$pedido->setObservaciones('');
		 
		$pedido->setEnvioTipo( carritoEnvio::DOMICILIO );
		$pedido->setEnvioDestinatario( $order->buyer->first_name . ' ' . $order->buyer->last_name );
		$pedido->setEnvioCalle( $order->shipping->receiver_address->address_line . ' ' . $order->shipping->receiver_address->comment );
		$pedido->setEnvioNumero( '' );
		$pedido->setEnvioPiso( null );
		$pedido->setEnvioDepto( null );
		$pedido->setEnvioCodigoPostal( $codigoPostal );
		$pedido->setEnvioIdProvincia( $provincia->getIdProvincia() );
		$pedido->setEnvioLocalidad( $order->shipping->receiver_address->city->name );


        $pedido->setEnvioCorreo( 'oca' );
        $pedido->setEnvioServicio( 'N' );
		 
		$pedido->setCuotas( 1 );
		 
		$pedido->setMontoEnvio( $costoEnvio );
		$pedido->setMontoEnvioDeluxe( $costoEnvioDeluxe );
		 
		$pedido->setMontoProductos( $montoProductos );
		$pedido->setMontoBonificacion( 0 );
		$pedido->setMontoDescuento( 0 );
		
		if ( $idEshop ) {
		    $pedido->setIdEshop( $idEshop );
		}
		
		$pedido->save();
		 		 
		// Guardo el productoItems del pedido
		$pedidoProductoItem = new pedidoProductoItem();
		$pedidoProductoItem->setIdPedido( $pedido->getIdPedido() );
		$pedidoProductoItem->setIdProductoItem( $productoItem->getIdProductoItem() );
		$pedidoProductoItem->setCantidad( $cantidad );
		$pedidoProductoItem->setPrecioLista( $producto->getPrecioLista() );
		$pedidoProductoItem->setPrecioDeluxe( $producto->getPrecioDeluxe() );
		$pedidoProductoItem->setCosto( !$producto->getEsOutlet() ? $producto->getCosto() : 0 );
		$pedidoProductoItem->setIdProductoTalle( $productoItem->getIdProductoTalle() );
		$pedidoProductoItem->setIdProductoColor( $productoItem->getIdProductoColor() );
		$pedidoProductoItem->setOrigen( $producto->getOrigen() );
		$pedidoProductoItem->addProductoItem();

		// Resto el stock
		$productoItem->restaStock( $cantidad, $producto->getOrigen(), stockTipo::SISTEMA_VENTA, $pedidoProductoItem->getIdPedidoProductoItem(), 'Pedido #' . $pedido->getIdPedido()  );
		
		// Si pertenece a una campaña se anota
		$listProductoCampana = productoCampanaTable::getInstance()->listByIdProducto( $producto->getIdProducto() );
		foreach ($listProductoCampana as $productoCampana)
		{
			$pedidoProductoItemCampana = new pedidoProductoItemCampana();
			$pedidoProductoItemCampana->setIdPedidoProductoItem( $pedidoProductoItem->getIdPedidoProductoItem() );
			$pedidoProductoItemCampana->setIdCampana( $productoCampana->getIdCampana() );
			$pedidoProductoItemCampana->setIdMarca( $producto->getIdMarca() );
			$pedidoProductoItemCampana->save();
		}
		 
		$pedido->updateTipoPedido();
		 
		$pedido->setMontoTotal( $montoProductos + $costoEnvio );
		$pedido->setMontoFacturacion( $pedido->getMontoTotal() );
		$pedido->setFechaLimitePago( $pedido->getFechaLimiteExtendida() );
		 
		 
		$proveedorPagoResponse['total'] = $pedido->getMontoTotal();
		
		$pedido->procesarPago($proveedorPagoResponse);
		
		$pedido->setDatosPago( json_encode($proveedorPagoResponse) );
		 
		$pedido->save();
		 
		$pagoNotificacion->setIdPedido( $pedido->getIdPedido() );
		$pagoNotificacion->setResponse( json_encode($proveedorPagoResponse) );
		$pagoNotificacion->setProcesado(true);
		$pagoNotificacion->setMensaje('Pedido pagado desde Mercado Libre');
		$pagoNotificacion->setId( $orderId );
		$pagoNotificacion->save();
		 		
		return $proveedorPagoResponse;		 
	}
	
	public function publicar( $producto )
	{
	    $publicacionML = $producto->getPublicacionMl();
	    
	    // Se evita enviar productos que ya han estan publicados y vigentes
	    if ( $publicacionML->estaVigente() ) return false;
	    
	    // Si no es la primera publicacion se republica el item original
	    if (!$publicacionML->nuncaFuePublicado() )
	    {
	        return $this->republicar($producto);
	    }	    
	    
	    $result = array();
	    
	    $productoItems = $producto->getProductoItem();
	    $categoriaMl = $producto->getCategoriaMl();
	    
	    // Se evita enviar productos que pertenecen a un eshop el cual no tiene integracion con ML
	    $eshopsEnabled = sfConfig::get('app_ml_eshopsEnabled');
	    if ( $producto->getIdEshop() !== null && !in_array($producto->getIdEshop(), $eshopsEnabled ) ) return false;
	    
	    // Se evita enviar productos que no tienen categoria ML asignada
	    if ( !$producto->getIdCategoriaMl() ) return false;
	    	    
	    // Se evita enviar productos con variaciones a categorias que no permiten variaciones
	    if ( $categoriaMl->getAttributeTypes() != categoriaMl::ATTR_TYPE_VARIATIONS && count($productoItems) != 1 ) return false;
	    
	    // Armo el array de imagenes
	    $productoImagenes = $producto->getProductoImagen();
	    
	    $pictures = array();
	    foreach( $productoImagenes as $productoImagen )
	    {
	        $pictures[] = imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagen);
	    }
	     
	    // Armo el item
	    $marca = $producto->getMarca();
	    
	    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Text'));
	    $item = array(
	        "title" => truncate_text($producto->getDenominacion(), 45) . ' - ' . $marca->getNombre(),
	        "category_id" => $categoriaMl->getIdExterno(),
	        "price" => (float) $producto->getPrecioDeluxe(),
	        "currency_id" => "ARS",
	        "buying_mode" => "buy_it_now",
	        "listing_type_id" => self::DEFAULT_LISTING_TYPE,
	        "condition" => "new",
	        "description" => $producto->getDescripcionML(),
	        "shipping" => array(
	            "local_pick_up" => false,
	            "mode"  		=>  "me1",
	            "dimensions"  	=>  "10x10x20,700"
	        ) 
	    );
	    

	    if ( $producto->getIdEshop() ) {
	    	$officialStoreId = $producto->getEshop()->getMlIdOfficialStore();
	    } else {
	    	$officialStoreId = sfConfig::get('app_ml_officialStoreId');
	    }

	    
	    if ( $officialStoreId )
	    {
	       $item["official_store_id"] = $officialStoreId; 
	    }
	    
	    // Armo el array de variaciones
	    $variations = array();
	    
	    
	    $stockTotal = 0;
	    
	    if ( $categoriaMl->getAttributeTypes() == categoriaMl::ATTR_TYPE_VARIATIONS )
	    {
	        $item['seller_custom_field'] = $producto->getIdProducto();
	         
	        foreach( $productoItems as $productoItem )
	        {
	            if ( !$productoItem->getCurrentStock() ) {
	                continue;
	            }
	    
	            $dataMercadoLibre = $productoItem->getDataMercadoLibre();
	            $dataMercadoLibre = json_decode($dataMercadoLibre);
	            $dataMercadoLibre = ( count($dataMercadoLibre) ) ? $dataMercadoLibre : array();
	    
	            $attributes = array();
	            foreach( $dataMercadoLibre as $id => $valueId )
	            {
	                $attributes[] = array("id" => $id, "value_id" => $valueId);
	            }
	    
	            $stockTotal += $productoItem->getCurrentStock();
	    
	            $variations[] = array(
	                "attribute_combinations" => $attributes,
	                "available_quantity" => $productoItem->getCurrentStock(),
	                "price" => (float) $producto->getPrecioDeluxe(),
	                "seller_custom_field" => $productoItem->getIdProductoItem(),
	                "picture_ids" => $pictures
	            );
	        }
	    
	        if ( count($variations) )
	        {
	            $item["variations"] = $variations;
	        }
	    }
	    else
	    {
	        $productoItem = $productoItems->getFirst();
	    
	        $stockTotal += $productoItem->getCurrentStock();
	        $item['seller_custom_field'] = $productoItem->getIdProducto();
	        $item['available_quantity'] = $productoItem->getCurrentStock();
	    
	        foreach( $pictures as $picture )
	        {
	            $item['pictures'][] = array('source' => $picture);
	        }
	    }
	    
	    // Se evita enviar productos sin stock
	    if ($stockTotal <= 0) return false;
	    
	    // Hago el envio a ML
	    $api = MercadoLibre::getInstance()->getAPI( $producto->getIdEshop() );
	    $accessToken = MercadoLibre::getInstance()->getAccessToken( $producto->getIdEshop() );
	    
	    $response = $api->post('/items', $item, array('access_token' => $accessToken));
	    
	    $response = (array) $response['body'];
	    
	    $result['id'] = $producto->getIdProducto();
	    $result['denominacion'] = $producto->getDenominacion();
	     
	    if (!isset($response['id']))
	    {
	        $result['status_code'] = 'ko';
	        $result['status'] = 'Falló su publicación';
	        $result['status'] .= '<br /><br />';
	        $result['status'] .= 'Respuesta de Mercado Libre:';  
	        
	        foreach( $response as $key => $value )
	        {
	            $result['status'] .= '<br />';
	            
	            if (is_array($value))
	            {
	                $value = (array) $value[0];
	                $result['status'] .= $key . ':';
	                foreach( $value as $keyArray => $valueArray )
	                {
	                    $result['status'] .= '<br />';
	                    $result['status'] .= '&nbsp;&nbsp;&nbsp;' . $keyArray . ':' . $valueArray;
	                }
	            }
	            else
	            {
	                $result['status'] .= $key . ':' . $value;
	            }
	            
	            
	        }
	    }
	    else
	    {
	        $dataMercadoLibre = array();
	        foreach( $response['variations'] as $variation )
	        {
	            $variationId = (string) $variation->id;
	    
	            $attrs = array();
	            foreach( $variation->attribute_combinations as $attr )
	            {
	                $attrs[ $attr->id ] = $attr->value_id;
	            }
	    
	            ksort($attrs);
	    
	            $productoItem = productoItemTable::getInstance()->getByDataMercadoLibre($producto->getIdProducto(), json_encode( $attrs ));
	    
	            $dataMercadoLibre[ $variationId ] = $productoItem->getIdProductoItem();
	        }
	         
	        // Persisto la respuesta en nuestra base
	        $publicacionML->setItemId( $response['id'] );
	        $publicacionML->setFechaInicio( date('Y-m-d H:i:s', strtotime($response['start_time'])) );
	        $publicacionML->setFechaFin( date('Y-m-d H:i:s', strtotime($response['end_time'])) );
	        $publicacionML->setDataMercadoLibre( json_encode($dataMercadoLibre) );
	        $publicacionML->setStatusMl( publicacionMl::STATUS_ACTIVE );
	        $publicacionML->save();
	    
	        $result['status_code'] = 'ok';
	        $result['status'] = 'Se publicó correctamente';
	    }
	    
	    return $result;
	}
	
	public function republicar( $producto )
	{
	    $result = array();
	    
	    $publicacionML = $producto->getPublicacionMl();
	    $categoriaMl = $producto->getCategoriaMl();
	    
	    $dataMercadoLibre = json_decode( $publicacionML->getDataMercadoLibre(), true );
	    
	    $productoItems = $producto->getProductoItem();
	    
	    $accessToken = MercadoLibre::getInstance()->getAccessToken( $producto->getIdEshop() );
	    $api = MercadoLibre::getInstance()->getAPI( $producto->getIdEshop() );
	     	    
	    $params = array();
	    $params['listing_type_id'] = self::DEFAULT_LISTING_TYPE;
	    
	    
	    if ( count( $dataMercadoLibre ) )
	    {
	        $variations = array();
	    
	        foreach( $dataMercadoLibre as $variationId => $idProductoItem )
	        {
	            $variation = array();
	            $variation['id'] = doubleval($variationId);
	            $variation['price'] = (float) $producto->getPrecioDeluxe();
	    
	            $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );
	    
	            $currentStock = ( $productoItem->getCurrentStock() >= 0 )? $productoItem->getCurrentStock() : 0;
	            $variation['quantity'] = $currentStock;
	    
	            $variations[] = $variation;
	        }
	    
	        $params['variations'] = $variations;
	    }
	    else
	    {
	        $productoItem = $productoItems->getFirst();
	        $params['price'] = (float) $producto->getPrecioDeluxe();
	        $params['quantity'] = $productoItem->getCurrentStock();
	    }
	    	    
	    $response = $api->post('/items/' . $publicacionML->getItemId() . '/relist', $params, array('access_token' => $accessToken));
	    $response = (array) $response['body'];
	    	    
	    $result['id'] = $producto->getIdProducto();
	    $result['denominacion'] = $producto->getDenominacion();
	     
	    if (!isset($response['id']))
	    {
	        $result['status_code'] = 'ko';
	        $result['status'] = 'Falló su re-publicación (' . $response['message'] . ')';
	    }
	    else
	    {
	        $dataMercadoLibre = array();
	        foreach( $response['variations'] as $variation )
	        {
	            $variationId = (string) $variation->id;
	    
	            $attrs = array();
	            foreach( $variation->attribute_combinations as $attr )
	            {
	                $attrs[ $attr->id ] = $attr->value_id;
	            }
	    
	            ksort($attrs);
	    
	            $productoItem = productoItemTable::getInstance()->getByDataMercadoLibre($producto->getIdProducto(), json_encode( $attrs ));
	    
	            $dataMercadoLibre[ $variationId ] = $productoItem->getIdProductoItem();
	        }
	         
	        // Persisto la respuesta en nuestra base
	        $publicacionML = $producto->getPublicacionMl();
	        $publicacionML->setItemId( $response['id'] );
	        $publicacionML->setFechaInicio( date('Y-m-d H:i:s', strtotime($response['start_time'])) );
	        $publicacionML->setFechaFin( date('Y-m-d H:i:s', strtotime($response['end_time'])) );
	        $publicacionML->setDataMercadoLibre( json_encode($dataMercadoLibre) );
	        $publicacionML->setStatusMl( publicacionMl::STATUS_ACTIVE );
	        $publicacionML->save();
	    
	        $result['status_code'] = 'ok';
	        $result['status'] = 'Se publicó correctamente';
	    }
	    return $result;
	}
		
	
	public function actualizarProducto( $producto )
	{
	    $accessToken = MercadoLibre::getInstance()->getAccessToken( $producto->getIdEshop() );
	    $api = MercadoLibre::getInstance()->getAPI( $producto->getIdEshop() );
		
		$publicacionML = $producto->getPublicacionMl();
				
		if ( $publicacionML->nuncaFuePublicado() || !$publicacionML->estaVigente() ) {
			return;
		} 
		
		$dataMercadoLibre = json_decode( $publicacionML->getDataMercadoLibre(), true );
		
		$item = array();
				
		if ( count( $dataMercadoLibre ) )
		{
		    $variations = array();
		    
    		foreach( $dataMercadoLibre as $variationId => $idProductoItem )
    		{
    		    $variation = array();
    		    $variation['id'] = $variationId;
    		    $variation['price'] = (float) $producto->getPrecioDeluxe();
    		    
    		    $productoItem = productoItemTable::getInstance()->findOneByIdProductoItem( $idProductoItem );

    		    if ( !$productoItem ) { continue; }
    		        		    
    		    $currentStock = ( $productoItem->getCurrentStock() >= 0 )? $productoItem->getCurrentStock() : 0;
    		    $variation['available_quantity'] = $currentStock;
    		    
    		    $variations[] = $variation;
    		    
    		}

    		$item['variations'] = $variations;
		}
		else 
		{
		    $item['price'] = (float) $producto->getPrecioDeluxe();
		    
		    $productoItem = $producto->getProductoItem()->getFirst();
		    
		    $currentStock = ( $productoItem->getCurrentStock() >= 0 )? $productoItem->getCurrentStock() : 0;
		    $item['available_quantity'] = $currentStock;
		    		    
		} 
		
		$response = $api->put('/items/' . $publicacionML->getItemId(), $item, array('access_token' => $accessToken));		

		$ok = !is_int($response['body']->status);

		if ( !$ok ) {
			$subject = 'Fallo al actualizar producto en Mercado Libre';
			$body = json_encode($response['body']);
			$content  = 'El Producto '. $producto->getIdProducto() .' fallo al actualizarse en Mercado Libre.';
			$content .= '<br/><br/>Response:<br/><br/>';
			$content .= $body;			
			$this->sendNotificationEmail( $subject, $content);
		}

		return $ok;
	}
	
	
	public function actualizarDescripcion( $producto )
	{
	    $accessToken = MercadoLibre::getInstance()->getAccessToken( $producto->getIdEshop() );
	    $api = MercadoLibre::getInstance()->getAPI( $producto->getIdEshop() );
	
	    $publicacionML = $producto->getPublicacionMl();
	    
	    if ( $publicacionML->nuncaFuePublicado() || !$publicacionML->estaVigente() ) {
	        return;
	    }
	
	    $params = array('text' => $producto->getDescripcionML()); 
	    	    
	    $response = $api->put('/items/' . $publicacionML->getItemId(). '/description', $params, array('access_token' => $accessToken));

		$ok = !is_int($response['body']->status);

		if ( !$ok ) {
			$subject = 'Fallo al actualizar descripcion de producto en Mercado Libre';
			$body = json_encode($response['body']);
			$content = 'El Producto '. $producto->getIdProducto() .' fallo al actualizar su descripcion en Mercado Libre';
			$content .= '<br/><br/>Response:<br/><br/>';
			$content .= $body;			
			$this->sendNotificationEmail( $subject, $content);
		}

		return $ok;
	}
	
		
	
	public function cerrarPublicacion( $producto, $force = false )
	{
		$publicacionML = $producto->getPublicacionMl();

		if ( $force || (($producto->getActivo() === false || !$producto->getCurrentStock()) && $publicacionML && $publicacionML->estaVigente() ) )
		{
    	    $api = MercadoLibre::getInstance()->getAPI( $producto->getIdEshop() );
    	    $accessToken = MercadoLibre::getInstance()->getAccessToken( $producto->getIdEshop() );
		
			$publicacionML = $producto->getPublicacionMl();
		
			if ( !$publicacionML->getItemId() ) {
				return false;
			}
			
			if ( $publicacionML->getStatusMl() == publicacionMl::STATUS_CLOSED ) {
			    return true;
			}
		
			$response = $api->put('/items/' . $publicacionML->getItemId(), array('status' => publicacionMl::STATUS_CLOSED), array('access_token' => $accessToken));
			$response = (array) $response['body'];
			$status = trim( strtolower( $response['status'] ) );
			
			$message = isset( $response['cause'][0] ) ? $response['cause'][0]->message : '';
			
			if ( stripos($message, 'status closed is not possible to change to status closed') !== false ) {
			    $status = publicacionMl::STATUS_CLOSED;
			}
			
			$publicacionML->setFechaFin( new Doctrine_Expression('now()') );
			$publicacionML->setStatusMl( $status );
			$publicacionML->save();
			
			return $status == publicacionMl::STATUS_CLOSED;
		}
		
		return false;
	}

	/*
	 * Engloba todos los envios de notificaciones via email al administrador de DeluxeBuys
	 */
	protected function sendNotificationEmail( $subject, $content )
	{
		$to = explode( ',', sfConfig::get('app_email_to_avisoMercadoLibre') );

		$vars = array( 'title' => $subject, 'content' => $content );
		$mailer = new Mailer('notificacionInterna', $vars);
		$mailer->send( $subject, $to );
	}
	
}



