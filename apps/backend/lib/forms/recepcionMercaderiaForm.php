<?php

class recepcionMercaderiaForm extends sfFormSymfony
{
  	public function configure()
  	{
      $productos = $this->getOption('productos');
      $recepcion = $this->getOption('recepcion');
      $faltantes = $this->getOption('faltantes');
            
      foreach ($productos as $producto)
      {
        $faltante = isset( $faltantes[ $producto['id_producto_item'] ] ) ? $faltantes[ $producto['id_producto_item'] ] : 0;
        $cantidadARecibir = $producto['cantidad'] - ( $recepcion[ $producto['id_producto_item'] ]['cantidad'] + $faltante );

        $choices = array( 0 => 0 );
        for ( $i = 1 ; $i <= $cantidadARecibir ; $i++ ) {
          $choices[$i] = $i;
        }

        $this->setWidget( 'cantidad_recibida_' . $producto['id_producto_item'], new sfWidgetFormSelect( array('choices' => $choices ) ) );
        $this->setValidator( 'cantidad_recibida_' . $producto['id_producto_item'], new sfValidatorChoice( array('choices' => array_keys( $choices ), 'required' => false ) ) );
        $this->getWidget( 'cantidad_recibida_' . $producto['id_producto_item'])->setDefault( $cantidadARecibir );

        $this->setWidget( 'cantidad_faltante_' . $producto['id_producto_item'], new sfWidgetFormSelect( array('choices' => $choices ) ) );
        $this->setValidator( 'cantidad_faltante_' . $producto['id_producto_item'], new sfValidatorChoice( array('choices' => array_keys( $choices ), 'required' => false ) ) );
        $this->getWidget( 'cantidad_faltante_' . $producto['id_producto_item'])->setDefault( 0 );

        $this->setWidget( 'observacion_' . $producto['id_producto_item'], new sfWidgetFormTextArea());
        $this->setValidator( 'observacion_' . $producto['id_producto_item'], new sfValidatorString( array('required' => false) ) );
      }
            
      $this->getWidgetSchema()->setNameFormat('recepcionMercaderia[%s]');

      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback( array( 'callback' => array($this, 'validarCantidades')) )
      );

  	}

    public function validarCantidades($sfValidatorCallback, $values, $arguments)
    {        
      $productos = $this->getOption('productos');

      foreach ($productos as $producto)
      {
        $idProductoItem   = $producto['id_producto_item'];
        
        $cantidadMaxima   = $producto['cantidad'];
        $cantidadRecibida = $values['cantidad_recibida_' . $idProductoItem];
        $cantidadFaltante = $values['cantidad_faltante_' . $idProductoItem];

        if ( ($cantidadRecibida + $cantidadFaltante) > $cantidadMaxima ) {
          throw new sfValidatorError($this->getValidator('cantidad_recibida_' . $idProductoItem), 'required');
        }
      }
      
      return $values;
    }

  	
  	public function execute()
  	{
      $campana = $this->getOption('campana');
      $marca = $this->getOption('marca');
      $productos = $this->getOption('productos');

      $faltantes = array();

      $response = array('data' => array() );
      foreach ($productos as $producto)
      {
        $idProductoItem = $producto['id_producto_item'];        
        $cantidadRecibida = $this->getValue('cantidad_recibida_' . $idProductoItem );
        $cantidadFaltante = $this->getValue('cantidad_faltante_' . $idProductoItem );        
        $observacion = $this->getValue('observacion_' . $idProductoItem );

        if ( trim($observacion) ) {
          $response['data'][] = array(
            'producto' => $producto,
            'observacion' => $observacion
          );
        }

        $recepcionMercaderiaCampana = new recepcionMercaderiaCampana();
        $recepcionMercaderiaCampana->setIdCampana( $campana->getIdCampana() );
        $recepcionMercaderiaCampana->setIdProductoItem( $idProductoItem );
        $recepcionMercaderiaCampana->setCantidad( $cantidadRecibida );
        $recepcionMercaderiaCampana->setObservacion( $observacion );
        $recepcionMercaderiaCampana->save();


        if ( $cantidadFaltante > 0 ) {
          $faltantes[] = $idProductoItem . '-' . $cantidadFaltante;
        }

      }

      if ( count($response['data']) ) {
        $response['status'] = 'error';
      } else {
        $response['status'] = 'ok';
      }


      $subject = 'Recepción de Mercaderia de la Marca "' . $marca->getNombre() . '" en la Campaña "' . $campana->getDenominacion() . '"';
      $to = explode( ',', sfConfig::get('app_email_to_administracion') );
      $mailer = new Mailer('recepcionMercaderia', array( 'title' => $subject, 'response' => $response ));
      $mailer->send( $subject, $to);


      return $faltantes;
  	}
  	
}