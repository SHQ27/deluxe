<?php

class generarPremiosTask extends deluxebuysBaseTask
{
	
    protected function configure()
    {
        parent::preConfigure();

        $this->name             = 'generar-premios';
        $this->briefDescription = 'Genera bonificaciones de acuerdo a los premios definidos';
        $this->detailedDescription = <<<EOF
La tarea [generar-premios|INFO] genera bonificaciones de acuerdo a los premios definidos
Call it with: [php symfony deluxebuys:generar-premios|INFO]
EOF;
    }

    public function doExecute($arguments = array(), $options = array())
    {
        $this->log('--- Comienzo de ejecucion: "generarPremios"');

        $fechaPago  = date( 'Y-m-d', strtotime('-1day') );
        
        $cachePremios = array();
        
        $pedidos = pedidoTable::getInstance()->listPagadosIn( $fechaPago, null );        
                
        $bonificacionesGeneradas = 0;
                
        foreach ( $pedidos as $pedido )
        {            
            $premioExistente = premioLogTable::getInstance()->findOneByIdPedido( $pedido->getIdPedido() );
                        
            // Si ya se le otorgo un premio se excluye al pedido
            if ( $premioExistente ) continue;
            
            // Busco los premios vigentes al momento en que se realizó el pedido
            if ( !isset($cachePremios[$pedido->getFechaAlta()]) )
            {
                $premios = premioTable::getInstance()->listVigentes( $pedido->getFechaAlta() );
                $cachePremios[$pedido->getFechaAlta()] = $premios;
            }
            else
            {
                $premios = $cachePremios[$pedido->getFechaAlta()];
            }
            
            $monto = $pedido->getMontoProductos() - $pedido->getMontoBonificacion() - $pedido->getMontoDescuento();
            
            $premioAplicable = null;
            foreach( $premios as $premio )
            {       
                
                if ($premio->getMontoMinimo() < $monto)
                {
                    $premioAplicable = $premio;
                    break;
                }
            }
            
            if ( $premioAplicable )
            {                
                $diasVencimiento = ( $premioAplicable->getDiasVencimiento() ) ? $premioAplicable->getDiasVencimiento() : 30;
                
                $bonificacion = new bonificacion();
                $bonificacion->setIdUsuario( $pedido->getIdUsuario() );
                $bonificacion->setIdTipoDescuento( tipoDescuento::MONTOFIJO );
                $bonificacion->setIdTipoBonificacion( tipoBonificacion::PREMIO );
                
                if ( $premioAplicable->getTipoPremio() == 'MFIJO' )
                {
                    $valor = $premioAplicable->getValor();
                }
                else
                {
                    $valor = $monto * ( $premioAplicable->getValor() / 100 );                    
                }
                
                $bonificacion->setValor( $valor );
                
                $bonificacion->setFueUtilizada( false );
                $bonificacion->setVencimiento( date( 'Y-m-d', strtotime('+' . $diasVencimiento . 'day') ) );
                $bonificacion->save();
                
                $premioLog = new premioLog();
                $premioLog->setIdPremio( $premioAplicable->getIdPremio() );
                $premioLog->setIdBonificacion( $bonificacion->getIdBonificacion() );
                $premioLog->setIdPedido( $pedido->getIdPedido() );
                $premioLog->save();

                $usuario = $pedido->getUsuario();
                
                $subject = 'Ya está disponible tu bonificación';
                $vars = array( 'title' => $subject, 'usuario' => $usuario, 'idPedido' => $pedido->getIdPedido() );
                $mailer = new Mailer('premioGenerado', $vars);
                $mailer->send( $subject, $usuario->getEmail() );
                
                $bonificacionesGeneradas++;
            }
        } 
        
        $this->log('Se generaron ' . $bonificacionesGeneradas . ' bonificaciones.');        
        
        $this->log('--- Fin de ejecucion: "generarPremios"');
    }
}