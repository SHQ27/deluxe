<?php

class productosEditarPreciosForm extends sfFormSymfony
{
  	public function configure()
  	{  		  		
  		$productos = $this->getOption('productos');
  		
  		$this->setWidget('ids', new sfWidgetFormInputHidden());
  		$this->setValidator( 'ids', new sfValidatorPass());
  		
  		foreach ($productos as $producto)
  		{
		    $this->setWidget('precio_lista_' . $producto->getIdProducto(), new sfWidgetFormInput());
		    $this->setWidget('precio_normal_' . $producto->getIdProducto(), new sfWidgetFormInput());
		    $this->setWidget('precio_outlet_' . $producto->getIdProducto(), new sfWidgetFormInput());
		    $this->setWidget('costo_' . $producto->getIdProducto(), new sfWidgetFormInput());
		    
		    $this->getWidget('precio_lista_' . $producto->getIdProducto() )->setDefault( $producto->getPrecioLista() );
		    $this->getWidget('precio_normal_' . $producto->getIdProducto() )->setDefault( $producto->getPrecioDeluxe() );
		    $this->getWidget('precio_outlet_' . $producto->getIdProducto() )->setDefault( $producto->getPrecioDeluxe() );
		    $this->getWidget('costo_' . $producto->getIdProducto() )->setDefault( $producto->getCosto() );
		    
		    $this->setValidator( 'precio_lista_' . $producto->getIdProducto(), new sfValidatorNumber(array('required' => false)));
		    $this->setValidator( 'precio_normal_' . $producto->getIdProducto(), new sfValidatorNumber(array('required' => false)));
		    $this->setValidator( 'precio_outlet_' . $producto->getIdProducto(), new sfValidatorNumber(array('required' => false)));
		    $this->setValidator( 'costo_' . $producto->getIdProducto(), new sfValidatorNumber(array('required' => false)));
  		}
	    	    
		$this->getWidgetSchema()->setNameFormat('productosEditarPrecios[%s]');
  	}

	public function save()
	{
		$values = $this->getValues();
						
		$client = new Net_Gearman_Client ( array (sfConfig::get('app_gearman_ip') . ':' . sfConfig::get('app_gearman_port')  ) );
		$idUsuario = sfContext::getInstance()->getUser()->getGuardUser()->getId();
		
		$task = new Net_Gearman_Task ('EditPricesWorker', array ('values' => $values, 'idUsuario' => $idUsuario) );
		$task->type = Net_Gearman_Task::JOB_BACKGROUND;
		
		$set = new Net_Gearman_Set();
		$set->addTask ($task);
		
		$client->runSet ($set);
	}
}