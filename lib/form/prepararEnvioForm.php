<?php

class prepararEnvioForm extends sfFormSymfony
{
	protected $downloadEnabled;
		
  	public function configure()
  	{
  	    $eshop = $this->getOption('eshop');
  	    $eshopNombre = ( $eshop ) ? $eshop->getDenominacion() : 'Deluxe Buys';
  	    
	  	$this->setWidget('id_pedido', new sfWidgetFormInputCheckbox() );
	  	$this->setValidator('id_pedido', new sfValidatorPass() );
	  	
	  	$this->setWidget('calle', new sfWidgetFormInputText() );
	  	$this->setValidator('calle', new sfValidatorPass() );
	  	
	  	$this->setWidget('numero', new sfWidgetFormInputText() );
	  	$this->setValidator('numero', new sfValidatorPass() );
	  	
	  	$this->setWidget('piso', new sfWidgetFormInputText() );
	  	$this->setValidator('piso', new sfValidatorPass() );
	  	
	  	$this->setWidget('dpto', new sfWidgetFormInputText() );
	  	$this->setValidator('dpto', new sfValidatorPass() );
	  	
	  	$this->setWidget('cp', new sfWidgetFormInputText() );
	  	$this->setValidator('cp', new sfValidatorPass() );
	  	
	  	$this->setWidget('telefono', new sfWidgetFormInputText() );
	  	$this->setValidator('telefono', new sfValidatorPass() );
	  	
		$this->getWidgetSchema()->setNameFormat('prepararEnvio[%s]');
  	}

	public function enviar()
	{
	    $eshop = $this->getOption('eshop');
	    $values = $this->getValues();

		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
		$idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
		
		$idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;

		$task = new Net_Gearman_Task ('PrepararEnvioWorker', array ('idEshop' => $idEshop, 'values' => $values, 'idUsuario' => $idUsuario) );
		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
		
		$set = new Net_Gearman_Set();
		$set->addTask ($task);
		
		$client->runSet($set);
	}
	



	
}