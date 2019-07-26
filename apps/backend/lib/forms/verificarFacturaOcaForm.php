<?php

class verificarFacturaOcaForm extends sfFormSymfony
{
  	public function configure()
  	{  		
  	    $this->setWidget( 'csv', new sfWidgetFormInputFile() );
  	    $this->setValidator( 'csv', new sfValidatorString(array('required' => false) ) );  	    
  	    $this->getWidgetSchema()->setNameFormat('verificarFacturaOca[%s]');
  	}

  	public function verificar()
  	{  	    
  	    set_time_limit(0);
  	    
  	    $files = $_FILES['verificarFacturaOca'];  	    
  	      	    
        if ( $files["error"]['csv'] != UPLOAD_ERR_OK ) sfContext::getInstance()->getUser()->setFlash('result_verificarFacturaOcaForm', array('error' => 'Se produjo un error al subir el archivo. Por favor, intente nuevamente.') );
        if ( stripos($files["type"]['csv'], 'csv') === false ) sfContext::getInstance()->getUser()->setFlash('result_verificarFacturaOcaForm', array('error' => 'El archivo subido debe ser un CSV') );
  	    
  	    $client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
  	    
  	    $filepath =  sfConfig::get('sf_temp_dir') . '/verificar_factura_oca.csv';
  	    @unlink($filepath);
  	    
  	    move_uploaded_file($files["tmp_name"]["csv"], $filepath);
  	    
  	    $task = new Net_Gearman_Task ('VerificarFacturaOcaWorker', array ('filepath' => $filepath) );
  	    $task->type = Net_Gearman_Task::JOB_NORMAL;
  	    
  	    function complete($func, $handle, $result)  {
  	      sfContext::getInstance()->getUser()->setFlash('result_verificarFacturaOcaForm', $result);
  	    }
  	    $task->attachCallback ("complete",Net_Gearman_Task::TASK_COMPLETE);
  	    
  	    $set = new Net_Gearman_Set();
  	    $set->addTask ($task);
  	    
  	    $client->runSet ($set);
  	}
}