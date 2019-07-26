<?php

class recepcionMercaderiaEshopForm extends sfFormSymfony
{
  	public function configure()
  	{
      $productos = $this->getOption('productos');
            
      foreach ($productos as $producto)
      {
        $choices = array( 0 => 0 );
        for ( $i = 1 ; $i <= $producto['cantidadARecibir'] ; $i++ ) {
          $choices[$i] = $i;
        }

        $this->setWidget( 'cantidad_recibida_' . $producto['id_producto_item'], new sfWidgetFormSelect( array('choices' => $choices ) ) );
        $this->setValidator( 'cantidad_recibida_' . $producto['id_producto_item'], new sfValidatorChoice( array('choices' => array_keys( $choices ), 'required' => false ) ) );
        $this->getWidget( 'cantidad_recibida_' . $producto['id_producto_item'])->setDefault( $producto['cantidadARecibir'] );
      }
            
      $this->getWidgetSchema()->setNameFormat('recepcionMercaderiaEshop[%s]');

  	}

  	
  	public function execute()
  	{
      $productos = $this->getOption('productos');

      $nuevosFaltantes = array();
      foreach ($productos as $producto)
      {
        $idProductoItem   = $producto['id_producto_item'];

        $faltante = isset( $faltantes[ $idProductoItem ] ) ? $faltantes[ $idProductoItem ] : 0;

        $cantidadRecibida = $this->getValue('cantidad_recibida_' . $idProductoItem );
        $cantidadFaltante = $producto['cantidadARecibir'] - $cantidadRecibida;
        
        if ( $cantidadFaltante > 0 ) {
          $nuevosFaltantes[] = $idProductoItem . '-' . $cantidadFaltante;
        }

      }

      return $nuevosFaltantes;
  	}
  	
}