<?php

class MailReader
{
    protected $imap;
    
    public function __construct($server, $port, $options, $user, $pass)
    {        
        $this->imap = new ezcMailImapTransport( $server, $port, $options );
        $this->imap->authenticate( $user, $pass );
    }
        
	public function retrieve($mailbox )
	{
		$this->imap->selectMailbox( $mailbox );
		
		$num = $size = $recent = $unseen = null;
    	$this->imap->status( $num, $size, $recent, $unseen );
		
	    $set = $this->imap->fetchAll();
		
		$parser = new ezcMailParser();
		$mails = $parser->parseMail( $set );
		$messageNumbers = $set->getMessageNumbers();
		
		$response = array();
		foreach ($mails as $i => $mail )
		{		    
			$parts = $mail->fetchParts();
			
			$from = (string) $mail->getHeader('from');
			$subject = (string) $mail->getHeader('subject');
			
			$text = '';
			foreach ($parts as $part)
			{
				if (get_class($part) == 'ezcMailText')
				{
				    $text .= (string) $part->text;
				}
			}
			
			$response[] = array('id'=> $messageNumbers[$i], 'from' => $from, 'subject' => $subject, 'body' => $text);
		}
		
		$this->imap->expunge();
		
		$this->imap->noop();
		
		return $response;
	}

	public function move ($idMessage, $mailboxFrom )
	{
	    $this->imap->copyMessages( $idMessage, $mailboxFrom );
	    
	    $this->imap->delete( $idMessage );
	    $this->imap->expunge();
	}
	
}
