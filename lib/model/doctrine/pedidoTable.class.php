<?php


class pedidoTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de pedidoTable;
	* 
	* @return pedidoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('pedido');
    }
    
	/**
	* Retorna un pedido a partir de su id
	* 
	* @param integer $idPedido
	* 
	* @return pedido
	*/
    public function getByIdPedido($idPedido)
    {
    	return $this->createQuery('p')
						->addWhere('p.id_pedido = ?', $idPedido)
						->fetchOne();
    }
    
    /**
    * Retorna el primer pedido pagado por un usuario y en caso de no haber hecho ninguno retorna null
    * 
    * @param integer $idUsuario
    * 
    * @return pedido
    */
    public function getFirstByIdUsuario($idUsuario)
    {
        return $this->createQuery('p')
                        ->addWhere('p.id_usuario = ?', $idUsuario)
                        ->orderBy('p.fecha_pago ASC')
                        ->limit(1)
                        ->fetchOne();
    }

    /**
    * Retorna true si el usuario tiene al menos un pedido pagado
    * 
    * @param integer $idUsuario
    * 
    * @return bool
    */
    public function comproAlgunaVez($idUsuario)
    {
        return (bool) $this->createQuery('p')
                           ->addWhere('p.id_usuario = ?', $idUsuario)
                            ->orderBy('p.fecha_pago ASC')
                            ->count();
    }
    
    /**
     * Retorna el listado de los pedidos asociados a los ultimos usuarios realizados en los ultimos 2 meses
     *
     * @param integer $idUsuario
     *
     * @return pedido
     */
    public function listUltimosByIdUsuario($idUsuario)
    {
    	return $this->createQuery('p')
    	->addWhere('p.id_usuario = ?', $idUsuario)
    	->addWhere('DATE_SUB(CURDATE(),INTERVAL 60 DAY) < fecha_alta')
    	->addWhere('p.fecha_baja IS NULL')
    	->orderBy('p.fecha_alta DESC')
    	->execute();
    }
        
	/**
	* Retorna la lista de pedidos a los cuales se le va a chequear el estado mediante el metodo cron
	*  
	* @return Doctrine_Collection
	*/
    public function listByCheckWithCron()
    {
    	return $this->createQuery('p')
						->addWhere('p.fecha_baja IS NULL')
						->addWhere('p.fecha_pago IS NULL')					
						->andWhereIn('p.id_forma_pago', array(formaPago::MERCADOPAGO, formaPago::NPS ) )
						->addWhere('TIMESTAMPDIFF(MINUTE, p.fecha_ultima_comprobacion, NOW()) > 60 OR p.fecha_ultima_comprobacion IS NULL' )
						->addWhere('TIMESTAMPDIFF(MINUTE, p.fecha_alta, NOW()) > 30' )
						->orderBy('p.fecha_ultima_comprobacion')
						->limit(100)
						->execute();
    }
    
    
	/**
	* Retorna todos los pedidos que coinciden con el array de ids enviado por parametro
	*  
	* @return Doctrine_Collection
	*/
	public function listByIds( $ids )
	{    	
    	return  $this->createQuery('p')->whereIn('p.id_pedido', $ids)
                     ->execute();
	}
	
	/**
	 * Retorna true si la $guiaEnvio existe
	 *
	 * @return Doctrine_Collection
	 */
	public function existGuiaEnvio( $guiaEnvio )
	{
		return (bool )$this->createQuery('p')
                    		->addWhere('p.codigo_envio = ?', $guiaEnvio)
                    		->count();
	}
	
	/**
	 * Retorna todos los pedidos que coinciden con el array de guiasEnvio enviado por parametro
	 *
	 * @return Doctrine_Collection
	 */
	public function listByGuiasEnvio( $guiasEnvio )
	{
	    return $this->createQuery('p')
	    ->whereIn('p.codigo_envio', $guiasEnvio)
	    ->execute();
	}
	

	public function setNowForFechaEnvioByIds( $ids )
	{
		return $this->createQuery('p')
		->update()
		->set('fecha_envio', 'NOW()')
		->whereIn('p.id_pedido', $ids)
		->execute();
	}
	
	/**
	* Retorna todos los pedidos truncados.
	* Se considera truncado cuando no se recibio informacion alguna desde MP luego de las x hs
	*  
	* @return Doctrine_Collection
	*/
	public function listTruncados()
	{    	
		$segundosInicializado = (int) sfConfig::get('app_pedido_horasInicializado') * 3600;
		
    	return $this->createQuery('p')
						->addWhere('p.datos_pago IS NULL')
						->addWhere('p.fecha_baja IS NULL')
						->addWhere('p.fecha_pago IS NULL')
						->addWhere('TIME_TO_SEC(TIMEDIFF(NOW(), p.fecha_alta)) > ?', $segundosInicializado)
						->limit(50)
						->execute();
	}
	
	/**
	 * Retorna todos los pedidos no pagados ni eliminados que hayan exedido su fecha de pago.
	 *
	 * @return Doctrine_Collection
	 */
	public function listFechaLimiteDePagoExpirada()
	{	
	    return $this->createQuery('p')
	                 ->addWhere('p.datos_pago IS NOT NULL')
            	     ->addWhere('p.fecha_baja IS NULL')
            	     ->addWhere('p.id_forma_pago = ?', formaPago::MERCADOPAGO)
            	     ->addWhere('p.fecha_pago IS NULL')
            	     ->addWhere('p.fecha_limite_pago <= NOW()')
            	     ->execute();
	}
    
	/**
	* Retorna todos los pedidos a los que hay que enviarle el recordatorio diario para pago offline
	*  
	* @return Doctrine_Collection
	*/
	public function listRecordatorioPagoOffline()
	{    			
    	return $this->createQuery('p')
    					->leftJoin('p.avisoPedido a')
						->addWhere('p.datos_pago LIKE \'%"modalidad":"OFF"%\'')
						->addWhere('p.fecha_baja IS NULL')
						->addWhere('p.fecha_pago IS NULL')
						->addWhere('TIME_TO_SEC(TIMEDIFF(NOW(), p.fecha_alta)) > 86400')
						->addWhere('(a.fecha IS NULL OR TIME_TO_SEC(TIMEDIFF(NOW(), a.fecha)) > 86400)')
						->execute();
	}
	
	/**
	* Retorna todos los pedidos que fueron pagados en el dia del a fecha enviada por parametro
	*  
	* @return Doctrine_Collection
	*/
	public function listPagadosIn($fecha, $idEshop)
	{    			
    	$q = $this->createQuery('p')
				  ->addWhere('DATE(p.fecha_pago) = ?', $fecha)
				  ->addWhere('p.fecha_baja IS NULL');
						
		if ( $idEshop ) {
		    $q->addwhere('p.id_eshop = ?', $idEshop );
		} else {
		    $q->addwhere('p.id_eshop IS NULL');
		}
						
        return $q->execute();
	}
	
	/**
	* Retorna un resumen de pedidos de un usuario
	* 
	* @param integer $idUsuario
	* 
	* @return array
	*/
    public function getResumenByIdUsuario($idUsuario)
    {
    	return $this->createQuery('p')
    					->select('count(p.id_pedido), sum(p.monto_total)')
						->addWhere('p.id_usuario = ?', $idUsuario)
						->addWhere('p.fecha_baja IS NULL')
						->addWhere('p.fecha_pago IS NOT NULL')
						->groupBy('id_usuario', $idUsuario)
						->fetchOne( array(), Doctrine_Core::HYDRATE_ARRAY  );
    }
    
	
	/**
	* Envia el mail correspondiente a la carga de una guia de envio
	* 
	* @param integer $idUsuario
	* 
	* @return array
	*/
    public function enviarGuiaEnvio($pedido)
    {
		$usuario = $pedido->getUsuario();
		$title = 'Pedido despachado!';
		
		if ( $pedido->getIdEshop() ) {
		    $eshop = $pedido->getEshop();
		    $from = $eshop->getEmailNoReply();
		    $tipoMail  = 'ESHOP';
		} else {
		    $eshop = false;
		    $from = sfConfig::get('app_email_from_noreply');
		    $tipoMail  = 'DELUXE';
		}
		

        if ( $pedido->getEnvioTipo() == carritoEnvio::DOMICILIO )
		{
			$vars = array( 'eshop' => $eshop, 'title' => $title, 'pedido' => $pedido, 'usuario' => $usuario );
			$mailer = new Mailer('envioDomicilio' . $tipoMail, $vars);
		}
		else 
		{
			$vars = array( 'eshop' => $eshop, 'title' => $title, 'pedido' => $pedido, 'usuario' => $usuario );
			$mailer = new Mailer('envioSucursal' . $tipoMail, $vars);
		}
		
		$subject = 'Pedido despachado';
		$mailer->send( $subject, $usuario->getEmail(), $from );
    }
    
	/**
	* Retorna la cantidad de pedidos que requieren intervencion manual 
	* 
	* @param integer
	* 
	* @return pedido
	*/
    public function countIntervencionManual()
    {
    	return $this->createQuery('p')
					->addWhere('p.requiere_intervencion_manual != 0')
					->count();
    }
    
    
	/**
	* Retorna la lista de pedidos donde se utilizo un descuento
	*
	* @return Doctrine_Collection
	*/
    public function listByIdDescuento($idDescuento)
    {
    	return $this->createQuery('p')
    					->innerJoin('p.pedidoDescuento as pd')
						->addWhere('pd.id_descuento = ?', $idDescuento )
						->execute();
    }
    
    /**
     * Retorna el listado de productoItems vendidos en una campaña x producto
     *
     * @param int $idEshop
     * @param int $idCampana
     * @param int $idProducto
     *
     * @return int
     */
    public function searchFaltantes($idEshop, $idCampana, $idProductoItem)
    {

        $idsPedidosConFaltantesExistentes = faltanteTable::getInstance()->createQuery('f')
                ->select('f.id_pedido')
                ->addWhere('f.id_producto_item = ?', $idProductoItem)
                ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );




        $q = $this  ->createQuery('p')
                    ->select('p.*')
                    ->innerJoin('p.pedidoProductoItem ppi')
                    ->innerJoin('ppi.productoItem pi')
                    ->innerJoin('pi.producto prod');
        
        if ( $idEshop ) {
            $q->addwhere('p.id_eshop = ?', $idEshop );
        } else {
            $q->addwhere('p.id_eshop IS NULL');
        }
        
        if ($idCampana == 'STKPER')
        {
            $q->leftJoin('ppi.pedidoProductoItemCampana ppic');
            $q->addWhere('ppic.id_campana IS NULL');
            $q->addWhere('ppi.origen = ?', producto::ORIGEN_STOCK_PERMANENTE);
        }            
        else if ($idCampana == 'OUTLET')
        {
            $q->leftJoin('ppi.pedidoProductoItemCampana ppic');
            $q->addWhere('ppic.id_campana IS NULL');
            $q->addWhere('ppi.origen = ?', producto::ORIGEN_OUTLET);
        }
        else
        {
           $q->innerJoin('ppi.pedidoProductoItemCampana ppic');
           $q->addWhere('ppic.id_campana = ?', $idCampana);
        }
        
        $q->addWhere('pi.id_producto_item = ?', $idProductoItem)
          ->addWhere('p.fecha_baja IS NULL')
          ->andWhereNotIn('p.id_pedido', $idsPedidosConFaltantesExistentes);
        

        $q->orderBy('p.fecha_pago desc');

        return $q->execute();
    }
    
    /**
     * Retorna todos los pedidos asociados a un idRemito
     *
     * @param int $idRemito
     * 
     * @return Doctrine_Collection
     */
    public function listbyIdRemito($idRemito)
    {
    	return $this->createQuery('p')
    	->innerJoin('p.remitoPedido rp')
    	->innerJoin('rp.remito r')
    	->addWhere('r.id_remito = ?', $idRemito )
    	->execute();
    }
    
    /*
     * Retorna la lista de pedidos de una campaña que deben ser enviados
    *
    * @param integer $idCampana
    *
    * @return Doctrine_Collection
    */
    public function listPendientesEnvioByIdCampana($idCampana)
    {
    
        return $this->createQuery('p')
        ->innerJoin('p.pedidoProductoItem ppi')
        ->innerJoin('ppi.pedidoProductoItemCampana ppic')
        ->addWhere('p.fecha_envio IS NULL')
        ->addWhere('p.codigo_envio IS NULL')
        ->addWhere('p.fecha_pago IS NOT NULL')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('p.tipo_producto = ?', pedido::PRODUCTO_TIPO_OFERTA)
        ->addWhere('ppic.id_campana = ?', $idCampana)
        ->execute();
    }

    /*
     * Retorna la lista de pedidos de una campaña y marca en particular que deben ser enviados
    *
    * @param integer $idCampana
    * @param integer $idMarca
    *
    * @return Doctrine_Collection
    */
    public function listPendientesEnvio($idCampana, $idMarca)
    {
    
        return $this->createQuery('p')
        ->innerJoin('p.pedidoProductoItem ppi')
        ->innerJoin('ppi.pedidoProductoItemCampana ppic')
        ->innerJoin('ppi.productoItem pi')
        ->innerJoin('pi.producto pr')
        ->addWhere('p.fecha_envio IS NULL')
        ->addWhere('p.codigo_envio IS NULL')
        ->addWhere('p.fecha_pago IS NOT NULL')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('p.tipo_producto = ?', pedido::PRODUCTO_TIPO_OFERTA)
        ->addWhere('ppic.id_campana = ?', $idCampana)
        ->addWhere('pr.id_marca = ?', $idMarca)
        ->execute();
    }

    
    /*
    * Retorna la lista de pedidos de una campaña a los que debe enviarsele el mail de finalizacion de campaña
    *
    * @param integer $idCampana
    *
    * @return Doctrine_Collection
    */
    public function listMailFinalizacionCampana($idCampana)
    {
    
        return $this->createQuery('p')
        ->innerJoin('p.pedidoProductoItem ppi')
        ->innerJoin('ppi.pedidoProductoItemCampana ppic')
        ->addWhere('p.fecha_pago IS NOT NULL')
        ->addWhere('p.fecha_baja IS NULL')
        ->addWhere('p.tipo_producto = ?', pedido::PRODUCTO_TIPO_OFERTA)
        ->addWhere('ppic.id_campana = ?', $idCampana)
        ->execute();
    }
    
    /**
     * Retorna la cantidad de pedidos asociados a un $email
     *
     * @param string $email
     *
     * @return int
     */
    public function countPagadosByEmail($email)
    {
        return $this->createQuery('p')
                    ->addWhere('p.email = ?', $email )
                    ->addWhere('p.fecha_pago IS NOT NULL')
                    ->count();
    }
    
    /**
     * Retorna true si el pedido tiene alguno de los productos enviados por parametro
     *
     * @param int $idPedido
     * @param int $idsProducto
     *
     * @return bool
     */
    public function tieneAlgunProducto($idPedido, $idsProducto)
    {
        return (bool) $this->createQuery('p')
                           ->innerJoin('p.pedidoProductoItem ppi')
                           ->innerJoin('ppi.productoItem pi')
                           ->addWhere('p.id_pedido = ?', $idPedido )
                           ->andWhereIn('pi.id_producto', $idsProducto )
                           ->count();
    }
    
    /**
     * Retorna la cantidad de pedidos de la campaña que tienen guia de envio
     *
     * @param integer $idCampana
     * @param integer $idMarca
     *
     * @return integer
     */
    public function getCantidadPedidosDespachados( $idCampana, $idMarca )
    {
        $q =  $this->createQuery('p')
                   ->select('p.id_pedido')
                   ->innerJoin('p.pedidoProductoItem ppi')
                   ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                   ->innerJoin('ppi.productoItem pi')
                   ->innerJoin('pi.producto pr')
                   ->addWhere('ppic.id_campana = ?', $idCampana)                    
                   ->addWhere('p.codigo_envio IS NOT NULL');
        
        if ( $idMarca )
        {
            $q->addWhere('pr.id_marca = ?', $idMarca);
        }        
                   
        return $q->count();
    }
    
    /**
     * Retorna true si el usuario compro y pago alguna vez en el sitio
     *
     * @param integer $idUsuario
     *
     * @return bool
     */
    public function haComprado( $idUsuario )
    {
        return (bool) $this->createQuery('p')
                           ->addWhere('p.id_usuario = ?', $idUsuario)
                           ->addWhere('p.fecha_pago IS NOT NULL')
                           ->count();
    }
    
    /**
     * Da de Baja los pedidos que superaron la fecha limite de pago.
     * Debe ser llamado exclusivamente desde una task
     *
     * @param deluxebuysBaseTask $task
     */
    public function eliminarPedidosFueraDePlazo( $task )
    {
        $pedidos = pedidoTable::getInstance()->listFechaLimiteDePagoExpirada();
        
        foreach( $pedidos as $pedido )
        {
            // Doy de baja el pedido en Deluxe
            $fueDadoDeBaja = $pedido->procesarBaja('Baja de pedido #' . $pedido->getIdPedido() . ' por superar la fecha limite de pago.');
            if ( !$fueDadoDeBaja ) continue;
        
            // Cancelo el pedido en Mercado Pago, ( siempre que tenga id en Mercado Pago )
            $canceladoEnMP = PagoProvider::getInstance( formaPago::MERCADOPAGO )->cancelarPago($pedido);
             
            // Genero una notificacion ya procesada para guardar el log del pedido
            $pagoNotificacion = new pagoNotificacion();
            $pagoNotificacion->setIdFormaPago( formaPago::MERCADOPAGO );
            $pagoNotificacion->setMetodo(pagoNotificacion::INTERNO);
            $pagoNotificacion->setIdPedido( $pedido->getIdPedido() );
            $pagoNotificacion->setResponse( null);
            $pagoNotificacion->setProcesado(true);
        
            if ( $canceladoEnMP )
            {
                $pagoNotificacion->setMensaje( 'Se realizó la baja por superar la fecha limite de pago y se cancelo correctamente el pedido en Mercado Pago.' );
            }
            else
            {
                $pagoNotificacion->setMensaje( 'Se realizó la baja por superar la fecha limite de pago, pero no se pudo cancelar el/los pago/s en Mercado Pago.' );
            }
        
            $pagoNotificacion->save();
             
            $usuario = $pedido->getUsuario();
        
            // Envio el aviso via mail
            if ( $pedido->getIdEshop() ) {
                $eshop = $pedido->getEshop();
                $from = $eshop->getEmailNoReply();
                $tipoMail  = 'ESHOP';
            } else {
                $eshop = false;
                $from = sfConfig::get('app_email_from_noreply');
                $tipoMail  = 'DELUXE';
            }
            
            $subject = 'Ha finalizado el periodo para el pago del pedido #' . $pedido->getIdPedido();
            $vars = array( 'eshop' => $eshop, '$eshop' => $subject, 'usuario' => $pedido->getUsuario(), 'pedido' => $pedido );
            $mailer = new Mailer('avisoExpiroPlazoDePago' . $tipoMail, $vars);
            $mailer->send( $subject, $usuario->getEmail(), $from );
             
            $task->log('Se elimino el pedido #' . $pedido->getIdPedido() );
        }
    }
    

    /*
     * Retorna la lista de pedidos para el recuperador de carritos
    *
    * @return Doctrine_Collection
    */
    public function listForRecuperarCarritos()
    {
        return $this->createQuery('p')
                    ->select('p.*, ppi.*, ppic.*, pi.*, pr.*, u.*')
                    ->leftJoin('p.recuperoCarrito rc')
                    ->innerJoin('p.usuario u')
                    ->innerJoin('p.pedidoProductoItem ppi')
                    ->innerJoin('ppi.pedidoProductoItemCampana ppic')
                    ->innerJoin('ppi.productoItem pi')
                    ->innerJoin('pi.producto pr')
                    ->addWhere('p.fecha_pago IS NULL')
                    ->addWhere('p.id_eshop IS NULL')
                    ->addWhere('p.datos_pago IS NULL')
                    ->addWhere('rc.id_recupero_carrito IS NULL')
                    ->addWhere('TIMESTAMPDIFF(MINUTE, fecha_alta, NOW()) < 480')
                    ->addWhere('TIMESTAMPDIFF(MINUTE, fecha_alta, NOW()) > 120')
                    ->execute();
    }    


    /*
     * Retorna la lista de pedidos que solo tiene productos pertenecientes
     * a un determinado array de idsMarca
    * @return Doctrine_Collection
    */
    public function listPedidosJustWithIdsMarca($idsMarca)
    {
        $data = $this->createQuery('p')
                   ->addSelect('p.id_pedido, ')
                   ->addSelect( 'GROUP_CONCAT(DISTINCT(pr2.id_marca)) as ids_marcas' )
                   ->innerJoin('p.pedidoProductoItem ppi')
                   ->innerJoin('p.pedidoProductoItem ppi2')
                   ->innerJoin('ppi.productoItem pi')
                   ->innerJoin('ppi2.productoItem pi2')
                   ->innerJoin('pi.producto pr')
                   ->innerJoin('pi2.producto pr2')
                   ->addWhere('pr.id_marca IN ?', array( $idsMarca ) )
                   ->groupBy('p.id_pedido')
                   ->orderBy('p.id_pedido, pr2.id_marca')
                   ->execute( null, Doctrine::HYDRATE_SCALAR);

     $result = array();
     foreach ($data as $row) {
         $marcasEnPedido = explode(',', $row['pr2_ids_marcas']);

         if ( count( array_diff( $marcasEnPedido, $idsMarca ) ) == 0 ) {
            $result[] = $row['p_id_pedido'];   
         }
     }

     return $result;

    }    

    /**
     * Retorna el listado de pedidos en donde se utilizo una bonificacion
     *
     * @param integer $idBonificacion
     *
     * @return Doctrine_Collection
     */
    public function getByIdBonificacion( $idBonificacion )
    {
        return $this->createQuery('p')
                    ->innerJoin('p.pedidoBonificacion pb')
                    ->addWhere('pb.id_bonificacion = ?', $idBonificacion)
                    ->execute();
    }


    /**
     * Retorna true si todos los productos del pedido son faltantes
     *
     * @return boolean
     */
    public function todosSonFaltantes( $idPedido )
    {
        $productosFaltantes = faltanteTable::getInstance()->resumenFaltantes( $idPedido );

        $data = $this->createQuery('p')
                                ->select('p.id_pedido, ppi.id_producto_item, sum(ppi.cantidad)')
                                ->innerJoin('p.pedidoProductoItem ppi')
                                ->addWhere('p.id_pedido = ?', $idPedido)
                                ->groupBy('ppi.id_producto_item')
                                ->execute( array(), Doctrine::HYDRATE_SCALAR );

        foreach ( $data as $row ) {
            $idProductoItem = $row['ppi_id_producto_item'];
            $cantidad = $row['ppi_sum'];

            if ( !isset($productosFaltantes[ $idProductoItem ]) || $productosFaltantes[ $idProductoItem ] < $cantidad ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Retorna toda la informacion para armar el reporte de marketing
     *
     * @return boolean
     */
    public function getReporteMarketing($idEshop, $fechaDesde, $fechaHasta)
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $data = $q->fetchAll(
            '
                SELECT p.id_pedido AS result_id_pedido,
                p.email AS result_email_usuario,
                u.id_usuario AS result_id_usuario,
                DATE(p.fecha_alta) AS result_pedido_fecha_alta,
                p.monto_total AS result_pedido_monto_total,
                p.source AS result_pedido_source,
                p.utm_campaign AS result_pedido_campaign,
                (SELECT MIN(s1p.id_pedido) FROM pedido s1p WHERE s1p.id_usuario = p.id_usuario AND s1p.fecha_pago IS NOT NULL) AS result_id_primer_pedido,
                (SELECT DATE(MIN(s2p.fecha_alta)) FROM pedido s2p WHERE s2p.id_usuario = p.id_usuario AND s2p.fecha_pago IS NOT NULL) AS result_fecha_primer_pedido,
                DATE(u.fecha_alta) AS result_registracion_fecha,
                u.source AS result_registracion_source,
                u.utm_campaign AS result_registracion_campaign,
                (SELECT MIN(s1u.id_newsletter) FROM newsletter s1u WHERE s1u.email = p.email AND ( ( s1u.id_eshop IS NULL AND ? IS NULL ) OR s1u.id_eshop = ? ) ) AS result_id_newsletter,
                (SELECT DATE(s2u.fecha_alta) FROM newsletter s2u WHERE s2u.id_newsletter = result_id_newsletter) AS result_suscripcion_fecha,
                (SELECT s3u.utm_campaign FROM newsletter s3u WHERE s3u.id_newsletter = result_id_newsletter) AS result_suscripcion_source,
                (SELECT s3u.source FROM newsletter s3u WHERE s3u.id_newsletter = result_id_newsletter) AS result_suscripcion_campaign
                FROM pedido p
                inner join usuario u on p.id_usuario = u.id_usuario
                WHERE DATE(p.fecha_pago) >= ? AND DATE(p.fecha_pago) <= ?
                AND p.fecha_pago IS NOT NULL
                AND ( ( p.id_eshop IS NULL AND ? IS NULL ) OR p.id_eshop = ? )
            ',
            array($idEshop, $idEshop, $fechaDesde, $fechaHasta, $idEshop, $idEshop)
        );

        return $data;
    }

    public function listForRemarkety($desde, $hasta, $limit, $page){
        
        $greatest = '( GREATEST(COALESCE(p.fecha_alta,0), COALESCE(p.fecha_baja,0), COALESCE(p.fecha_pago,0), COALESCE(p.fecha_envio,0)) )';

        $q = $this->createQuery('p')
                  ->select('p.id_pedido, p.fecha_alta, p.fecha_baja, p.fecha_envio, p.fecha_pago, p.monto_total, p.monto_envio, p.monto_descuento, p.monto_bonificacion');

        $subQ = $q->createSubquery()
                  ->select('s1_pi.id_producto_imagen')
                  ->from('productoImagen s1_pi')
                  ->addWhere('s1_pi.id_producto = pr.id_producto')
                  ->orderBy('s1_pi.orden')
                  ->limit(1);

        $q->addSelect('(' . $subQ->getDql() . ') as id_producto_imagen_calculado');

        $q->addSelect( $greatest . ' as fecha_modificacion');

        $q->addSelect('u.*');
        $q->addSelect('ppi.*');
        $q->addSelect('pr.id_producto, pr.codigo, pr.fecha_modificacion, pr.denominacion, m.nombre, pi.id_producto, pr.id_producto_categoria, pcat.*, pg.denominacion');

        $q->innerJoin('p.pedidoProductoItem ppi')
          ->innerJoin('ppi.productoItem pi')
          ->innerJoin('pi.producto pr')
          ->innerJoin('pr.productoCategoria pcat')
          ->innerJoin('pcat.productoGenero pg')
          ->innerJoin('pr.marca m')
          ->innerJoin('p.usuario u');

        $q->addWhere('p.id_eshop IS NULL');

        if ( $desde ) {
          $q->addWhere( $greatest . ' >= ?', $desde);  
        }
        
        if ( $hasta ) {
          $q->addWhere( $greatest . ' <= ?', $hasta);
        }

        $q->orderBy( $greatest . ' asc');

      return $q->limit($limit)
               ->offset($limit * $page)
               ->execute();
    }  

    public function countForRemarkety($desde, $hasta){
        
        $q = $this->createQuery('p')
                  ->addWhere('p.id_eshop IS NULL');

        $greatest = '( GREATEST(COALESCE(p.fecha_alta,0), COALESCE(p.fecha_baja,0), COALESCE(p.fecha_pago,0), COALESCE(p.fecha_envio,0)) )';

        if ( $desde ) {
          $q->addWhere( $greatest . ' >= ?', $desde);  
        }
        
        if ( $hasta ) {
          $q->addWhere( $greatest . ' <= ?', $hasta);
        }

      return $q->count();
    }  
    
}
