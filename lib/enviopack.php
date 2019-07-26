<?php


class EnvioPack
{
    static protected $instance = array();
    protected $idEshop;
    protected $idDireccionEnvio;

    protected function __construct($idEshop) {

        $this->idEshop = $idEshop;

        $this->info = array(
            'andreani'  => array(
                'nombre'    => 'Andreani',
                'web'       => 'http://www.andreani.com.ar',
                'telefono'  =>'0810-122-1111 / 0800-122-1112'
            ),
            'fastmail'  => array(
                'nombre'    => 'Fast Mail',
                'web'       => 'http://www.fastmail.com.ar',
                'telefono'  =>'(011) 4776-6007'
            ),
            'fasttrack' => array(
                'nombre'    => 'Fast Track',
                'web'       => 'http://www.fasttrack.com.ar',
                'telefono'  =>'0810-888-3278 '
            ),
            'oca'       => array(
                'nombre'    => 'OCA',
                'web'       => 'http://www5.oca.com.ar/ocaepak',
                'telefono'  =>'0800-999-7700'
            ),
            'urbano'    => array(
                'nombre'    => 'Urbano',
                'web'       => 'https://www.urbano.com.ar',
                'telefono'  =>'0810-222-8782 / (011) 4378-2100'
            )
        );

        if ( $this->idEshop ) {
            $eshop                  = eshopTable::getInstance()->getById( $this->idEshop );
            $this->idDireccionEnvio = $eshop->getEnvioPackDireccionEnvio();
        } else {
            $this->idDireccionEnvio = sfConfig::get('app_enviopack_direccion_envio');
        }
    }

    public static function getInstance( $idEshop = null )
    {
        if ( !isset( self::$instance[ $idEshop ] ) )
        {
            self::$instance[ $idEshop ] = new EnvioPack( $idEshop );
        }

        return self::$instance[ $idEshop ];
    }


    public function cotizarPrecioDOM($codigoPostal, $idProvincia, $peso)
    {         
        $provincia = provinciaTable::getInstance()->getById($idProvincia);

        $request = array
        (
            'codigo_postal' => $codigoPostal,
            'provincia'     => $provincia->getIso(),
            'peso'          => $peso,
        );
         
        $response = $this->get('/cotizar/precio/por-provincia', $request );
        $response = json_decode($response, true);
        
        return $response;
    }

    public function cotizarPrecioSUC($codigoPostal, $correo, $peso)
    {         
        $request = array
        (
            'codigo_postal' => $codigoPostal,
            'correo'        => $correo,
            'peso'          => $peso,
            'volumen'       => (2 * 42 * 54),
            'modalidad'     => 'S'
        );
         
        $response = $this->get('/cotizar/precio/por-correo', $request );
        $response = json_decode($response, true);
        
        return $response;
    }

    public function costoProvincia($codigoPostal, $idProvincia, $peso, $servicio)
    {            
        if ( !$codigoPostal ) {
            return '';
        }
        
        $provincia = provinciaTable::getInstance()->getById($idProvincia);

        $request = array
        (
            'codigo_postal' => $codigoPostal,
            'provincia'     => $provincia->getIso(),
            'peso'          => $peso,
            'servicio'      => $servicio,
        );
         
        $response = $this->get('/cotizar/precio/por-provincia', $request );

        $response = json_decode($response, true);
        return $response[0]['valor'];
    }

    public function costoCorreo($codigoPostal, $correo, $peso, $tipoEnvio, $servicio)
    {
        if ( !$codigoPostal ) {
            return '';
        }

        $request = array
        (
            'codigo_postal' => $codigoPostal,
            'correo'        => $correo,
            'peso'          => $peso,
            'volumen'       => (2 * 42 * 54),
            'modalidad'     => ( $tipoEnvio == carritoEnvio::SUCURSAL ) ? 'S' : 'D',
            'servicio'      => $servicio
        );
         

        $response = $this->get('/cotizar/precio/por-correo', $request );

        $response = json_decode($response, true);

        return $response[0]['valor'];
    }


