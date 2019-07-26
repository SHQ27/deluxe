<?php

class Net_Gearman_Job_Pragmore extends Net_Gearman_Job_Common
{
    protected $logger;    
    
    public function __construct($conn, $handle)
    {
        parent::__construct($conn, $handle);
                
        $type = str_replace('Net_Gearman_Job_', '', get_class($this) );
        
        // Inicializo el logger
        $this->logger = new sfFileLogger
        (
                sfContext::getInstance()->getEventDispatcher(),
                array(
                  'file' => sfConfig::get('sf_log_dir') .'/workers.log',
                  'type' => $type
                )
        );
        
    }   

    public function log($message, $priority = sfLogger::INFO)
    {
        $this->logger->log($message, $priority);
    }
    
    public function run ($arg){ }
}

?>
