<?php

class reporteAdNetworksForm extends sfFormSymfony
{
  	public function configure()
  	{  		
		$this->setWidget('pedidos', new sfWidgetFormTextarea());
		$this->getWidget('pedidos')->setLabel('Pedidos<br />Separados por [Enter]');
		$this->setValidator('pedidos', new sfValidatorString(array('required' => true)));
		
		$choices = array();
		for ( $i = 0 ; $i <= 100 ; $i++ ) $choices[$i] = $i . '%';
		
        $this->setWidget('porcentaje_nuevos', new sfWidgetFormSelect( array('choices' => $choices) ) );
        $this->getWidget('porcentaje_nuevos')->setLabel('Porc. a pagar por Usuarios Nuevos');
	    $this->setValidator('porcentaje_nuevos', new sfValidatorPass() );
	    
	    $this->setWidget('porcentaje_recurrentes', new sfWidgetFormSelect( array('choices' => $choices) ) );
	    $this->getWidget('porcentaje_recurrentes')->setLabel('Porc. a pagar por Usuarios Recurrentes');
	    $this->setValidator('porcentaje_recurrentes', new sfValidatorPass() );
	    
		$this->getWidgetSchema()->setNameFormat('reporteAdNetworks[%s]');
  	}

	public function generar()
	{
		set_time_limit(0);
		
		$values = $this->getValues();
		
		$arr = explode("\n", $values['pedidos']);
		
		$idsPedido = array();
		foreach ( $arr as $idPedido )
		{
		    $idPedido = trim($idPedido);
		    if ( $idPedido ) $idsPedido[] = $idPedido;
		}
		
		$porcentajeNuevos = $values['porcentaje_nuevos'];
		$porcentajeRecurrentes = $values['porcentaje_recurrentes'];
		
		
		$pedidos = pedidoTable::getInstance()->listByIds($idsPedido);
		
		$nuevos = array();
		$recurrentes = array();
		$montoNuevos = 0;
		$montoRecurrentes = 0;
		foreach ($pedidos as $pedido)
		{
		    $esPrimerPedidoPagado = pedidoTable::getInstance()->haComprado( $pedido->getIdUsuario() );
		    
		    $monto = $pedido->getMontoTotal() - $pedido->getMontoEnvio();
		    $monto = ( $monto > 0 ) ? $monto : 0;
		    
		    if( $esPrimerPedidoPagado )
		    {
		        $nuevos[] = $pedido->getIdPedido();
		        $montoNuevos += $monto;
		    }
		    else
		    {
		        $recurrentes[] = $pedido->getIdPedido();
		        $montoRecurrentes += $monto;
		    }
		}

		$resultado = array();
		$resultado['nuevos_cantidad'] = count($nuevos);
		$resultado['nuevos_ids'] = $nuevos;
		$resultado['nuevos_monto_total'] = $montoNuevos;
		$multiplicador = ( $porcentajeNuevos ) ? $porcentajeNuevos / 100 : 0;
		$resultado['nuevos_comision'] = round($montoNuevos * $multiplicador, 2);
		$resultado['nuevos_porcentaje'] = $porcentajeNuevos;
		
		$resultado['recurrentes_cantidad'] = count($recurrentes);
		$resultado['recurrentes_ids'] = $recurrentes;
		$resultado['recurrentes_monto_total'] = $montoRecurrentes;
		$multiplicador = ( $porcentajeRecurrentes ) ? $porcentajeRecurrentes / 100 : 0;
		$resultado['recurrentes_comision'] = round($montoRecurrentes * $multiplicador, 2);
		$resultado['recurrentes_porcentaje'] = $porcentajeRecurrentes;
		
		return $resultado;
	}
}