    public function costoDeluxe($codigoPostal, $correo, $peso, $tipoEnvio, $servicio)
    {         
        $request = array
        (
            'codigo_postal' => $codigoPostal,
            'correo'        => $correo,
            'peso'          => $peso,
            'volumen'       => (2 * 42 * 54),
            'modalidad'     => ( $tipoEnvio == carritoEnvio::SUCURSAL ) ? 'S' : 'D',
            'servicio'      => $servicio
        );
         
        $response = $this->get('/cotizar/costo', $request );
        $response = json_decode($response, true);

        return $response[0]['valor'];
    }

    public function localidades($idProvincia)
    {         
        $request = array('id_provincia' => $idProvincia);         
        $response = $this->get('/localidades', $request );
        return json_decode($response, true);
    }

    public function sucursales($idLocalidad)
    {         
        $request = array('id_localidad' => $idLocalidad);         
        $response = $this->get('/sucursales', $request );
        return json_decode($response, true);
    }

    public function sucursal($idSucursal)
    {         
        $response = $this->get('/sucursales/' . $idSucursal );
        return json_decode($response, true);
    }


    public function pedido($id)
    {         
        $response = $this->get('/pedidos/' . $id );
        return json_decode($response, true);
    }

    public function envio($id)
    {         
        $response = $this->get('/envios/' . $id );
        return json_decode($response, true);
    }

    public function tracking($id)
    {         
        $response = $this->get('/envios/' . $id . '/tracking' );
        return json_decode($response, true);
    }

    public function etiqueta($id)
    {         
        $response = $this->get('/envios/' . $id . '/etiqueta?formato=jpg&bulto=1' );
        return $response;
    }

    public function imponerPedido($pedido)
    {
        if ( $pedido->getEnvioIdPedidoEnvioPack() ) {
            return $pedido->getEnvioIdPedidoEnvioPack();
        }

        $envioDetalle = $pedido->getArrayEnvioDetalle();
        $localidad = $envioDetalle['localidad'];

        $request = array
        (
            "id_externo" => $this->sanitize( $pedido->getIdPedido() ),
            "nombre"     => $this->sanitize( $pedido->getUsuario()->getNombre() ),
            "apellido"   => $this->sanitize( $pedido->getUsuario()->getApellido()  ),
            "email"      => $this->sanitize( $pedido->getEmail() ),
            "telefono"   => $this->sanitize( $pedido->getTelefono() ),
            "celular"    => $this->sanitize( $pedido->getCelular() ),
            "monto"      => $this->sanitize( $pedido->getMontoTotal() ),
            "fecha_alta" => $this->sanitize( $pedido->getFechaAlta() ),
            "pagado"     => ( bool ) $pedido->getFechaPago(),
            "provincia"  => $pedido->getProvincia()->getIso(),
            "localidad"  => $this->sanitize( $localidad )
        );
         
        $response = $this->post('/pedidos', $request );
        $response = json_decode($response, true);

        if ( !isset($response['id']) ) {
            return false;
        }

        $idPedidoEnvioPack = $response['id'];

        $pedido->setEnvioIdPedidoEnvioPack( $idPedidoEnvioPack );
        $pedido->save();

        return $idPedidoEnvioPack;
    }

