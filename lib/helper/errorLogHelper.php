<?php

class errorLogHelper
{
	static protected $instance;
	
	protected function __construct()
	{
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}

	/**
	 * 
	 * @param string $cronName
	 * @param string $errorMessage
	 * 
	 */
	public function cronErrorEmail($cronName, $errorMessage)
	{
		$subject = 'Error al ejecutar el cron "' . $cronName . '"';
		$to = explode( ',', sfConfig::get('app_email_to_avisoErrorGeneral') );
		$vars = array( 'title' => $subject, 'content' => 'Se detecto el siguiente error: '  . $errorMessage );
		$mailer = new Mailer('notificacionInterna', $vars);
		$mailer->send( $subject, $to );
	}

}
