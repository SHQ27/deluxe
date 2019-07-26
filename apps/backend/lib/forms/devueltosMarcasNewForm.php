<?php

class devueltosMarcasNewForm extends sfFormSymfony
{
  	public function configure()
  	{
        $pedidoProductoItems = $this->getOption('pedidoProductoItems');

        foreach ( $pedidoProductoItems as $pedidoProductoItem ) {

          $idPedidoProductoItem = $pedidoProductoItem->getIdPedidoProductoItem();

          $choices = array();
          for ( $i = 0 ; $i <= $pedidoProductoItem->getCantidad() ; $i++ ) {
            $choices[ $i ] = $i;
          }

    	    $this->setWidget( 'pedidoProductoItem_' . $idPedidoProductoItem  , new sfWidgetFormSelect( array( 'choices' => $choices ) ) );
    	    $this->setValidator( 'pedidoProductoItem_' . $idPedidoProductoItem, new sfValidatorChoice( array( 'choices' => array_keys($choices) ) ) );
        }


  	    $this->getWidgetSchema()->setNameFormat('devueltosMarcasNewForm[%s]');
  	}

  	
  	public function process()
  	{
        $pedidoProductoItems = $this->getOption('pedidoProductoItems');

        foreach ( $pedidoProductoItems as $pedidoProductoItem ) {

          $idPedidoProductoItem = $pedidoProductoItem->getIdPedidoProductoItem();
          $cantidad = $this->getValue( 'pedidoProductoItem_' . $idPedidoProductoItem );

          for ( $i = 0 ; $i < $cantidad ; $i++ ) {
            $devueltoMarca = new devueltoMarca();
            $devueltoMarca->setIdPedidoProductoItem( $idPedidoProductoItem );
            $devueltoMarca->setIdProductoItem( $pedidoProductoItem->getIdProductoItem() );
            $devueltoMarca->setDevuelto(false);
            $devueltoMarca->save();
          }

        }
  	}
  	
}