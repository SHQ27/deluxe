<?php


class faltanteTable extends Doctrine_Table
{
    
    /**
     * Retorna una instancia de faltanteTable;
     *
     * @return faltanteTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('faltante');
    }
        
    /**
     * Retorna todos los faltantes que coinciden con el array de idsPedido enviado por parametro
     *
     * @return Doctrine_Collection
     */
    public function listByIdsPedido( $idsPedido )
    {
        return $this->createQuery('f')
        ->whereIn('f.id_pedido', $idsPedido)
        ->execute();
    }

    /**
     * Retorna un array indexado de pedidos con faltantes para un $idCampana
     *
     * @return Doctrine_Collection
     */
    public function getDataByIdCampana($idCampana)
    {
        $data = $this->createQuery('f')
                     ->select('f.id_pedido, f.id_producto_item, sum(f.cantidad) as cantidad')
                     ->innerJoin('f.pedido p')
                     ->innerJoin('p.pedidoProductoItem ppi')
                     ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                     ->addWhere('p.fecha_envio IS NULL')
                     ->addWhere('p.codigo_envio IS NULL')
                     ->addWhere('p.fecha_pago IS NOT NULL')
                     ->addWhere('p.fecha_baja IS NULL')
                     ->addWhere('p.tipo_producto = ?', pedido::PRODUCTO_TIPO_OFERTA)
                     ->addWhere('ppic.id_campana = ?', $idCampana)
                     ->groupBy('f.id_pedido, f.id_producto_item')
                     ->fetchArray();

        $response = array();
        foreach ($data as $row) {
            $response[ $row['id_pedido'] ][ $row['id_producto_item'] ] = $row['cantidad'];
        }

        return $response;
    }
    
    /**
     * Dado un faltante lo procesa generando una bonificacion al usuario
     *
     */
    public function generarBonificacion($faltante)
    {
        $valor = $faltante->getMontoADevolver();
        
        if ( !$faltante->getProcesado() )
        {
            $pedido = $faltante->getPedido();
                        
            $bonificacion = new bonificacion();
            $bonificacion->setIdUsuario( $pedido->getIdUsuario() );
            $bonificacion->setIdTipoDescuento( tipoDescuento::MONTOFIJO );
            $bonificacion->setIdTipoBonificacion( tipoBonificacion::REINTEGRO );
            $bonificacion->setValor( $valor );
            $bonificacion->setObservaciones('Creada automaticamente por el faltante #' . $faltante->getIdFaltante() );
            $bonificacion->save();
        
            $faltante->setProcesado( true );
            $faltante->setFechaProcesado( new Doctrine_Expression('now()') );
            $faltante->setMontoDevuelto( $valor );
            $faltante->setIdBonificacion( $bonificacion->getIdBonificacion() );
            $faltante->save();
        
            reporteCronologicoTable::getInstance()->save(reporteCronologico::FALTANTE, array( 'idFaltante' => $faltante->getIdFaltante(), 'bonificacion' => $valor, 'efectivo' => 0 ) );
        
            // Realizo la nota de credito por el faltante
            ncreditoTable::getInstance()->insert( array( $pedido->getIdPedido() ), $valor);
        }
        
        return $valor;
    }

    public function generar($pedido, $productoItem, $cantidad, $mensaje)
    {           

        $pedidoProductoItem = pedidoProductoItemTable::getInstance()->getByCompoundKey($pedido->getIdPedido(), $productoItem->getIdProductoItem() );

        $faltante = new faltante();
        $faltante->setIdPedido( $pedido->getIdPedido() );
        $faltante->setIdProductoItem( $productoItem->getIdProductoItem() );
        $faltante->setCantidad( $cantidad );
        $faltante->save();

        if ( $pedido->todosSonFaltantes() )
        {
            $pedido->procesarBaja('Se da de baja el pedido porque todos sus productos son faltantes. Pedido #' . $pedido->getIdPedido(), false, false, false);
        }
        
        if ( $pedido->getIdEshop() ) {
            $eshop = $pedido->getEshop();
            $from = $eshop->getEmailNoReply();
            $tipoMail  = 'ESHOP';
        } else {
            $eshop = false;
            $from = sfConfig::get('app_email_from_noreply');
            $tipoMail  = 'DELUXE';
        }
        
        $subject = 'Aviso de Faltante en tu pedido #' . $pedido->getIdPedido();
        $vars = array( 'eshop'   => $eshop, 'title'   => $subject, 'pedido' => $pedido, 'usuario' => $pedido->getUsuario(), 'productoItem' => $productoItem, 'cantidad' => $cantidad, 'mensaje' => $mensaje, 'faltante' => $faltante);
        $mailer = new Mailer('faltanteEnvio' . $tipoMail, $vars);
        $mailer->send( $subject, $pedido->getEmail(), $from );


        // Si el faltante es de eshop creo un notificacion para avisar que no se olviden de devolver el dinero en MP
        if ( $pedido->getIdEshop() ) { 
            $notificacionBackend = new notificacionBackend();
            $notificacionBackend->setTipo( notificacionBackend::TIPO_MENSAJE );
            $notificacionBackend->setResponse( 'Se generó un nuevo faltante en el pedido #' . $pedido->getIdPedido() . ', recordá realizar la devolución del dinero en MP.' );
            $notificacionBackend->setIdUsuario( 337 );
            $notificacionBackend->save();
        }
        
        return true;
    }

    /**
     * Retorna un array con un resumen de faltantes en un pedido
     *
     * @return array
     */
    public function resumenFaltantes( $idPedido )
    {
        $data = $this->createQuery('f')
                     ->select('f.id_faltante, f.id_producto_item, sum(f.cantidad)')
                     ->addWhere('f.id_pedido = ?', $idPedido)
                     ->groupBy('f.id_producto_item')
                     ->execute( array(), Doctrine::HYDRATE_SCALAR );

        $resumen = array();
        foreach ( $data as $row ) {
            $resumen[ $row['f_id_producto_item'] ] = $row['f_sum'];
        }

        return $resumen;
    }

    /**
     * Retorna un array con un resumen de faltantes en listado de pedidos
     *
     * @return array
     */
    public function resumenesFaltantes( $idsPedido )
    {
        $data = $this->createQuery('f')
                     ->select('f.id_faltante, f.id_pedido, f.id_producto_item, sum(f.cantidad)')
                     ->whereIn('f.id_pedido', $idsPedido)
                     ->groupBy('f.id_producto_item')
                     ->execute( array(), Doctrine::HYDRATE_SCALAR );

        $resumen = array();
        foreach ( $data as $row ) {
            $resumen[ $row['f_id_pedido'] ][ $row['f_id_producto_item'] ] = $row['f_sum'];
        }

        return $resumen;
    }
    
}