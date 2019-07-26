<?php

class Afip_WSAA extends Afip
{
	static protected $instance;
	
	protected $wsdl;
	protected $cert;
	protected $privateKey;
	protected $URL;
	protected $dirTmp;

	protected function __construct()
	{
		$configWS = sfConfig::get('app_afip_ws');
		
		if ( $configWS['env'] == Afip::PROD )
		{
			$this->URL 		= "https://wsaa.afip.gov.ar/ws/services/LoginCms";
		}
		else 
		{
			$this->URL 		= "https://wsaahomo.afip.gov.ar/ws/services/LoginCms";
		}
						
		$this->wsdl 		= dirname(__FILE__) . "/docs/wsaa.wsdl";
		$this->cert 		= dirname(__FILE__) . "/docs/" . $configWS['env'] . "/deluxe.crt";
		$this->privateKey	= dirname(__FILE__) . "/docs/" . $configWS['env'] . "/deluxe.key";
		$this->dirTmp		= dirname(__FILE__) . "/tmp/" . $configWS['env'] . "/";
		$this->TA 			= dirname(__FILE__) . "/tmp/" . $configWS['env'] . "/TA.xml";
	}

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new Afip_WSAA();
		}

		return self::$instance;
	}
	
	public function generateTA()
	{
		// CreateTRA
  		$TRA = new SimpleXMLElement
  		(
		    '<?xml version="1.0" encoding="UTF-8"?>' .
		    '<loginTicketRequest version="1.0">'.
		    '</loginTicketRequest>'
  		);
  		
		$TRA->addChild('header');
		$TRA->header->addChild('uniqueId',date('U'));
		
		$TRA->header->addChild('generationTime',date('c',date('U')-120));
		$TRA->header->addChild('expirationTime',date('c',date('U')+120));
		$TRA->addChild('service','wsfe');
		$TRA->asXML( $this->dirTmp . 'TRA.xml');		
		
		// SignTRA		
		$STATUS = openssl_pkcs7_sign(
					$this->dirTmp . "TRA.xml",
					$this->dirTmp . "TRA.tmp",
					"file://" . $this->cert,
					array("file://". $this->privateKey, ""),
					array(),
					!PKCS7_DETACHED
				);
				
		  if (!$STATUS)
		  {
		  		exit("ERROR generating PKCS#7 signature\n");
		  }
		  
		  $inf=fopen($this->dirTmp . "TRA.tmp", "r");
		  
		  $i	= 0;
		  $CMS	= '';
		  
		  while (!feof($inf)) 
		  { 
		  	$buffer=fgets($inf);
		  	if ( $i++ >= 4 ) $CMS.=$buffer;
		  }
		  fclose($inf);
		  
		  unlink($this->dirTmp . "TRA.tmp");
		  unlink($this->dirTmp . "TRA.xml");

		  // CallWSAA
		  $client = new SoapClient( $this->wsdl,
		  							array( 'soap_version' => SOAP_1_2,
		  								   'location' => $this->URL,
		  								   'trace' => 1,
		  								   'exceptions' => 0
		  							));
		  			 
		$results = $client->loginCms( array('in0' => $CMS) );
		
		if ( is_soap_fault($results) ) 
		{
			exit("SOAP Fault: " . $results->faultcode. "\n" . $results->faultstring . "\n");
		}
		
		file_put_contents($this->TA, $results->loginCmsReturn);
	}
	
	public function getTA()
	{
		if ( file_exists($this->TA) )
		{
			$TA = new SimpleXMLElement($this->TA, null, true);
			
			if ( ( time() + 600 ) >= strtotime( $TA->header->expirationTime ) )
			{
				unlink($this->TA);
				$this->generateTA();
				$TA = new SimpleXMLElement($this->TA, null, true);			
			}
		}
		else 
		{
			$this->generateTA();
			$TA = new SimpleXMLElement($this->TA, null, true);
		}
		
		return $TA;
	}
	
	public function getCredentials()
	{
		return $this->getTA()->credentials;
	}
	
}