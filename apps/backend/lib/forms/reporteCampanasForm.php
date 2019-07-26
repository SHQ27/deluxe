<?php

class reporteCampanasForm extends sfFormSymfony
{
  	public function configure()
  	{  		  	    
      	// Widget para Campañas
      	$choices = array();
      	$campanas = campanaTable::getInstance()->listAll();
      	foreach ($campanas as $campana)
      	{
      		$desde = $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y");
      		$hasta = $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
      		$choicesCampanas[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
      	}
      	$this->setWidget( 'campanas', new sfWidgetFormChoice( array( 'choices' => $choicesCampanas, 'multiple' => true ) ) );
      	$this->setValidator( 'campanas', new sfValidatorPass() );
      	
      	$this->setWidget('action', new sfWidgetFormInputHidden() );
      	$this->setValidator( 'action', new sfValidatorPass() );
	    
		$this->getWidgetSchema()->setNameFormat('reporteCampanas[%s]');
  	}
  	
  	public function generar()
  	{
  	    set_time_limit(0);
  	    
  	    $params = $this->getValues();
  	      	    
  	    $client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
  	    
  	    
  	    $campanas = campanaTable::getInstance()->listAll();
  	    
  	    $task = new Net_Gearman_Task ('ReporteCampanasWorker', array ('params' => $params) );
  	    $task->type = Net_Gearman_Task::JOB_NORMAL;  	    
  	    
  	    function complete($func, $handle, $result)  {
  	          	        
  	        if ( $result['type'] == 'VER_ONLINE' )
  	        {  	            
  	            sfContext::getInstance()->getUser()->setFlash('result_reporteCampanaForm', unserialize( $result['data'] ) );
  	        }
  	        else
  	       {
  	           $tempFile = $result['tempFile'];
  	           
  	           header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  	           header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  	           header('Content-Type: application/vnd.ms-excel');
  	           header("Content-Length: ".filesize($tempFile));
  	           header('Content-Disposition: attachment; filename="reporte_campanas.xls"');
  	           
  	           readfile($tempFile);
  	           //@unlink($tempFile);
  	           exit;
  	        }
  	    

  	    }
  	    $task->attachCallback ("complete",Net_Gearman_Task::TASK_COMPLETE);
  	    
  	    $set = new Net_Gearman_Set();
  	    $set->addTask ($task);
  	    
  	    $client->runSet ($set);
  	}
  	
}