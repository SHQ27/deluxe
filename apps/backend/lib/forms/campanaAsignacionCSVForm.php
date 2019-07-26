<?php

class campanaAsignacionCSVForm extends sfFormSymfony
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
	    
		$this->getWidgetSchema()->setNameFormat('campanaAsignacionCSV[%s]');
  	}

	public function process( $idCampana )
	{	
		$files = $_FILES['campanaAsignacionCSV'];
				
		if ( $files["error"]['csv'] == UPLOAD_ERR_OK )
		{
			$tmp_name = $files["tmp_name"]["csv"];
			$csv = sfConfig::get('sf_temp_dir') . '/campanaAsignacionCSV/' . $idCampana . '_' . time() . '.csv';
			move_uploaded_file( $tmp_name, $csv);
		
    		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
    		$idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
    		
    		$task = new Net_Gearman_Task ('CampanaAsignacionCSVWorker', array ('csv' => $csv, 'idCampana' => $idCampana, 'idUsuario' => $idUsuario) );
    		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
    		
    		$set = new Net_Gearman_Set();
    		$set->addTask ($task);
    		
    		$client->runSet ($set);
    		
    		return true;
		}	

		return false;
	}
}