    public function imponerEnvio($pedido)
    {
        $request = array
        (
            "id"              => null,
            "pedido"          => $pedido->getEnvioIdPedidoEnvioPack(),
            "direccion_envio" => $this->idDireccionEnvio,
            "destinatario"    => $this->sanitize( $pedido->getEnvioDestinatario() ),
            "observaciones"   => '',
            "servicio"        => $pedido->getEnvioServicio(),
            "correo"          => $pedido->getEnvioCorreo(),
            "confirmado"      => true,
            "paquetes"        => array( array( "alto" => 2,"ancho" => 42,"largo" => 54,"peso" => $pedido->getPeso() ) )
        );

        if ( $pedido->getEnvioTipo() == CarritoEnvio::DOMICILIO ) {
            $request["modalidad"]     = 'D';
            $request["calle"]         = $this->sanitize( $pedido->getEnvioCalle() );
            $request["numero"]        = $this->sanitize( $pedido->getEnvioNumero() );
            $request["piso"]          = $this->sanitize( $pedido->getEnvioPiso() );
            $request["depto"]         = $this->sanitize( $pedido->getEnvioDepto() );
            $request["codigo_postal"] = $this->sanitize( $pedido->getEnvioCodigoPostal() );
            $request["provincia"]     = $pedido->getProvincia()->getIso();
            $request["localidad"]     = $this->sanitize( $pedido->getEnvioLocalidad() );
        } else {
            $request["modalidad"] = 'S';
            $request["sucursal"]  = $pedido->getEnvioIdSucursal();
        }
         
        $response = $this->post('/envios', $request );
        $response = json_decode($response, true);

        return $response;
    }

    public function imponerDevolucion($devolucion)
    {
        if ( !$devolucion->getEnvioIdPedidoEnvioPack() )
        {
            $usuario = $devolucion->getUsuario();

            $request = array
            (
                "id_externo" => $this->sanitize( 'D' . $devolucion->getIdDevolucion() ),
                "nombre"     => $this->sanitize( $devolucion->getNombre() ),
                "apellido"   => $this->sanitize( $devolucion->getApellido()  ),
                "email"      => $this->sanitize( $usuario->getEmail() ),
                "telefono"   => $this->sanitize( $usuario->getTelefono() ),
                "celular"    => $this->sanitize( $usuario->getCelular() ),
                "monto"      => 0,
                "fecha_alta" => $this->sanitize( $devolucion->getFecha() ),
                "pagado"     => false,
                "provincia"  => $devolucion->getProvincia()->getIso()
            );
             
            $response = $this->post('/pedidos', $request );
            $response = json_decode($response, true);

            if ( !isset($response['id']) ) {
                return false;
            }

            $idPedidoEnvioPack = $response['id'];

            $devolucion->setEnvioIdPedidoEnvioPack( $idPedidoEnvioPack );
        }

        $peso = devolucionProductoItemTable::getInstance()->getPesoByIdDevolucion( $devolucion->getIdDevolucion() );


        // Seleccion de correo segun eshop y zona.
        $correo = $this->getCorreoParaDevolucion( $devolucion->getIdEshop(), $devolucion->getCodigoPostal() );

        $request = array
        (
            "id"              => null,
            "pedido"          => $devolucion->getEnvioIdPedidoEnvioPack(),
            "direccion_envio" => $this->idDireccionEnvio,
            "destinatario"    => $this->sanitize( $devolucion->getNombre() . ' ' . $devolucion->getApellido() ),
            "observaciones"   => '',
            "servicio"        => 'R',
            "correo"          => $correo,
            "confirmado"      => true,
            "paquetes"        => array( array( "alto" => 2,"ancho" => 42,"largo" => 54,"peso" => $peso ) ),
            "modalidad"       => 'D',
            "calle"           => $this->sanitize( $devolucion->getCalle() ),
            "numero"          => $this->sanitize( $devolucion->getNumero() ),
            "piso"            => $this->sanitize( $devolucion->getPiso() ),
            "depto"           => $this->sanitize( $devolucion->getDpto() ),
            "codigo_postal"   => $this->sanitize( $devolucion->getCodigoPostal() ),
            "provincia"       => $devolucion->getProvincia()->getIso(),
            "localidad"       => $this->sanitize( $devolucion->getLocalidad() )
        );
         
        $response = $this->post('/envios', $request );
        $response = json_decode($response, true);

        return $response;
    }

