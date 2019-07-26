<?php

class citiVentasForm extends sfFormSymfony
{
  	public function configure()
  	{  		
  	    $choices = array();
  	    
  	    $i = 0;
  	    do
  	    {  	        
  	        $date = mktime (0, 0, 0, date('m') - $i, 1, date('Y'));
  	        $choices[ date('Y-m-d', $date) ] = ucfirst( strftime("%B %Y", $date) );
  	        $i++;
  	    }
  	    while( $date >= mktime (0, 0, 0, 1, 1, 2012) );
  	        
  	    array_pop($choices);
  	    
  	     	    
      	$this->setWidget( 'periodo', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
      	$this->setValidator( 'periodo', new sfValidatorPass() );
      	
      	$this->getWidgetSchema()->setNameFormat('citiVentasForm[%s]');
  	}

  	
  	public function process()
  	{
  	    set_time_limit(0);
  	    
        $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
  	    $periodo = $this->getValue('periodo');
  	    
  	    $client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );

  	    $task = new Net_Gearman_Task ('CitiVentasWorker', array ('idUsuario' => $idUsuario, 'periodo' => $periodo) );
        $task->type = Net_Gearman_Task::JOB_BACKGROUND;
        
        $set = new Net_Gearman_Set();
        $set->addTask ($task);
        
        $client->runSet ($set);
  	}
  	
}