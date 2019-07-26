<?php

class productosSetCategoriaMLForm extends sfFormSymfony
{
  	public function configure()
  	{
  	    $this->setWidget('categoria', new sfWidgetFormInputHidden() );
  	    $this->setValidator('categoria', new sfValidatorString( array(), array('required' => 'Es obligatorio seleccionar una categoria que no tenga subcategorias asociadas.') ) );
  	    
  	    $this->setWidget('data', new sfWidgetFormInputHidden() );
  	    $this->setValidator('data', new sfValidatorPass() );
  	    
		$this->getWidgetSchema()->setNameFormat('productosSetCategoriaML[%s]');
  	}

	public function save()
	{
	    $idCategoriaML = $this->getValue('categoria');
	    $data = $this->getValue('data');
	    		
	    $client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
	    $idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
	    
	    $params = array ( 
	        'idCategoriaML' => $idCategoriaML,
	        'data' => $data,
	        'idUsuario' => $idUsuario
	    );
	    
	    $task = new Net_Gearman_Task ('ProductosSetCategoriaMLWorker', $params );
	    
	    $task->type = Net_Gearman_Task::JOB_BACKGROUND;
	    
	    $set = new Net_Gearman_Set();
	    $set->addTask ($task);
	    
	    $client->runSet ($set);
	    
	}
}