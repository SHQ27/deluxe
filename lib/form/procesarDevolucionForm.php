<?php

class procesarDevolucionForm extends sfFormSymfony
{		
  	public function configure()
  	{  		  		  		
  		$devolucion = $this->getOption('devolucion');

  		$this->setWidget('id_devolucion_motivo', new sfWidgetFormDoctrineChoice(array('model' => 'devolucionMotivo', 'order_by' => array('denominacion','asc') )));
  		$this->setValidator('id_devolucion_motivo', new sfValidatorDoctrineChoice(array('model' => 'devolucionMotivo')));
  		
  		$this->getWidget('id_devolucion_motivo')->setDefault( $devolucion->getIdDevolucionMotivo() );
  		
  		$this->setWidget('devolucion',  new pmWidgetDevolucion( array('devolucion' => $devolucion) ));
  		$this->setValidator('devolucion', new sfValidatorPass());
  		
	  	$this->setWidget('devolucion',  new pmWidgetDevolucion( array('devolucion' => $devolucion) ));
	  	$this->setValidator('devolucion', new sfValidatorPass());

	  	$choices['COMPLETO-TC'] = 'Pagó con TC, devolvemos Pago Completo';
	  	$choices['PARCIAL'] = 'Pagó con TC, devolvemos pago parcialmente';
	  	$choices['COMPLETO-EF'] = 'Pagó en efectivo, devolvemos pago completo';
	  	
	  	$this->setWidget( "opcion", new sfWidgetFormSelectRadio( array('choices' => $choices ) ));
	  	$this->setValidator('opcion', new sfValidatorPass());
	  	
	  	$this->setWidget( "mensaje", new sfWidgetFormTextarea());
	  	$this->setValidator('mensaje', new sfValidatorPass());
	  	
		$this->getWidgetSchema()->setNameFormat('procesarDevolucion[%s]');
  	}

