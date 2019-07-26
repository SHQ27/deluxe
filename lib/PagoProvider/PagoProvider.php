<?php

abstract class PagoProvider
{
    static protected $instance = array();

	public static function getInstance($idFormaPago)
	{
		$class = self::getClassName( $idFormaPago );

		if ( !isset( self::$instance[$class] ) )
		{
			self::$instance[$class] = new $class();
		}

		return self::$instance[$class];
	}

	abstract public function doCheckout( $pedido, $proveedorPago = null, $params = array() );
	abstract public function makeResponse( $data );
	abstract public function procesar( $pagoNotificacion );

	protected function procesarPedidoAprobado( $pedido, $pagoNotificacion )
	{
	    $proveedorPagoResponse = $pagoNotificacion->getResponseArray();
	    
	    if ( !$pedido->getFechaPago() )
	    {
	        if( $pedido->procesarPago($proveedorPagoResponse) )
	        {
	            $pagoNotificacion->addMensaje('Se marcó como pagado el pedido ' . $pedido->getIdPedido() . ', y se envío el mail.');
	        }
	        else
	        {
	            $pagoNotificacion->addMensaje('Se informó el pedido ' . $pedido->getIdPedido() . ' como pagado, pero no se pudo marcar.');
	        }
	    }
	    else
	    {
	        $pagoNotificacion->addMensaje('Se informó el pedido ' . $pedido->getIdPedido() . ' como pagado, no se realizó acción porque ya está marcado como pagado.');
	    }

	    return $proveedorPagoResponse['estado'];
	}
	
	protected function procesarPedidoRechazado( $pedido, $pagoNotificacion, $gestionarStock = true )
	{
	    $proveedorPagoResponse = $pagoNotificacion->getResponseArray();
	    
	    if ( !$pedido->getFechaBaja() )
	    {
	        if( $pedido->procesarBaja( null, $gestionarStock) )
	        {
	            $pagoNotificacion->addMensaje('Se dio de baja el pedido ' . $pedido->getIdPedido() . '.');
	        }
	        else
	        {
	            $pagoNotificacion->addMensaje('No se pudo dar de baja el pedido ' . $pedido->getIdPedido() . '.');
	        }
	    }
	    else
	    {
	        $pagoNotificacion->addMensaje('No se realizó acción (el pedido ' . $pedido->getIdPedido() . ' ya estaba eliminado).');
	    }

	    return $proveedorPagoResponse['estado'];
	}

	protected static function getClassName( $idFormaPago )
	{
		switch( $idFormaPago )
		{
	        case FormaPago::MERCADOPAGO: return 'MercadoPago';
	        case FormaPago::NPS:		 return 'NPS';
	        case FormaPago::DECIDIR:	 return 'Decidir';
		}
	}
    
}
