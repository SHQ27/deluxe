<?php

class Remarkety
{
    static protected $instance;

    protected function __construct() {}

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

	public function get($task, $apiKey, $params = array( )) {

        if ( $apiKey != '518281981fb90091949070518281981' ) {
            return $this->makeResponse( null, 'Please check the remarkety_api_key parameter' );
        }

        if ( !$task ) {
            return $this->makeResponse( null );
        }

		$method = "get" . ucfirst($task);

        $params['updated_at_min'] = isset( $params['updated_at_min'] ) ? $params['updated_at_min'] : null;
        $params['updated_at_max'] = isset( $params['updated_at_max'] ) ? $params['updated_at_max'] : null;
        $params['limit']          = isset( $params['limit']          ) ? $params['limit']          : 250;
        $params['page']           = isset( $params['page']           ) ? $params['page']           : 0;

		return $this->$method($params);
	}

    public function getShoppers($params) {

        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];
        $limit = $params['limit'];
        $page  = $params['page'];

        $usuarios = usuarioTable::getInstance()->listForRemarkety($desde, $hasta, $limit, $page);

        $shoppers = array();
        foreach ($usuarios as $usuario) {
            $shoppers[ $usuario->getIdUsuario() ] = $this->parseShopper($usuario);
        }

        return $this->makeResponse( $shoppers );
    }

    protected function parseShopper($usuario) {
        
    	return array(
			"internal_user_id"  => $usuario->getIdUsuario(),
			"country_id" 		=> "ARG",
			"zip" 				=> $usuario->getDireccionEnvioDefault()->getCodigoPostal(),
			"email" 			=> $usuario->getEmail(),
			"first_name" 		=> $usuario->getNombre(),
			"last_name" 		=> $usuario->getApellido(),
            "tags"              => $usuario->getSexoNombre(),
            "created_on"        => $usuario->getFechaAlta(),
			"modified_on" 		=> $usuario->getFechaAlta()
		);
    }

    public function getProducts($params) {

        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];
        $limit = $params['limit'];
        $page  = $params['page'];

        $productos = productoTable::getInstance()->listForRemarkety($desde, $hasta, $limit, $page);

        $shoppers = array();
        foreach ($productos as $producto) {
            $shoppers[ $producto->getIdProducto() ] = $this->parseProduct($producto);
        }

        return $this->makeResponse( $shoppers );
    }

    protected function parseProduct($producto) {

        $productoCategoria = $producto->getProductoCategoria();
        $productoGenero    = $productoCategoria->getProductoGenero();

        $img = imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto );
        $url = sfConfig::get('app_host') . '/producto/' . $productoGenero->getSlug() . '/' . $productoCategoria->getSlug() . '/' . $producto->getSlug();

        return array(
            "product_id"         => $producto->getIdProducto(),
            "product_sku"        => $producto->getIdProducto(),
            "product_name"       => $producto->getDenominacion(),
            "modified_on"        => $producto->getFechaModificacion(),
            "productThumbPath"   => $img,
            "prod_url"           => $url,
            "price"              => $producto->getPrecioDeluxe(),
            "categories"         => array( $productoGenero->getDenominacion() . ' - ' . $productoCategoria->getDenominacion() ),
            "vendor"             => $producto->getMarca()->getNombre(),
            "inventory_quantity" => $producto->getCurrentStock(),
            "enabled"            => $producto->getActivo()
        );
    }

    public function getOrders($params) {

        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];
        $limit = $params['limit'];
        $page  = $params['page'];

        $pedidos = pedidoTable::getInstance()->listForRemarkety($desde, $hasta, $limit, $page);

        $orders = array();
        foreach ($pedidos as $pedido) {
            $orders[ $pedido->getIdPedido() ] = $this->parseOrder($pedido);
        }

        return $this->makeResponse( $orders );
    }

    protected function parseOrder($pedido) {

        $items = array();
        foreach($pedido->getPedidoProductoItem() as $pedidoProductoItem) {
            $producto = $pedidoProductoItem->getProductoItem()->getProducto();

            $productoCategoria = $producto->getProductoCategoria();
            $productoGenero    = $productoCategoria->getProductoGenero();

            $img = imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto );
            $url = sfConfig::get('app_host') . '/producto/' . $productoGenero->getSlug() . '/' . $productoCategoria->getSlug() . '/' . $producto->getSlug();

            $finalPrice = $pedidoProductoItem->getPrecioDeluxe() * $pedidoProductoItem->getCantidad();

            $items[] = array(
                "order_item_id"       => $pedidoProductoItem->getIdPedidoProductoItem(),
                "product_quantity"    => $pedidoProductoItem->getCantidad(),
                "order_item_name"     => $producto->getDenominacion(),
                "order_item_sku"      => $producto->getIdProducto(),
                "product_id"          => $producto->getIdProducto(),
                "product_item_price"  => $pedidoProductoItem->getPrecioDeluxe(),
                "product_final_price" => number_format($finalPrice, 2, '.', ''),
                "category_id"         => $productoCategoria->getIdProductoCategoria(),
                "image_thumb"         => $img,
                "prod_url"            => $url
            );
        }

        $pedidoDescuento = $pedido->getPedidoDescuento();
        $codigoDescuento = ( count($pedidoDescuento) )? $pedidoDescuento->getFirst()->getDescuento()->getCodigo() : '';

        return array(
            'items'           => $items,
            'shopper'         => $this->parseShopper( $pedido->getUsuario() ),
            "created_on"      => $pedido->getFechaAlta(),
            "modified_on"     => $pedido->getFechaModificacion(),
            "currency_code_3" => "ARS",
            "currency_name"   => "Pesos",
            "currency_symbol" => "$",
            "order_id"        => $pedido->getIdPedido(),
            "order_number"    => $pedido->getIdPedido(),
            "order_total"     => $pedido->getMontoTotal(),
            "orderShipping"   => $pedido->getMontoEnvio(),
            "coupon_discount" => number_format($pedido->getMontoDescuento(), 2, '.', ''),
            "order_discount"  => number_format($pedido->getMontoBonificacion(), 2, '.', ''),
            "coupon_code"     => $codigoDescuento,
            "status_code"     => $pedido->getCodigoEstado(),
            "status_name"     => $pedido->getEstado()
        );
    }

    public function getGetShoppersCount( $params = array() ) {
        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];

        $cantidad = usuarioTable::getInstance()->countForRemarkety($desde, $hasta);
        return $this->makeResponse( $cantidad );
    }

    public function getGetProductsCount( $params = array() ) {
        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];

        $cantidad = productoTable::getInstance()->countForRemarkety($desde, $hasta);
        return $this->makeResponse( $cantidad );
    }

    public function getGetOrdersCount( $params = array() ) {
        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];

        $cantidad = pedidoTable::getInstance()->countForRemarkety($desde, $hasta);
        return $this->makeResponse( $cantidad );
    }

    public function getStatuses( $params = array() ) {

        $statuses = array(
            "PEND" => array(
                "order_status_name" => "Pendiente",
                "order_status_code" => "PEND"
            ),
            "PAGA" => array(
                "order_status_name" => "Pagado (pendiente de envío)",
                "order_status_code" => "PAGA"
            ),
            "ENVI" => array(
                "order_status_name" => "Enviado",
                "order_status_code" => "ENVI"
            ),
            "BAJA" => array(
                "order_status_name" => "Dado de baja",
                "order_status_code" => "BAJA"
            )
        );

        return $this->makeResponse( $statuses );
    }

    public function getShop( $params = array() ) {

        $shop = array(
            "name"                        => "DeluxeBuys",
            "contact_peson_name"          => "Horacio Esteves",
            "email"                       => "info@deluxebuys.com",
            "logoPath"                    => "https://s3.amazonaws.com/deluxebuys-static/images/logo.png",
            "created_at"                  => "2011-07-20 00:00:00",
            "address"                     => "Guatemala 4551, CABA",
            "domain"                      => "http://www.deluxebuys.com",
            "city"                        => "Capital Federal",
            "province"                    => "C",
            "country"                     => "Argentina",
            "country_2_code"              => "AR",
            "country_3_code"              => "ARG",
            "zip"                         => "1430",
            "phone"                       => "4544-4545",
            "currency"                    => "ARS",
            "money_with_currency_format"  => "{symbol}{number}",
            "date_format"                 => "%A, %d %B %Y %H:%M",
            "state_name"                  => "Capital Federal",
            "money_format"                => "{symbol}{number}",
            "timezone"                    => "UTC−03:00"
        );

        return $this->makeResponse( $shop );
    }



    public function getCreateCoupon($params) {

        $codigo = $params['code'];
        $tipo = $params['percent_or_total'];
        $gift = $params['gift_or_permanent'];
        $valor = $params['value'];
        $desde = $params['startDate'];
        $hasta = $params['expiryDate'];
        $montoMinimo = $params['validFromValue'];

        $idTipoDescuento = ( $tipo == 'percent' ) ? tipoDescuento::PORCENTAJE : tipoDescuento::MONTOFIJO;        
        $total = ( $gift == 'gift' ) ? 1 : 9999;
        
    
        $descuento = new Descuento();
        $descuento->setCodigo( $codigo );
        $descuento->setIdTipoDescuento( $idTipoDescuento );
        $descuento->setValor( $valor );
        $descuento->setVigenciaDesde( $desde . ' 00:00:00' );
        $descuento->setVigenciaHasta( $hasta . ' 23:59:59' );
        $descuento->setTotal($total);
        $descuento->setUtilizados(0);
        $descuento->save();

        if ( $montoMinimo && $montoMinimo > 0 ) {
            $restriccionMontoMinimo = new descuentoRestriccion();
            $restriccionMontoMinimo->setIdDescuento( $descuento->getIdDescuento() );
            $restriccionMontoMinimo->setTipo( descuentoRestriccion::MONTO_MINIMO );
            $restriccionMontoMinimo->setValor( $montoMinimo );
            $restriccionMontoMinimo->save();
        }

        return $this->makeResponse( true );
    }

    public function getCarts($params) {

        $desde = $params['updated_at_min'];
        $hasta = $params['updated_at_max'];
        $limit = $params['limit'];
        $page  = $params['page'];


        $sessiones = sessionTable::getInstance()->listForRemarkety($desde, $hasta, $limit, $page);

        $carts = array();
        foreach ($sessiones as $session) {
            $cart = $this->parseCart($session);
            if ( $cart !== false ) {
                $carts[] = $cart;
            }            
        }

        return $this->makeResponse( $carts );
    }


    protected function parseCart($session) {
        $usuario = $session->getUsuario();

        $carritoDescuento     = ( count( $session->getCarritoDescuento()    ) ) ? $session->getCarritoDescuento()->getFirst()    : null;
        $montoDescuento       = ($carritoDescuento)? $carritoDescuento->getMonto( true ) : 0;

        $carritoBonificacion  = ( count( $session->getCarritoBonificacion() ) ) ? $session->getCarritoBonificacion()->getFirst() : null;
        $montoBonificacion    = ( $carritoBonificacion ) ? $carritoBonificacion->getMonto(true) : 0;

        $carritoProductoItems = ( count( $session->getCarritoProductoItem() ) ) ? $session->getCarritoProductoItem() : array();

        $carritoEnvio         = ( count( $session->getCarritoEnvio()        ) ) ? $session->getCarritoEnvio()->getFirst() : null;
        $costoEnvio           = ( $carritoEnvio ) ? $carritoEnvio->getCosto( false ) : 0;

        $items = array();
        $montoProductos = 0;
        foreach ($carritoProductoItems as $carritoProductoItem) {
            
            $producto = $carritoProductoItem->getProductoItem()->getProducto();
            $productoCategoria = $producto->getProductoCategoria();
            $productoGenero    = $productoCategoria->getProductoGenero();

            $url = sfConfig::get('app_host') . '/producto/' . $productoGenero->getSlug() . '/' . $productoCategoria->getSlug() . '/' . $producto->getSlug();

            $items[] = array(
                "sku"            => $producto->getId(),
                "productTitle"   => $producto->getDenominacion(),
                "storeProductId" => 5045,
                "productPrice"   => $producto->getPrecioDeluxe(),
                "quantity"       => $carritoProductoItem->getCantidad(),
                "link"           => $url
            );

            $montoProductos += $carritoProductoItem->getSubTotal();
        }

        $montoTotal = $montoProductos + $costoEnvio - $montoBonificacion - $montoDescuento;
        $codigoDescuento = ( $carritoDescuento )? $carritoDescuento->getDescuento()->getCodigo() : '';

        return array(
            "items"                      => $items,
            "cartTotal"                  => $montoTotal,
            "shipping"                   => $costoEnvio,
            "couponCode"                 => $codigoDescuento,
            "couponDiscount"             => $montoDescuento,
            "otherDiscount"              => $montoBonificacion,
            "currency"                   => "ARS",
            "money_with_currency_format" => "{symbol}{number}",
            "money_format"               => "{symbol}{number}",
            "currency_code_3"            => "ARS",
            "currency_name"              => "Pesos",
            "currency_symbol"            => "$",
            "modifiedOn"                 => $session->getFechaUltimaAccion(),
            "email"                      => $usuario->getEmail(),
            "first_name"                 => $usuario->getNombre(),
            "last_name"                  => $usuario->getApellido(),
        );

    }


    public function newSuscriber($newsletter) {

        $remarketyId = 'x4Ajnvad';
        $tags = ( strtolower($newsletter->getSexo()) == 'h') ?  'Suscriptos_Hombre' : 'Suscriptos_Mujer';

        $contactData = [
            "email"     => $newsletter->getEmail(),
            "firstName" => $newsletter->getNombre(),
            "lastName"  => $newsletter->getApellido(),
            "doubleOptin" => true,
            "tags"      => $tags
        ];

        $payload = json_encode($contactData);

    
        $endpoint = "https://app.remarkety.com/api/v1/stores/" . $remarketyId . "/contacts";

        $headers = array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Accept: application/json",
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $endpoint);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        return $response;
    }

    protected function makeResponse($data, $errors = array() ) {
        $error = ( $errors && count($errors) ) ? $errors : null;
        $status = ( $error === null ) ? "SUCCESS" : "FAILED";
        $response = array(
            "DATA"           => $data,
            "STATUS"         => $status,
            "ERROR"          => $error,
            "PLUGIN_VERSION" => "2.0.2",
        );

        return json_encode($response);
    }
	
}