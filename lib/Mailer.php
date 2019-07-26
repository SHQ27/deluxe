<?php

class Mailer
{
	protected $template;
	protected $vars;
    protected $priority = 3;
	
	public function __construct($template, $vars)
	{
		$this->template = $template;
		$this->vars = $vars;
	}
	
	public function setVar($name, $value)
	{
	    $this->vars[$name] = $value;
	}
	
	public function setPriority($priority)
	{
	    $this->priority = $priority;
	}
	
	public function setLowPriority()
	{
	    $this->setPriority(5);
	}

	public function setHighPriority()
	{
	    $this->setPriority(1);
	}

	public function send( $subject, $to, $from = null , $params = array() )
	{	    
		if (!$from)
		{
			$from = sfConfig::get('app_email_from_noreply');
		}
		if (!isset($this->vars['title']))
		{
		    $this->vars['title'] = $subject;
		}
		
		$params = array_merge(array('fromName' => null, 'toName' => null), $params);
		
		sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
	  	$body = get_partial('mails/' . $this->template , $this->vars );
	  		  	
 		$email = new AmazonSES( sfConfig::get('app_aws_key'), sfConfig::get('app_aws_secret_key') );
         		
 		if( $params['fromName'] )
 		{
 			$from = $params['fromName'] . ' <' . $from . '>';
 		}
 		
 		if( $params['toName'] )
 		{
 			$to = $params['toName'] . ' <' . $to . '>';
 		}
 		
 		$opt = null;
 		if( isset($params['ReplyToAddresses']) )
 		{
 			$opt = array('ReplyToAddresses' => $params['ReplyToAddresses']);
 		}

		$response = $email->send_email(
			$from,
			array('ToAddresses' => $to),
            array
            ( 
				'Subject.Data' => $subject,
            	'Body.Html.Charset' => 'UTF-8',
                'Body.Html.Data' => $body
            ),
            $opt
        );
	}
}