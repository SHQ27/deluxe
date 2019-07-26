<?php

class Sendgrid
{
    static protected $instance;


    protected function __construct() {
    }

    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new Sendgrid();
        }

        return self::$instance;
    }


    public function addContacts($newsletters, $idList)
    {
        // Contactos
        $request = array();

        $i = 0;
        $total = count($newsletters);
        foreach ($newsletters as $newsletter) {

            $request[] = array(
                'email' => $newsletter->getEmail(),
                'first_name' => $newsletter->getNombre(),
                'last_name' => $newsletter->getApellido(),
                'fecha_suscripcion' => strtotime( $newsletter->getFechaAlta() ),
                'sexo' => ($newsletter->getSexo() == 'h')? 'M' : 'F'
            );

            $i++;

            if ( $i == 800 || $total == $i ) {
                $this->doAddContacts($request, $idList);
                $request = array();
                sleep(2);
            }
        }
    }

    protected function doAddContacts($request, $idList)
    {
        $response = $this->execute('https://api.sendgrid.com/v3/contactdb/recipients', 'POST', $request );

        $response = json_decode($response, true);

        // Agregado a Lista
        $request = $response['persisted_recipients'];

        $response = $this->execute('https://api.sendgrid.com/v3/contactdb/lists/' . $idList . '/recipients', 'POST', $request );

        return (bool) count( $response['persisted_recipients'] );
    }

    public function updateContact( $usuario )
    {
        $fechaNacimiento = null;
        $anoNacimiento = null;
        if ( $usuario->getFechaNacimiento() ) {
            $fechaNacimiento = strtotime( $usuario->getFechaNacimiento() );
            $anoNacimiento = date('Y', $fechaNacimiento );
        }
        
        $provincia = null;
        $direccionEnvio = $usuario->getDireccionesEnvios();
        if ( count($direccionEnvio) ) {
             $direccionEnvio = $direccionEnvio->getFirst();
             $provincia = $direccionEnvio->getProvincia()->getNombre();
        }

        // Contacto
        $request = array(
            array(
                'email' => $usuario->getEmail(),
                'first_name' => $usuario->getNombre(),
                'last_name' => $usuario->getApellido(),
                'fecha_suscripcion' => strtotime( $usuario->getFechaAlta() ),
                'sexo' => ($usuario->getSexo() == 'h')? 'M' : 'F',
                'fecha_nacimiento' => $fechaNacimiento,
                'provincia' => $provincia
            )            
        );

        $response = $this->execute('https://api.sendgrid.com/v3/contactdb/recipients', 'PATCH', $request );

        $response = json_decode($response, true);

        // Agregado a Lista
        $request = $response['persisted_recipients'];

        if ( $usuario->getIdEshop() )
        {
            $eshop = $usuario->getEshop();
            $idList = $eshop->getListaSendgrid();
        } else {
            $idList = sfConfig::get('app_sendGrid_SubscribersListID_' . $usuario->getSexo() );
        }

        $response = $this->execute('https://api.sendgrid.com/v3/contactdb/lists/' . $idList . '/recipients', 'POST', $request );
        return (bool) count( $response['persisted_recipients'] );
    }

    public function execute($url, $method, $request)
    {

        $apiKey = sfConfig::get('app_sendGrid_api_key');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $request ) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $apiKey));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    
}