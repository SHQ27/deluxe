<?php

class ContactListProvider_Gmail extends ContactListProvider
{
    public function fetch($email, $password)
    {   
        $ssl_ver=0;		
		// step 1: login
		$login_url = "https://www.google.com/accounts/ClientLogin";
		$fields = array(
		    'Email'       => $email,
		    'Passwd'      => $password,
		    'service'     => 'cp',
		    'source'      => 'test-google-contact-grabber',
		    'accountType' => 'GOOGLE',
		);
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $login_url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$fields);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,$ssl_ver);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($curl);
		 
		$returns = array();		 
		foreach (explode("\n", $result) as $line)
		{
		    $line = trim($line);
		    if(!$line) continue;
		    list($k,$v) = explode("=",$line,2);		
		    $returns[$k] = $v;
		}
		curl_close($curl);
		 
		// step 2: grab the contact list
		$feed_url = "http://www.google.com/m8/feeds/contacts/default/property-email?max-results=9999";
		if (!isset($returns['Auth'])) {
		    return false;
		}
		$header = array( 'Authorization: GoogleLogin auth=' . $returns['Auth'] );
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $feed_url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl_ver);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		 
		$result = curl_exec($curl);
		curl_close($curl);
		
		$parts = explode('<entry>', $result);
		$contactList = array();
		foreach($parts as $v)
		{
		    if (preg_match("/(?:<title type='text'>)([^<]*)<.*?(?:<gd:email)[^>]*?address='([^']+)'/si", $v, $matches))
			{
			    $name  = $matches[1];
				$email = $matches[2];		
				if ($name != "" && $email != "")
				{
				    $contactList[] = array('name' => $name, 'email' => $email);
				}
			}
		}
		sort($contactList);
        return $contactList;
    }    
}