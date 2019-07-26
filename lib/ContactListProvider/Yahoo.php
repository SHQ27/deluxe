<?php

class ContactListProvider_Yahoo extends ContactListProvider
{
    public function readHeader($ch, $string)
    {
        $cookiearr = array();
             
        $length = strlen($string);
        if(!strncmp($string, "Location:", 9))
        {
          $this->location = trim(substr($string, 9, -1));
          $this->domain = substr($this->location, 0,strpos($this->location, '/', 8));
        }
        if(!strncmp($string, "Set-Cookie:", 11))
        {
          $cookiestr = trim(substr($string, 11, -1));
          $cookie = explode(';', $cookiestr);
          $cookie = explode('=', $cookie[0]);
          $cookiename = trim(array_shift($cookie));
          $cookiearr[$cookiename] = trim(implode('=', $cookie));
        }
        $cookie = "";
        if(trim($string) == "")
        {
          foreach ($cookiearr as $key=>$value)
          {
            $cookie .= "$key=$value; ";
          }
          $cookie = trim ($cookie, "; ");
          curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);
          curl_setopt($this->ch, CURLOPT_COOKIE, $cookie);
        }
    
        return $length;
    }

    protected function get_hidden($html)
    {
    	preg_match_all('|<input[^>]+type="hidden"[^>]+name\="([^"]+)"[^>]+value\="([^"]*)"[^>]*>|',$html,$input,PREG_SET_ORDER);
    	return $input;
    }
    
    
    
    protected function get_hidden2($html)
    {
    	preg_match_all("|<input type=hidden name=\'([^']+)\' value=\'([^']+)\'.*>|",$html,$input,PREG_SET_ORDER);
    	return $input;
    }
        
    protected function use_hidden($input)
    {
    	$par=null;
    	foreach($input as $eachinput){$par.="&".urlencode(html_entity_decode(@$eachinput[1]))."=".urlencode(html_entity_decode(@$eachinput[2]));}
    	return $par;
    }
        
    public function fetch($email, $password)
    { 
      $cookieFile = tempnam(sys_get_temp_dir(), 'yahoo_cookies_');

    	$this->ch = curl_init(); 
    	curl_setopt($this->ch, CURLOPT_URL,"http://us.m.yahoo.com/p/mail");
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver = 0);
        curl_setopt($this->ch, CURLOPT_REFERER, "");
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_HEADERFUNCTION, array($this, 'readHeader'));
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookieFile);
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookieFile);
    	$result = curl_exec($this->ch);
    	
    
    	
    	$inputs=$this->get_hidden($result);
    	//$hiddens=$this->use_hidden($inputs);
    	
    	$par = '';
    	foreach($inputs as $eachinput)
    		{
    			$par.="&".urlencode(html_entity_decode(@$eachinput[1]))."=".urlencode(html_entity_decode(@$eachinput[2]));
    			if($eachinput[1]=="_ts") {$tsvar=$eachinput[2];}
    			
    		}
    
    
    	
    	$POSTFIELDS = 'id='.urlencode($email).'&password='.urlencode($password).$par;
        $actionf="http://mlogin.yahoo.com/w/login/auth?.ts=".$tsvar."&_httpHost=us.m.yahoo.com&.intl=us&.lang=en";
    
    
    	//login
    
    	curl_setopt($this->ch, CURLOPT_POST, 1);
    	curl_setopt($this->ch, CURLOPT_URL,$actionf);
    	curl_setopt($this->ch, CURLOPT_POSTFIELDS,$POSTFIELDS);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookieFile);
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookieFile);

    	$result = curl_exec($this->ch);
    
    		if (preg_match('/Invalid ID\/Password/i', $result))
    		{
    			  return false;
    		}
    		elseif (preg_match('/This ID is not yet taken./i', $result))
    		{
    			 return false;
    		}
    		else
    		{
    			curl_setopt($this->ch, CURLOPT_URL,$this->domain . "/w/ygo-addressbook/contacts?.intl=us&.lang=en");
    			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
    			curl_setopt($this->ch, CURLOPT_REFERER, "");
    			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);
    			curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
    			curl_setopt($this->ch, CURLOPT_HEADERFUNCTION, array($this, 'readHeader'));
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookieFile);
      curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookieFile);
    			$result = curl_exec($this->ch);
          if (!preg_match_all('@href="(/w/ygo-addressbook/contact\?[^"]*)@', $result, $matches)) {
            return array();
          }

          // obtener contactos
          list(, $contactsUrl) = $matches;
          $contacts = array();

          foreach ($contactsUrl as $i => $url) {
      		  	curl_setopt($this->ch, CURLOPT_URL,$this->domain . $url);
      		  	curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
      		  	curl_setopt($this->ch, CURLOPT_REFERER, "");
    	  	  	curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);
    		    	curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
              curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookieFile);
              curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookieFile);
      	  		$result = curl_exec($this->ch);
              if (preg_match('/compose.bp.r=add_to.amp;e=([^&]*)/', $result, $matches)) {
                  $email = urldecode($matches[1]);
                  if (preg_match('/<div><b>([^<]*)/', $result, $matches)) {
                      $name = $matches[1];
                  } else {
                      $name = $email;
                  }
                  $contacts[] = array('name' => $name, 'email' => $email);
              }
    	    }
          return $contacts;
  		}
    }
}
