<?php

class UserSourceFilter extends sfFilter
{
    public function execute($filterChain)
    {
        
        $data = array();
        
        if ( isset( $_GET['utm_source'] ) )
        {
            $data['source'] = $_GET['utm_source'];
        }
        else if ( isset( $_GET['source'] ) )
        {
            $data['source'] = $_GET['source'];
        }
        else
        {
            $data['source'] = null;
        }
        
        $data['utmCampaign'] = ( isset( $_GET['utm_campaign'] ) ) ? $_GET['utm_campaign'] : null;
        $data['utmTerm']     = ( isset( $_GET['utm_term']     ) ) ? $_GET['utm_term']     : null;
        $data['utmMedium']   = ( isset( $_GET['utm_medium']     ) ) ? $_GET['utm_medium']     : null;        
        $data['fecha']       = date('Y-m-d');
        
        $data = ( !empty( $data['source'] ) ) ? base64_encode( json_encode( $data ) ) : null;

        $redirect = false;

        if ( !$this->getContext()->getRequest()->getCookie('codigo_descuento') && isset( $_GET['codigo_descuento'] ) ) {
            $this->getContext()->getResponse()->setCookie('codigo_descuento', $_GET['codigo_descuento']);
            $_COOKIE['codigo_descuento'] = $_GET['codigo_descuento'];
        }                                

        if ( $data )
        {
            // Expira en una semana
            $expire = time() + 604800;
            $this->getContext()->getResponse()->setCookie(usuario::USER_SOURCE, $data, $expire);
            $_COOKIE[usuario::USER_SOURCE] = $data;
        }

        $filterChain->execute();
    }
}