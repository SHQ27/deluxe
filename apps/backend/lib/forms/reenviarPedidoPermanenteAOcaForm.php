<?php

class reenviarPedidoPermanenteAOcaForm extends sfFormSymfony
{
  	public function configure()
  	{  		  	    
  	    $this->setWidget('id_pedido', new sfWidgetFormInputHidden());
  	    $this->setValidator('id_pedido', new sfValidatorPass() );
  	    
  	    $this->setWidget('cantidades', new sfWidgetFormInputHidden());
  	    $this->setValidator('cantidades', new sfValidatorPass() );

  	    $this->getWidgetSchema()->setNameFormat('reenviarPedidoPermanenteAOca[%s]');
  	}

  	
  	public function reenviar()
  	{  	    
  	    $idPedido = $this->getValue('id_pedido');
  	    $cantidades = $this->getValue('cantidades');
  	    
  	    $pedido = pedidoTable::getInstance()->getByIdPedido( $idPedido );
  	    
  	    $items = array();
  	    foreach( $cantidades as $idPedidoProductoItem => $cantidad )
  	    {
  	        $pedidoProductoItem = pedidoProductoItemTable::getInstance()->findOneByIdPedidoProductoItem( $idPedidoProductoItem );
  	        $productoItem = $pedidoProductoItem->getProductoItem();
  	        
  	        if ( $cantidad > 0 )
  	        { 
      	        $row = array();
      	        $row['producto'] = $productoItem->getProducto();
      	        $row['productoItem'] = $productoItem;
      	        $row['cantidad'] = $cantidad;
      	        $items[] = $row;
  	        }
  	    }
  	    
  	    return Oca::getInstance()->enviarPedido($pedido, $items );
  	}
  	
}