<?php

class edicionStockPrecioCSVForm extends sfFormSymfony
{
  	public function configure()
  	{  	  		
	    $this->setWidgets(
	    	array
	    	(
	    		'csv' => new sfWidgetFormInputFile()
	    	)
	    );
	    
	    $this->setValidators
	    (
	    	array
	    	(
				'csv' => new sfValidatorFile(array('required' => true))
	    	)
	    );
	    
		$this->getWidgetSchema()->setNameFormat('edicionStockPrecioCSV[%s]');
  	}

	public function process()
	{	
		$files = $_FILES['edicionStockPrecioCSV'];
				
		if ( $files["error"]['csv'] == UPLOAD_ERR_OK )
		{
			$tmp_name = $files["tmp_name"]["csv"];
			$csv = sfConfig::get('sf_temp_dir') . '/edicionStockPrecioCSV/' . time() . '.csv';
			move_uploaded_file( $tmp_name, $csv);
		
    		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
    		$idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
    		
    		$task = new Net_Gearman_Task ('EdicionStockPrecioCSVWorker', array ('csv' => $csv, 'idUsuario' => $idUsuario) );
    		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
    		
    		$set = new Net_Gearman_Set();
    		$set->addTask ($task);
    		
    		$client->runSet ($set);
    		
    		return true;
		}	

		return false;
	}
}