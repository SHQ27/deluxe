<?php

class desactivarTask extends deluxebuysBaseTask
{
    protected $fechaHoy;
    protected $horaActual;
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name             = 'desactivar';
		$this->briefDescription = 'Desactiva campanas y outlet y maneja el stock de devoluciones pendientes';
		$this->addOption('fecha', null, sfCommandOption::PARAMETER_OPTIONAL, 'Fecha de ejecucion (Y-m-d)', false);
		$this->addOption('hora', null, sfCommandOption::PARAMETER_OPTIONAL, 'Hora de ejecucion (H:i)', false);
		$this->detailedDescription = <<<EOF
La tarea [desactivar|INFO] desactiva campanas y outlet y maneja el stock de devoluciones pendiente
Call it with: [php symfony deluxebuys:desactivar|INFO]
EOF;
	}

	public function doExecute($arguments = array(), $options = array())
	{	    
	    $this->fechaHoy = ( $options['fecha'] ) ? $options['fecha'] : date('Y-m-d', strtotime('today') );
	    $this->horaActual = ( $options['hora'] ) ? $options['hora'] : date('H:i');
	    	    	    
		$this->desactivarCampanas();
		
		$this->desactivarOutlet();
	}
	
	protected function desactivarCampanas()
	{
	    $horasDesactivar = cacheHelper::getInstance()->get( 'campanas_a_desactivar_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ) );
	     
	    if ( !$horasDesactivar )
	    {
	        $row = array();
	        	         
	        $finalizan = campanaTable::getInstance()->listByFechaFin( $this->fechaHoy );
	        foreach($finalizan as $campana) {
	            $row[ date('H:i', strtotime( $campana->getFechaFin() )) ] = true;
	        }
	    
	        $horasDesactivar = array_keys($row);
	        $horasDesactivar = json_encode($horasDesactivar);
	        	
	        cacheHelper::getInstance()->set( 'campanas_a_desactivar_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ), $horasDesactivar);
	    }
	     
	    $horasDesactivar = json_decode($horasDesactivar);
	    
	    $result = in_array($this->horaActual, $horasDesactivar);
	    
	    if ( $result !== false)
	    {
	        $fechaFin = $this->fechaHoy . ' ' . $this->horaActual;
	        $campanas = campanaTable::getInstance()->listByFechaHoraFin( $fechaFin );
	        foreach($campanas as $campana) {
	            $this->doDesactivarCampana($campana);
	        } 
	    }
	}
	    
    protected function doDesactivarCampana($campana)
    {
	    
	    $conn = Doctrine_Manager::connection();
	    
	    $this->log('Se inicia desactivado de la campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');	    
	    try
	    {
	        $conn->beginTransaction();
	    	         
	        $campana->setActivo(false);
	        $campana->save();
	         
	        $productoCampanas = productoCampanaTable::getInstance()->listByIdCampana($campana->getIdCampana());
	         
	        foreach($productoCampanas as $productoCampana)
	        {
	            $producto = $productoCampana->getProducto();	             
	            $producto->setActivo(false);
	            $producto->setEsOutlet(false);
	             
	            $producto->doNotPostActions( array( 
				    producto::POST_ACTION_UPDATE_PRECIO,
				    producto::POST_ACTION_UPDATE_ML,
				    producto::POST_ACTION_UPDATE_STOCK
	            ) );
	            
	            $producto->save();
	        }
	         
	        $this->log('Se desactivo la campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	         	    
	        $conn->commit();
	        
	        $this->emailFinalizacionCampana($campana);
	        $this->emailFallados($campana);
	    
	        $this->log('Finaliza el desactivado de la campaña #' . $campana->getIdCampana() . ' (' . $campana->getDenominacion() . ')');
	        
	    }
	    catch(Doctrine_Exception $e)
	    {
	        errorLogHelper::getInstance()->cronErrorEmail('desactivar', $e->getMessage() );
	        $this->log('Hubo problemas al desactivar la campaña "' . $campana->getDenominacion() . '"');
	        $conn->rollback();
	    }
	}
		
	
	protected function emailFinalizacionCampana($campana)
	{
	    $pedidos = pedidoTable::getInstance()->listMailFinalizacionCampana( $campana->getIdCampana() );
	    foreach( $pedidos as $pedido )
	    {
	        $usuario = $pedido->getUsuario();
	    
	        $subject = 'La campaña ' . $campana->getDenominacion() . ' en la que compraste ha finalizado';
	        $mailer = new Mailer('finalizacionCampana', array( 'title' => $subject, 'usuario' => $usuario, 'campana' => $campana, 'pedido' => $pedido ));
	        $mailer->send( $subject, $pedido->getEmail() );
	    
	        $this->log('Se envió el mail de finalización de campaña al pedido #' . $pedido->getIdPedido() );
	    }
	}
	
	protected function emailFallados($campana)
	{
	    $campanaMarcas = $campana->getCampanaMarca();
	    
	    foreach( $campanaMarcas as $campanaMarca )
	    {
	        $marca = $campanaMarca->getMarca();
	        $fallados = falladoTable::getInstance()->listFallados( $marca->getIdMarca(), eshop::ESHOP_DELUXE );
	        
	        if ( count($fallados) )
	        {
    	        $subject = 'Fallados de la marca ' . $marca->getNombre() . ' al dia de hoy';
    	        $mailer = new Mailer('falladosMarca', array( 'title' => $subject, 'marca' => $marca, 'fallados' => $fallados));
    	        $to = explode( ',', sfConfig::get('app_email_to_administracion') );
    	        $mailer->send( $subject, $to );
    	        
    	        $this->log('Se envió el mail de fallados de la marca "' . $marca->getNombre() . '"' );
	        }
	    }
	}
	
	protected function desactivarOutlet()
	{
	    $fechaFin = cacheHelper::getInstance()->get( 'outlet_a_desactivar_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ) );
	
	    if ( !$fechaFin )
	    {
	        $outlet = configuracionTable::getInstance()->getOutlet();
	        $outletData = json_decode($outlet->getValor(), true);
	         
	        $fechaFin = date('Y-m-d H:i', strtotime( $outletData['fecha_fin'] ) );
	        	
	        cacheHelper::getInstance()->set( 'outlet_a_desactivar_' . cacheHelper::getInstance()->genKey( $this->fechaHoy ), $fechaFin);
	    }	    	     
	    
	    if ( $this->fechaHoy . ' ' . $this->horaActual == $fechaFin )
        {
	        $this->doDesactivarOutlet();
	    }
	}
	
	public function doDesactivarOutlet()
	{
	    $conn = Doctrine_Manager::connection();
	
	    $this->log('Se inicia desactivado de Outlet');
	    
	    try
	    {
	        $conn->beginTransaction();
	        
	        $outlet = configuracionTable::getInstance()->getOutlet();
	
	        $data = json_decode($outlet->getValor(), true);
	        $data['activo'] = false;
	        
	        $outlet->setValor( json_encode($data) );
  	    	$outlet->save();
	
  	    	$productos = productoTable::getInstance()->listActivosEnOutlet();
  	    	 
  	    	foreach($productos as $producto)
  	    	{
  	    	    $producto->setActivo(false);
  	    	     
  	    	    $producto->doNotPostActions( array(
  	    	        producto::POST_ACTION_UPDATE_PRECIO,
  	    	        producto::POST_ACTION_UPDATE_ML
  	    	    ) );
  	    	     
  	    	    $producto->save();

  	    	    productoLogTable::getInstance()->generate($producto->getIdProducto(), 'Se desactivo porque finalizó el outlet al que estaba asignado.');
  	    	}

  	    	$this->log('Finaliza el desactivado del outlet y sus productos asociados.');

  	    	$conn->commit();
	
	    }
	    catch(Doctrine_Exception $e)
	    {
	        errorLogHelper::getInstance()->cronErrorEmail('desactivar-outlet', $e->getMessage() );
	        	
	        $this->log('Hubo problemas al desactivar el outlet');
	        $conn->rollback();
	    }
	}
	
}