    public function getCorreoParaDevolucion($idEshop, $codigoPostal)
    {
        if ( $codigoPostal <= 1931 ) {
            // AMBA 
            if ( $idEshop === null ) {
                return 'fastmail';    
            } else if ( in_array( $idEshop, array( eshop::BENITO, eshop::RIE, eshop::JANETWISE, eshop::FELIX, eshop::NAIMA ) ) ) {
                return 'fastmail';    
            } else {
                return 'urbano';
            }
            
        } else {
            // RESTO
            if ( $idEshop === null ) {
                return 'urbano';    
            } else if ( in_array( $idEshop, array( eshop::BENITO, eshop::NAIMA ) ) ) {
                return 'andreani';    
            } else {
                return 'urbano';
            }
        }
    }

    public function getSplitPagoMercadoPagoAccessToken()
    {
        $request = array();
         
        $response = $this->get('/split-de-pago/mercadopago/access-token', $request );
        $response = json_decode($response, true);


        return $response['access_token'];
    }

    public function getNombreServicio($servicio)
    {         
        $index = array
        (
            'N' => 'Estandar',
            'P' => 'Prioritario',
            'R' => 'Devolución',
            'C' => 'Cambio',
        );
         
        return $index[$servicio];
    }

    public function getNombreCorreo($correo)
    {         
        if ( isset( $this->info[$correo] ) ) {
            return $this->info[$correo]['nombre'];
        }
         
        return '';
    }

    public function getWebCorreo($correo)
    {         
        if ( isset( $this->info[$correo] ) ) {
            return $this->info[$correo]['web'];
        }
         
        return '';
    }

    public function getTelefonoCorreo($correo)
    {         
        if ( isset( $this->info[$correo] ) ) {
            return $this->info[$correo]['telefono'];
        }
         
        return '';
    }

    protected function get($method, $request = array() )
    {
        $url = sfConfig::get('app_enviopack_url_api') . $method . '?' .http_build_query($request);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->getAccessToken() ) );

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    protected function sanitize( $text )
    {
        return trim($text);
    }

    protected function post($method, $request = array() )
    {
        $url = sfConfig::get('app_enviopack_url_api') . $method;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->getAccessToken() ) );

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    protected function getAccessToken()
    {
        $url = sfConfig::get('app_enviopack_url_api') . '/auth';

        if ( $this->idEshop ) {
            $eshop                  = eshopTable::getInstance()->getById( $this->idEshop );
            $apiKey                 = $eshop->getEnvioPackApiKey();
            $secretKey              = $eshop->getEnvioPackSecretKey();
        } else {
            $apiKey                 = sfConfig::get('app_enviopack_api_key');
            $secretKey              = sfConfig::get('app_enviopack_secret_key');
        }

        $request = array
        (
            'api-key'    => $apiKey,
            'secret-key' => $secretKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);
        return $response['token'];
    }

    public function reglaCorreoDELUXE($codigoPostal, $peso, $servicio)
    {
        if ( $codigoPostal <= 1902 ) {
            // AMBA
            return 'fasttrack';
        } else {            
            // Interior   
            return 'andreani';
        }

    }

    public function reglaCorreoESHOPS($codigoPostal, $peso, $servicio, $idEshop)
    {

        if ( in_array( $idEshop, array( eshop::RIE, eshop::FELIX, eshop::JANETWISE ) ) ) {

            if ( $servicio == 'N' && $codigoPostal <= 1902 ) {
                // AMBA Estandar
                return 'fasttrack';
            } else {
                // Interior   
                return 'andreani';
            }

        } else if ( in_array( $idEshop, array( eshop::NAIMA, eshop::BENITO ) ) ) {
            return 'andreani';
        } else {

            if ( $servicio == 'N' && $codigoPostal <= 1902 ) {
                // AMBA Estandar
                return 'fasttrack';
            } else {
                // Interior   
                return 'andreani';
            }
            
        }
    }

    
}