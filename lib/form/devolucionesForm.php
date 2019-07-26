<?php

class devolucionesForm extends sfFormSymfony
{		
        
  	public function configure()
  	{  		  		
  		$this->validatorSchema->setOption('allow_extra_fields', true);
  		$this->validatorSchema->setOption('filter_extra_fields', false);
  		
	  	$this->setWidget( 'pedido_producto_item[id]', new sfWidgetFormInputCheckbox() );
	  	$this->setValidator('pedido_producto_item[id]', new sfValidatorPass() );
	  	
	  	$this->setWidget( 'pedido_producto_item[cantidad]', new sfWidgetFormSelect( array('choices' => array() ) ) );
	  	$this->setValidator('pedido_producto_item[cantidad]', new sfValidatorPass() );
	  		  	
	  	$choices = array( devolucion::credito_deluxe  => '', devolucion::credito_mp => '');
	  	$this->setWidget( 'credito', new sfWidgetFormSelectRadio( array('choices' => $choices) ) );
	  	$this->setValidator('credito', new sfValidatorChoice( array('choices' => array_keys($choices)) ) );
	  	
	  	$choices = array(devolucion::envio_deluxe => '', devolucion::envio_oca => '');
	  	$this->setWidget( 'entrega', new sfWidgetFormSelectRadio( array('choices' => $choices) ) );
	  	$this->setValidator('entrega', new sfValidatorChoice( array('choices' => array_keys($choices)) ) );
	  	
	  	$this->setWidget( 'nombre', new sfWidgetFormInput( array(), array('maxlength' => 30) ) );
	  	$this->setValidator('nombre', new sfValidatorString(array('required' => false, 'max_length' => 30) ) );
	  	
	  	$this->setWidget( 'apellido', new sfWidgetFormInput( array(), array('maxlength' => 30) ) );
	  	$this->setValidator('apellido', new sfValidatorString(array('required' => false, 'max_length' => 30) ) );
	  	
	  	$this->setWidget( 'calle', new sfWidgetFormInput( array(), array('maxlength' => 30) ) );
	  	$this->setValidator('calle', new sfValidatorString(array('required' => false, 'max_length' => 30) ) );
	  	
	  	$this->setWidget( 'numero', new sfWidgetFormInput( array(), array('maxlength' => 5) ) );
	  	$this->setValidator('numero', new sfValidatorString(array('required' => false, 'max_length' => 5) ) );
	  	
	  	$this->setWidget( 'piso', new sfWidgetFormInput( array(), array('maxlength' => 6) ) );
	  	$this->setValidator('piso', new sfValidatorString(array('required' => false, 'max_length' => 6) ) );
	  	
	  	$this->setWidget( 'dpto', new sfWidgetFormInput( array(), array('maxlength' => 4) ) );
	  	$this->setValidator('dpto', new sfValidatorString(array('required' => false, 'max_length' => 4) ) );
	  	
	  	$choices = devolucionMotivoTable::getInstance()->findAll( 'HYDRATE_KEY_VALUE_PAIR' );
	  	$otros = $choices['OTROS'];
	  	unset($choices['OTROS']);
	  	$choices['OTROS'] = $otros;	  	
	  	
	  	$this->setWidget( 'motivo', new sfWidgetFormSelect( array('choices' => $choices) ) );
	  	$this->setValidator('motivo', new sfValidatorDoctrineChoice(array('model' => 'devolucionMotivo') ) );
	  	
	  	$this->setWidget( 'motivo_abierto', new sfWidgetFormTextarea( array(), array('placeholder' => 'Describí aquí el motivo de la devolución')  ) );
	  	$this->setValidator('motivo_abierto', new sfValidatorString(array('required' => false) ) );
	  	
	  	$choicesProvincia = array();
	  	$provincias = provinciaTable::getInstance()->listAll();
	  	foreach ($provincias as $provincia)
	  	{
	  		$choicesProvincia[ $provincia->getIdProvincia() ] = $provincia->getNombre();
	  	}
	  	
	  	$this->setWidget( 'id_provincia', new sfWidgetFormSelect( array('choices' => $choicesProvincia ) ) );
	  	$this->setValidator('id_provincia', new sfValidatorString(array('required' => false) ) );
	  	
		$this->setWidget( 'localidad', new sfWidgetFormInput( array(), array('maxlength' => 50) ) );
	  	$this->setValidator('localidad', new sfValidatorString(array('required' => false, 'max_length' => 50) ) );
	  	
	  	$this->setWidget( 'codigo_postal', new sfWidgetFormInput( array(), array('maxlength' => 8) ) );
	  	$this->setValidator('codigo_postal', new sfValidatorString(array('required' => false, 'max_length' => 8) ) );
	  	
		$this->getWidgetSchema()->setNameFormat('devoluciones[%s]');
  	}

