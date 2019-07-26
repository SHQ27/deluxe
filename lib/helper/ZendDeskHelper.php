<?php

class ZendDeskHelper
{
	static protected $instance;
	
	protected $config;

	protected function __construct() { }
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new ZendDeskHelper();
		}
		
		return self::$instance;
	}

	public function createTicket($eshop, $nombre, $email, $subject, $body, $params = array())
	{    
	    $ch = curl_init();
		
	    if ( $eshop ) {
	    	$zendeskConfig		   = json_decode( $eshop->getZendeskConfig(), true );
	    	$zendeskUser           = $zendeskConfig['user'];
	    	$zendeskPass           = $zendeskConfig['pass'];
	    	$zendeskURL            = $zendeskConfig['url'];
	    	$zendeskFields         = $zendeskConfig['fields'];	
	    	$zendeskURLAttachments = $zendeskConfig['urlAttachments'];
	    } else {
	    	$zendeskUser           = sfConfig::get('app_zendesk_user');
	    	$zendeskPass           = sfConfig::get('app_zendesk_pass');
	    	$zendeskURL            = sfConfig::get('app_zendesk_url');
	    	$zendeskFields         = sfConfig::get('app_zendesk_fields');	
	    	$zendeskURLAttachments = sfConfig::get('app_zendesk_urlAttachments');
	    }


	    $data = array(
	        'ticket'=> array(
	            'subject' => $subject,
	            'description' => $body,
	            'requester' => array('locale_id' => 8, 'name' => $nombre, 'email' => $email),
	            'fields' => array(),
	        )
	    );
	    
	    if ( isset($params['motivo']) && $params['motivo'] && isset( $zendeskFields['motivo'] ) ) {
	        $data['ticket']['fields'][] = array('id' => $zendeskFields['motivo'], 'value' => $params['motivo']);
	    }
	    
	    if ( isset($params['submotivo']) && $params['submotivo'] && isset( $zendeskFields['submotivo'] ) ) {
	        $data['ticket']['fields'][] = array('id' => $zendeskFields['submotivo'], 'value' => $params['submotivo']);
	    }
	    
	    if ( isset($params['marca']) && $params['marca'] && isset( $zendeskFields['marca'] ) ) {
	        $data['ticket']['fields'][] = array('id' => $zendeskFields['marca'], 'value' => $params['marca']);
	    }
	    
	    if ( isset( $zendeskFields['eShop'] ) ) {
		    if ( isset($params['eShop']) && $params['eShop'] ) {
		        $data['ticket']['fields'][] = array('id' => $zendeskFields['eShop'], 'value' => $params['eShop']);
		    } else {
		        $data['ticket']['fields'][] = array('id' => $zendeskFields['eShop'], 'value' => 'DeluxeBuys');
		    }	    	
	    }

	
	    if ( isset($params['tokenAttachment']) && $params['tokenAttachment'] ) {
	        $data['ticket']['comment']['body'] = $body;
	        $data['ticket']['comment']['uploads'] = $params['tokenAttachment'];
	    }
		    
	    $data = json_encode($data);
	
	    $headers = array('Content-Type: application/json');
	
	    curl_setopt($ch, CURLOPT_URL,  $zendeskURL );
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	

	    curl_setopt($ch, CURLOPT_USERPWD, $zendeskUser . ':' . $zendeskPass );
	
	    $response = curl_exec($ch);
	    
	    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	    curl_close($ch);
	}
	
	public function sendAttachment( $eshop, $type, $filepath, $filename )
	{

	    if ( $eshop ) {
	    	$zendeskConfig		   = json_decode( $eshop->getZendeskConfig(), true );
	    	$zendeskUser           = $zendeskConfig['user'];
	    	$zendeskPass           = $zendeskConfig['pass'];
	    	$zendeskURLAttachments = $zendeskConfig['urlAttachments'];
	    } else {
	    	$zendeskUser           = sfConfig::get('app_zendesk_user');
	    	$zendeskPass           = sfConfig::get('app_zendesk_pass');
	    	$zendeskURLAttachments = sfConfig::get('app_zendesk_urlAttachments');
	    }
		
	    $size = filesize($filepath);
	
	    $file = fopen( $filepath , "r");
	    $filedata = fread($file,$size);
	     
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,  $zendeskURLAttachments . '?filename=' . $filename );
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: ' . $type) );
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $filedata);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_USERPWD, $zendeskUser . ':' . $zendeskPass );
	    curl_setopt($ch, CURLOPT_INFILE, $file);
	    curl_setopt($ch, CURLOPT_INFILESIZE, $size);
	     
	    $result = json_decode(curl_exec($ch), true);
	    curl_close($ch);
	     
	    return $result['upload']['token'];
	}
	
}



