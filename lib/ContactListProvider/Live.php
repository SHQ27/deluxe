<?php

class ContactListProvider_Live extends ContactListProvider
{
	protected $location = "";
	protected $cookiearr = array();
	protected $cookie_file_path = "temp/cookie.txt";
	protected $cookie = "";
	protected $ch = null;
	protected $chpost = null;
	protected $ssl_ver = 0;	
	
    public function readHeader($ch, $string)
    {    
	    $length = strlen($string);
	    if(!strncmp($string, "Location:", 9))
	    {
	      $location = trim(substr($string, 9, -1));
		 
	    }
	    if(!strncmp($string, "Set-Cookie:", 11))
	    {
	      $cookiestr = trim(substr($string, 11, -1));
	      $this->cookie = explode(';', $cookiestr);
	      $this->cookie = explode('=', $this->cookie[0]);
	      $cookiename = trim(array_shift($this->cookie));
	      $this->cookiearr[$cookiename] = trim(implode('=', $this->cookie));
	    }
	    $this->cookie = "";
	    if(trim($string) == "")
	    {
	      foreach ($this->cookiearr as $key=>$value)
	      {
	        $this->cookie .= "$key=$value; ";
	      }
	      $this->cookie = trim ($this->cookie, "; ");
	      curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
	      curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
	    }
	
	    return $length;
    }
    
    public function fetch($email, $password)
    {    		
		//go to login screen
		$this->ch = curl_init();
		//curl_setopt($this->ch, CURLOPT_COOKIEJAR,$this->cookie_file_path);
		//curl_setopt($this->ch, CURLOPT_COOKIEFILE,$this->cookie_file_path);
		curl_setopt($this->ch, CURLOPT_HEADERFUNCTION, array($this, 'readHeader'));
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $this->ssl_ver);
		curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)");
		curl_setopt($this->ch, CURLOPT_URL,"https://mid.live.com/si/login.aspx");
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($this->ch);
		
		//get form action
		preg_match('/action="([^"]+)"/', $result, $matches);
		$opturl = $matches[1];
		
		//sumbit form
		
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_URL,"https://mid.live.com/si/".$opturl);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, "__ET=&PasswordSubmit=Sign in&LoginTextBox=".$email."&PasswordTextBox=".$password);
		$result = curl_exec($this->ch);

		if (preg_match('/Required information is missing/i', $result) || preg_match('/We were unable to sign you in with your Windows Live ID/i',$result))
		{
			return $contacts;
			exit();
		}
		else
		{

			preg_match("/url=([^\"]*)\"/si", $result, $matches);
							   
			///go to main page
			$url = $matches[1];
			curl_setopt($this->ch, CURLOPT_POST, 0);
			curl_setopt($this->ch, CURLOPT_URL,$url);
			$result = curl_exec($this->ch);
			//go 1
			$url = "http://mail.live.com/mail/EditMessageLight.aspx?n=";
			curl_setopt($this->ch, CURLOPT_POST, 0);
			curl_setopt($this->ch, CURLOPT_URL,$url);
			$result = curl_exec($this->ch);
			//go 2
			$url = "http://mail.live.com/mail/EditMessageLight.aspx?n=";
			curl_setopt($this->ch, CURLOPT_URL,$url);
			$result = curl_exec($this->ch);
			$info = curl_getinfo($this->ch);
			
			$base_url = str_replace('mail/EditMessageLight.aspx?n=','',$info['url']);
			preg_match('/ContactList.aspx(.*?)\"/si', $result, $matches);
			$url = $base_url.'/mail/ContactList.aspx'.$matches[1];
			
			//contacts page
			curl_setopt($this->ch, CURLOPT_POST, 0);
			curl_setopt($this->ch, CURLOPT_URL,$url);
			$result = curl_exec($this->ch);
			//logout url
			$logouturl = $base_url.'/mail/logout.aspx';
			
			//process contacts
			///start
			//final vars
			global $handlecontacts;
			global $max_allowed_contacts_to_import;
			$contactList = array();
			$j=0;
			
			if(!isset($handlecontacts))
			{$handlecontacts="1";}
			if(!isset($max_allowed_contacts_to_import))
			{
				$max_allowed_contacts_to_import=2500;}
	
					
				$bulkStringArray=explode("['",$result);
				unset($bulkStringArray[0]);
				unset($bulkStringArray[count($bulkStringArray)]);
				$contacts=array();
				$name = '';
				foreach($bulkStringArray as $stringValue)
				{
						$stringValue=str_replace(array("']],","'","]]]]"),'',$stringValue);					
						if ((strpos($stringValue,'0,0,0,')!==false)|| (strpos($stringValue,'\x26\x2364\x3b')!==false))
						{
							if (strpos($stringValue,'0,0,0,')!==false) 
							{
								$tempStringArray=explode(',',$stringValue);
								if (!empty($tempStringArray[2])){ 
									$name=html_entity_decode(urldecode(str_replace('\x', '%', $tempStringArray[2])),ENT_QUOTES, "UTF-8");
								}
							}
							else
							{
									$emailsArray=array();
									$emailsArray=explode('\x26\x2364\x3b',$stringValue);
									
									if (count($emailsArray)>0) 
									{
										
										//get all emails
										$bulkEmails=explode(',',$stringValue);
										
										if (!empty($bulkEmails)) 
										foreach($bulkEmails as $valueEmail)
										{ 
											$email=html_entity_decode(urldecode(str_replace('\x', '%', $valueEmail))); 
											if(!empty($email)) 
											{ 
												if($j<$max_allowed_contacts_to_import)
												{
												$contacts[$email]=array('first_name'=>(!empty($name)?$name:""),'email_1'=>$email);
													///manage contacts
															if($handlecontacts=="0") //do not import
																{
																 $name = trim($name);
																 $email = trim($email);
																	if($email!="" && $name!="")
																	 {$contactList[] = array('name' => $name, 'email' => $email);}
																}
																////end do not import
																if($handlecontacts=="1") //email->name
																{
																 if($name==""){$name=$email;}
																 if($email!=""){ $contactList[] = array('name' => $name, 'email' => $email);}
																}
																////end email->name
																if($handlecontacts=="2") //id->name
																{
																  if($name=="")
																   {
																   $nn=explode("@",$email);
																   $name=$nn[0];
																   }
																		$name = trim($name);
																		$email = trim($email);
																		if($email!=""){ $contactList[] = array('name' => $name, 'email' => $email);}
																 }//end id->name
													//end manage contacts
												
												
												$email=false; 
												$j++;
												}
											} 
										}
										$name=false;	
									}	
							}
						}
				}
			
			///logout
			curl_setopt($this->ch, CURLOPT_POST, 0);
			curl_setopt($this->ch, CURLOPT_URL,$logouturl);
			$result = curl_exec($this->ch);
			///end
			sort($contactList);
						
			return $contactList;
    	}
    }
}