	public function procesar( $eshop )
	{
	    $idEshop = ( $eshop ) ? $eshop->getIdEshop() : null;
	    
		$values = $this->getValues();

		$conn = Doctrine_Manager::connection();
		
		try
		{
			$conn->beginTransaction();
		
			$user = sfContext::getInstance()->getUser()->getCurrentUser();
			
			$devolucion = new devolucion();
			$devolucion->setIdUsuario( $user->getIdUsuario() );
			$devolucion->setTipoEnvio( $values["entrega"] );
			
			if ( $idEshop ) {
			    $devolucion->setTipoCredito( devolucion::credito_mp );
			} else {
			    $devolucion->setTipoCredito( $values["credito"] );
			}
			
			$devolucion->setNombre( $values["nombre"] );
			$devolucion->setApellido( $values["apellido"] );
			$devolucion->setCalle( $values["calle"] );
			$devolucion->setNumero( $values["numero"] );
			$devolucion->setPiso( $values["piso"] );
			$devolucion->setDpto( $values["dpto"] );
			$devolucion->setCodigoPostal( $values["codigo_postal"] );
			$devolucion->setIdProvincia( $values["id_provincia"] );
			$devolucion->setLocalidad( $values["localidad"] );
			$devolucion->setIdDevolucionMotivo( $values["motivo"] );
			$devolucion->setMotivoOtro( $values["motivo_abierto"] );
			
			$devolucion->setIdEshop( $idEshop );
			
			$devolucion->save();
	
			foreach ($values["pedido_producto_item_id"] as $i => $idPedidoProductoItem )
			{
				$cantidad = $values["pedido_producto_item_cantidad"][$i];				
				
				$devolucionProductoItem = new devolucionProductoItem();
				$devolucionProductoItem->setIdDevolucion( $devolucion->getIdDevolucion() );
				$devolucionProductoItem->setIdPedidoProductoItem( $idPedidoProductoItem );
				$devolucionProductoItem->setCantidad( $cantidad );
				$devolucionProductoItem->save();
			}
		
			if ( $values["entrega"] == devolucion::envio_deluxe )
			{
			    $fileForm = ( !in_array( $devolucion->getIdDevolucionMotivo() , array('INCOR','FALLA') ) ) ? 'formulario_de_devolucion_01.doc' : 'formulario_de_devolucion_02.doc';
			    
				$subject = 'Se ha dado inicio al proceso de devolucion';
				$vars = array( 'eshop' => $eshop, 'title' => $subject, 'usuario' => $user, 'fileForm' => $fileForm );
				$mailer = new Mailer('devolucionEntregaDeluxe', $vars);
				$from = ( $eshop ) ? $eshop->getEmailNoReply() : sfConfig::get('app_email_from_noreply');
				$mailer->send( $subject, $user->getEmail(), $from );
			}
			
			$conn->commit();
		
			return true;
		}
		catch(Doctrine_Exception $e)
		{
			$conn->rollback();
			return false;
		}
		
		
	
	}
	
}