	public function procesar()
	{
	    $conn = Doctrine_Manager::connection();
	    
	    try
	    {
	        $conn->beginTransaction();

	        $values = $this->getValues();
	        
	        $devolucion = $this->getOption('devolucion');
	        $devolucion->setIdDevolucionMotivo( $values['id_devolucion_motivo'] );
	        $devolucion->save();
	        
	        $valuesProductos = $values['devolucion']['producto'];
	        $valuesTalles = $values['devolucion']['talle'];
	        $valuesColores = $values['devolucion']['color'];
	        $valuesCantidad = $values['devolucion']['cantidad'];
	        $valuesCantidadDevueltos = ( isset($values['devolucion']['cantidad_devueltos'] ) ) ? $values['devolucion']['cantidad_devueltos'] : array();
	        $valuesCantidadFallados = ( isset($values['devolucion']['cantidad_fallados'] ) ) ? $values['devolucion']['cantidad_fallados'] : array();
	        $valuesDetalleFallados = ( isset($values['devolucion']['detalle_fallados'] ) ) ? $values['devolucion']['detalle_fallados'] : array();
	        
	        
	        $devolucionData = array();
	        $devolucionProductoItems = $devolucion->getDevolucionProductoItem();
	        foreach($devolucionProductoItems as $devolucionProductoItem)
	        {	
	        	$idProducto = $valuesProductos[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
	            $idTalle = $valuesTalles[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
	            $idColor = $valuesColores[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
	            $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem();	            
	            $cantidad = $valuesCantidad[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
	            $cantidadDevueltos = $valuesCantidadDevueltos[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
	            $cantidadFallados = $valuesCantidadFallados[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
	            
	            $productoItem = productoItemTable::getInstance()->getByCompoundKey($idProducto, $idTalle, $idColor);
	            
	            $devolucionProductoItem->setIdProductoItem( $productoItem->getIdProductoItem() );
	            $devolucionProductoItem->setCantidadStock( $cantidad );
	            $devolucionProductoItem->setCantidadFallados( $cantidadFallados );
	            $devolucionProductoItem->setCantidadDevueltosMarcas( $cantidadDevueltos );
	            $devolucionProductoItem->save();
	        
	            $devolucionData[$idProducto] = array();
	            
	            // Creo los fallados
	            if ( $devolucionProductoItem->getCantidadFallados() >= 1 )
                {
                    $detalleFallados = $valuesDetalleFallados[ $devolucionProductoItem->getIdDevolucionProductoItem() ];
                    
    	            for ($i = 0 ; $i < $cantidadFallados ; $i++)
    	            {
    	                if ( $pedidoProductoItem->getCosto() > 0 )
                        {                            
        	                $fallado = new fallado();
        	                $fallado->setIdPedidoProductoItem( $pedidoProductoItem->getIdPedidoProductoItem() );
        	                $fallado->setIdProductoItem( $productoItem->getIdProductoItem() );
        	                $fallado->setDescripcion( $detalleFallados[$i] );
        	                $fallado->setRecuperado(false);
        	                $fallado->setIdEshop( $devolucion->getIdEshop() );
        	                $fallado->save();
                        }
    	            }
                }

                // Creo las devoluciones pendientes a marcas
                for ($i = 0 ; $i < $cantidadDevueltos ; $i++)
                {
                    $devueltoMarca = new devueltoMarca();
                    $devueltoMarca->setIdPedidoProductoItem( $pedidoProductoItem->getIdPedidoProductoItem() );
                    $devueltoMarca->setIdProductoItem( $productoItem->getIdProductoItem() );
                    $devueltoMarca->setDevuelto(false);
                    $devueltoMarca->save();
                }
                
                
	        }
	        
	        $devolucion->devolverStock();
	        
	        if ($devolucion->getTipoCredito() == devolucion::envio_deluxe)
	        {
	            $this->crearBonificacion($devolucion);
	        }
	        else
	        {
	            $this->enviarMailGestionMP($devolucion, $values);
	        }
	        
	        $devolucion->setFechaCierre( new Doctrine_Expression('now()') );
	        $devolucion->save();
	        	        	        
	        $conn->commit();
	    
	        return true;
	    }
	    catch(Doctrine_Exception $e)
	    {
	        $conn->rollback();
	        return false;
	    }
	}

	
	protected function crearBonificacion($devolucion)
	{	
	    $montosDevolucion = $devolucion->calcularMontoTotal(true);
	    $valor = $montosDevolucion['total'];	    
	    
	    $this->asentarCronologico( $devolucion, $montosDevolucion );
	    
		// Se crea la bonificacion
		$bonificacion = new bonificacion();
		$bonificacion->setIdUsuario( $devolucion->getIdUsuario() );
		$bonificacion->setIdTipoDescuento( tipoDescuento::MONTOFIJO );
		$bonificacion->setIdTipoBonificacion( tipoBonificacion::REINTEGRO );
		$bonificacion->setValor( $valor );
		$bonificacion->setObservaciones( 'Bonificacion asociada a la devolucion #' . $devolucion->getIdDevolucion() );
		$bonificacion->save();
		
		$devolucion->setIdBonificacion( $bonificacion->getIdBonificacion() );
		
		$devolucion->setMontoTotal( $valor );		
		$devolucion->save();
		
		$usuario = $devolucion->getUsuario();
		
		$subject = 'Se ha completado el proceso de devolucion';
		$vars = array( 'title' => $subject, 'usuario' => $usuario );
		$mailer = new Mailer('devolucionCreditoDeluxe', $vars);
		$mailer->send( $subject, $usuario->getEmail() );
		
		// Realizo la nota de credito por la devolucion
		$idsPedido = devolucionTable::getInstance()->getIdsPedidoByIdDevolucion( $devolucion->getIdDevolucion() );
		ncreditoTable::getInstance()->insert( $idsPedido, $valor );
		
	}
	
	protected function enviarMailGestionMP($devolucion, $values)
	{
		$usuario = $devolucion->getUsuario();
				
		if ( $devolucion->getIdEshop() ) {
		    $eshop = $devolucion->getEshop();
		    $from = $eshop->getEmailNoReply();
		    $tipoMail  = 'ESHOP';
		} else {
		    $eshop = false;
		    $from = sfConfig::get('app_email_from_noreply');
		    $tipoMail  = 'DELUXE';
		}
		
		$subject = 'Se ha completado el proceso de devolucion';
		$vars = array( 'eshop'   => $eshop, 'title' => $subject, 'usuario' => $usuario, 'texto' => nl2br($values['mensaje']) );
		$mailer = new Mailer('devolucionCreditoMp' . $tipoMail, $vars);
		$mailer->send( $subject, $usuario->getEmail(), $from );
						
		// Asiento el movimiento en el cronologico
		$montosDevolucion = $devolucion->calcularMontoTotal(true);
		$valor = $montosDevolucion['total'];
		 
		$this->asentarCronologico( $devolucion, $montosDevolucion );

		$idsPedido = devolucionTable::getInstance()->getIdsPedidoByIdDevolucion( $devolucion->getIdDevolucion() );
		
		// Si la devolucion no es de eShop, genero una nota de credito
		if ( !$devolucion->getIdEshop() ) {
		    ncreditoTable::getInstance()->insert( $idsPedido, $valor );
	    // Si es de eshop, genero un recibo de tipo nota de credito
		} else {
		    reciboEshopTable::getInstance()->insert( $devolucion->getIdEshop(), $idsPedido, $valor, reciboEshop::TIPO_NOTA_DE_CREDITO );
		}
	}
	
	
	protected function asentarCronologico($devolucion, $montosDevolucion)
	{	    
	    reporteCronologicoTable::getInstance()->save(reporteCronologico::DEVOLUCION, array( 'idDevolucion' => $devolucion->getIdDevolucion(), 'montosDevolucion' => $montosDevolucion, 'eshop' => $devolucion->getEshop() ) );
	}
	
}