<?php

class enviarPedidosCampanaAOcaForm extends sfFormSymfony
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
	  		$choices[$campana->getIdCampana()] = $campana->getDenominacion() . ' (' . $desde . ' a ' . $hasta . ')';
	  	}
	  	
	  	$this->setWidget( 'campana', new sfWidgetFormChoice( array( 'choices' => $choices ) ) );
	  	$this->getWidget('campana')->setLabel('Campaña');
	  	$this->setValidator( 'campana', new sfValidatorPass() );
	  	
	  	// Widget para Pedidos
	  	$this->setWidget( 'pedidos', new sfWidgetFormInput() );
	  	$this->setValidator( 'pedidos', new sfValidatorPass() );
	  	
	  	$this->getWidgetSchema()->setNameFormat('enviarPedidosCampanaAOcaForm[%s]');
  	}

	public function execute()
	{
		$idCampana = $this->getValue('campana');
		$idsPedido = $this->getValue('pedidos');
		
		set_time_limit(0);
				
		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
		
		$task = new Net_Gearman_Task ('EnviarPedidosCampanaAOcaWorker', array ('idCampana' => $idCampana, 'idsPedido' => $idsPedido) );
		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
		
		$set = new Net_Gearman_Set();
		$set->addTask ($task);
		
		$client->runSet($set);
	}
}