<?php


class reporteCronologicoTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de reporteCronologicoTable;
     *
     * @return reporteCronologicoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('reporteCronologico');
    }    
    
    /**
     * Retorna las campañas activas y vigentes;
     *
     * @return Doctrine_Collection
     */
    public function getReporte($idEshop, $fechaDesde, $fechaHasta)
    {
        $q = $this->createQuery('r');
        
        if ( $idEshop ) {
            $q->addwhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addwhere('r.id_eshop IS NULL');
        }
        
        $q->addWhere('? <= DATE(r.fecha) AND DATE(r.fecha) <= ?', array($fechaDesde, $fechaHasta));
                
        return $q->execute();
    }
    
    /**
     * Retorna las campañas activas y vigentes;
     *
     * @return Doctrine_Collection
     */
    public function save($tipo, $params)
    {
        $method = 'save' . $tipo;
        $this->$method($params);
    }
    
    public function savePEDID($params)
    {
        $idPedido = $params['idPedido'];
        
        $pedido = $this->createQuery('p')
                       ->from('pedido p')
                       ->innerJoin('p.pedidoProductoItem ppi')
                       ->innerJoin('ppi.productoItem pi')
                       ->innerJoin('ppi.productoTalle pt')
                       ->innerJoin('ppi.productoColor pc')
                       ->innerJoin('pi.producto prod')
                       ->innerJoin('prod.marca m')
                       ->innerJoin('prod.productoCategoria pcat')
                       ->innerJoin('pcat.productoGenero pg')
                       ->leftJoin('ppi.pedidoProductoItemCampana ppic')
                       ->leftJoin('ppic.campana cam')
                       ->leftJoin('p.pedidoDescuento pd')
                       ->leftJoin('pd.descuento d')
                       ->leftJoin('p.pedidoBonificacion pb')
                       ->leftJoin('pb.bonificacion b')
                       ->innerJoin('p.usuario u')
                       ->innerJoin('p.provincia prov')
                       ->addWhere('p.id_pedido = ?', $idPedido)
                       ->fetchOne();
                
        $preSave = array();        
        $precioDB = $cantidad = $costo = 0;
                        
        // Get de objetos relacionados al pedido
        $eshop = $pedido->getEshop();
        $usuario = $pedido->getUsuario();        
        $provincia = $pedido->getProvincia();
        $envioDetalle = $pedido->getArrayEnvioDetalle();
                
        $pedidoProductoItems = $pedido->getPedidoProductoItem();
        
        foreach( $pedidoProductoItems as $pedidoProductoItem)
        {
            // Sumatorias para los totales del pedido
            $precioDB += $pedidoProductoItem->getCantidad() * $pedidoProductoItem->getPrecioDeluxe();
            $costo += $pedidoProductoItem->getCantidad() * $pedidoProductoItem->getCosto();
            $cantidad += $pedidoProductoItem->getCantidad();

            // Get de objetos relacionados al pedidoProductoItem
            $productoItem = $producto = $pedidoProductoItem->getProductoItem();
            $producto = $productoItem->getProducto();

            $marca = $producto->getMarca();
            $productoTalle = $pedidoProductoItem->getProductoTalle();
            $productoColor = $pedidoProductoItem->getProductoColor();
            $productoCategoria = $producto->getProductoCategoria();
            
            // Armado del reporte cronologico para cada detalle de un pedido
            $reporteCronologico = new reporteCronologico();
            $reporteCronologico->setAccion( 'Pedido Detalle' );
            $reporteCronologico->setIdPedido( $idPedido );

            $fuente = $this->getFuente( $pedidoProductoItem );
            $reporteCronologico->setFuente( $fuente );
            
            $reporteCronologico->setMarca( $marca->getNombre() );
            $reporteCronologico->setCondicionFiscal( $marca->getCondicionFiscal() );
            $reporteCronologico->setCodigoProducto( $productoItem->getCodigo() );
            $reporteCronologico->setProducto( $producto->getDenominacion() );
            $reporteCronologico->setColor( $productoColor->getDenominacion() );
            $reporteCronologico->setTalle( $productoTalle->getDenominacion() );
            $reporteCronologico->setCategoria( $productoCategoria->getDenominacion() );
            $reporteCronologico->setGenero( $productoCategoria->getProductoGenero()->getDenominacion() );
            $reporteCronologico->setPrecioDeluxe( $pedidoProductoItem->getCantidad() * $pedidoProductoItem->getPrecioDeluxe() );
            $reporteCronologico->setCosto( $pedidoProductoItem->getCantidad() * $pedidoProductoItem->getCosto() );
            $reporteCronologico->setCantidad( $pedidoProductoItem->getCantidad() );
            $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
            $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
            $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
            $reporteCronologico->setClienteEmail( $usuario->getEmail() );            
            $reporteCronologico->setLocalidad( $envioDetalle['localidad'] );
            $reporteCronologico->setProvincia( $envioDetalle['provincia'] );
            $reporteCronologico->setFormaPago( $pedido->getDescripcionFormaPago(' - ') );
            
            if ( $eshop ) {
                $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
                $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );
            }
            
            array_unshift($preSave, $reporteCronologico);
        }
        
        $reporteCronologico = new reporteCronologico();
        $reporteCronologico->setAccion( 'Pedido Total' );
        $reporteCronologico->setIdPedido( $idPedido );
        $reporteCronologico->setPrecioDeluxe( $precioDB );
        $reporteCronologico->setCosto( $costo );
        $reporteCronologico->setCantidad( $cantidad );
        
        if ( $pedido->getMontoDescuento() > 0 )
        {                        
            $descuento = $pedido->getPedidoDescuento()->getFirst()->getDescuento();
                        
            $reporteCronologico->setDescuento( $pedido->getMontoDescuento() );
            $reporteCronologico->setDescuentoMotivo( 'Descuento' );
            
            $codigo = ( !$descuento->getEsInterno() ) ? $descuento->getCodigo() : 'INTERNO';
            $reporteCronologico->setDescuentoCodigo( $codigo );
        }
        
        if ( $pedido->getMontoBonificacion() > 0 )
        {
            $tipoBonificacion = $pedido->getPedidoBonificacion()->getFirst()->getBonificacion()->getTipoBonificacion();
            $reporteCronologico->setDescuento( $pedido->getMontoBonificacion() );
            $reporteCronologico->setDescuentoMotivo( 'Bonificacion - ' . $tipoBonificacion->getDenominacion() );
        }
        
        $reporteCronologico->setCostoEnvio( $pedido->getMontoEnvio() );
        $reporteCronologico->setCostoEnvioDeluxe( $pedido->getMontoEnvioDeluxe() );
        $reporteCronologico->setTipoEnvio( $envioDetalle['tipo'] );
        $reporteCronologico->setVentaDbTotal( $pedido->getMontoProductos() );
        $reporteCronologico->setTotalFacturado( $pedido->getMontoTotal() );
        $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
        $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
        $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
        $reporteCronologico->setClienteEmail( $usuario->getEmail() );
        $reporteCronologico->setLocalidad( $envioDetalle['localidad'] );
        $reporteCronologico->setProvincia( $envioDetalle['provincia'] );
        $reporteCronologico->setFormaPago( $pedido->getDescripcionFormaPago(' - ') );
        
        if ( $eshop ) {
            $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
            $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );
        }
        
        array_unshift($preSave, $reporteCronologico);
        
        // Se guardan en orden
        foreach( $preSave as $reporteCronologico) $reporteCronologico->save();     
    }
    
    public function saveDEVOL($params)
    {
        $eshop = $params['eshop'];
        $idDevolucion = $params['idDevolucion'];
        
        $devolucion = $this->createQuery('d')
                           ->from('devolucion d')
                           ->innerJoin('d.devolucionProductoItem dpi')
                           ->innerJoin('d.devolucionMotivo dm')
                           ->innerJoin('dpi.pedidoProductoItem ppi')       
                           ->innerJoin('ppi.productoItem pi')
                           ->innerJoin('ppi.productoTalle pt')
                           ->innerJoin('ppi.productoColor pc')
                           ->innerJoin('pi.producto prod')
                           ->innerJoin('prod.marca m')
                           ->innerJoin('prod.productoCategoria pcat')
                           ->innerJoin('pcat.productoGenero pg')
                           ->innerJoin('ppi.pedido p')
                           ->leftJoin('ppi.pedidoProductoItemCampana ppic')
                           ->leftJoin('ppic.campana cam')
                           ->innerJoin('d.usuario u')
                           ->innerJoin('p.provincia prov')
                           ->addWhere('d.id_devolucion = ?', $idDevolucion)
                           ->fetchOne();
        
        $devolucionProductoItems = $devolucion->getDevolucionProductoItem();
        
        $usuario = $devolucion->getUsuario();
        
        // Armado del reporte cronologico para cada productoItem de la devolucion
        foreach ($devolucionProductoItems as $devolucionProductoItem)
        {
            // Get de objetos relacionados a devolucionProductoItem
            $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem();
            $productoItem = $producto = $pedidoProductoItem->getProductoItem();
            $producto = $productoItem->getProducto();
            $marca = $producto->getMarca();
            $productoTalle = $pedidoProductoItem->getProductoTalle();
            $productoColor = $pedidoProductoItem->getProductoColor();
            $productoCategoria = $producto->getProductoCategoria();
            $pedido = $pedidoProductoItem->getPedido();
            $envioDetalle = $pedido->getArrayEnvioDetalle();
            $provincia = $pedido->getProvincia();
            
            $reporteCronologico = new reporteCronologico();
            $reporteCronologico->setAccion( 'Bonificacion' );
            $reporteCronologico->setIdPedido( $pedidoProductoItem->getIdPedido() );
            
            $fuente = $this->getFuente( $pedidoProductoItem );
            $reporteCronologico->setFuente( $fuente );
            
            $reporteCronologico->setMarca( $marca->getNombre() );
            $reporteCronologico->setCondicionFiscal( $marca->getCondicionFiscal() );
            $reporteCronologico->setCodigoProducto( $productoItem->getCodigo() );
            $reporteCronologico->setProducto( $producto->getDenominacion() );
            $reporteCronologico->setColor( $productoColor->getDenominacion() );
            $reporteCronologico->setTalle( $productoTalle->getDenominacion() );
            $reporteCronologico->setCategoria( $productoCategoria->getDenominacion() );
            $reporteCronologico->setGenero( $productoCategoria->getProductoGenero()->getDenominacion() );
            
            $monto = $devolucionProductoItem->calcularMontoTotal();
            
            $reporteCronologico->setPrecioDeluxe( $devolucionProductoItem->getCantidad() * $pedidoProductoItem->getPrecioDeluxe() );
            $reporteCronologico->setCosto( $devolucionProductoItem->getCantidad() * $pedidoProductoItem->getCosto() );
            $reporteCronologico->setCantidad( $devolucionProductoItem->getCantidad() );
            
	        if ($devolucion->getTipoCredito() == devolucion::envio_deluxe)
	        {
	            $reporteCronologico->setBonificacionDevolucionDeluxe( $monto );
	        }
	        else
	       {
	            $reporteCronologico->setBonificacionDevolucionMp( $monto );
	        }
            
            $reporteCronologico->setBonificacionMotivo('Devolucion');
            $reporteCronologico->setBonificacionSubmotivo( $devolucion->getDevolucionMotivo()->getDenominacion() );
            
            $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
            $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
            $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
            $reporteCronologico->setClienteEmail( $usuario->getEmail() );
            $reporteCronologico->setLocalidad( $envioDetalle['localidad'] );
            $reporteCronologico->setProvincia( $envioDetalle['provincia'] );
            $reporteCronologico->setFormaPago( $pedido->getDescripcionFormaPago(' - ') );
            
            if ( $eshop ) {
                $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
                $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );                
            }
                        
            $reporteCronologico->save();
        }
        

		/*
		 * Se le devuelve el costo de envio si la devolucion fue por error nuestro,
		 * independientemente de como lo devuelve personalmente o por correo.
		 * Siempre que se devuelva el pedido en su totalidad
		 */
        if ( $params['montosDevolucion']['costoEnvioOriginal'] > 0 )
        {
            $costoEnvio = $params['montosDevolucion']['costoEnvioOriginal'];
        
            $reporteCronologico = new reporteCronologico();
            $reporteCronologico->setAccion( 'Bonificacion - Envio' );
                        
            if ($devolucion->getTipoCredito() == devolucion::credito_deluxe)
            {
                $reporteCronologico->setBonificacionDevolucionDeluxe( $costoEnvio );
            }
            else
            {
                $reporteCronologico->setBonificacionDevolucionMp( $costoEnvio );
            }
        
            $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
            $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
            $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
            $reporteCronologico->setClienteEmail( $usuario->getEmail() );
        
            if ( $eshop ) {
                $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
                $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );
            }
        
            $reporteCronologico->save();
        }
        
        
         /*
         * Se le descuenta el costo de envio si pide devolverlo por correo y
         * no fue una devolucion por error nuestro
         */
        if ( $params['montosDevolucion']['costoEnvioDevolucion'] > 0 )
        {
            $costoEnvio = $params['montosDevolucion']['costoEnvioDevolucion'] * (-1);
            
            $reporteCronologico = new reporteCronologico();
            $reporteCronologico->setAccion( 'Bonificacion - Envio' );
            
            if ($devolucion->getTipoCredito() == devolucion::credito_deluxe)
            {
                $reporteCronologico->setBonificacionDevolucionDeluxe( $costoEnvio );
            }
            else
            {
                $reporteCronologico->setBonificacionDevolucionMp( $costoEnvio );
            }
            
            $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
            $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
            $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
            $reporteCronologico->setClienteEmail( $usuario->getEmail() );
            
            if ( $eshop ) {
                $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
                $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );
            }
            
            $reporteCronologico->save();
        }
    }
    
    public function saveFALTAN($params)
    {
        $idFaltante   = $params['idFaltante'];
        $bonificacion = $params['bonificacion'];
        $efectivo     = $params['efectivo'];
                
        $faltante = $this->createQuery('f')
                         ->from('faltante f')
                         ->innerJoin('f.productoItem pi')
                         ->innerJoin('pi.productoTalle pt')
                         ->innerJoin('pi.productoColor pc')
                         ->innerJoin('pi.producto prod')
                         ->innerJoin('prod.marca m')
                         ->innerJoin('prod.productoCategoria pcat')
                         ->innerJoin('pcat.productoGenero pg')
                         ->innerJoin('f.pedido p')
                         ->innerJoin('p.usuario u')
                         ->innerJoin('p.provincia prov')
                         ->addWhere('f.id_faltante = ?', $idFaltante)
                         ->fetchOne();
        
        
        // Get de objetos relacionados al faltante
        $productoItem = $faltante->getProductoItem();
        $producto = $productoItem->getProducto();
        $marca = $producto->getMarca();
        $productoTalle = $productoItem->getProductoTalle();
        $productoColor = $productoItem->getProductoColor();
        $productoCategoria = $producto->getProductoCategoria();
        $pedido = $faltante->getPedido();
        $envioDetalle = $pedido->getArrayEnvioDetalle();
        $provincia = $pedido->getProvincia();
        $usuario = $pedido->getUsuario();
        $eshop = $pedido->getEshop();
        
        $pedidoProductoItem = pedidoProductoItemTable::getInstance()->getByCompoundKey( $pedido->getIdPedido() , $productoItem->getIdProductoItem() );
        
        $reporteCronologico = new reporteCronologico();
        $reporteCronologico->setAccion( 'Bonificacion' );
        $reporteCronologico->setIdPedido( $pedido->getIdPedido() );
        
        $fuente = $this->getFuente( $pedidoProductoItem );
        $reporteCronologico->setFuente( $fuente );
        
        $reporteCronologico->setMarca( $marca->getNombre() );
        $reporteCronologico->setCondicionFiscal( $marca->getCondicionFiscal() );
        $reporteCronologico->setCodigoProducto( $productoItem->getCodigo() );
        $reporteCronologico->setProducto( $producto->getDenominacion() );
        $reporteCronologico->setColor( $productoColor->getDenominacion() );
        $reporteCronologico->setTalle( $productoTalle->getDenominacion() );
        $reporteCronologico->setCategoria( $productoCategoria->getDenominacion() );
        $reporteCronologico->setGenero( $productoCategoria->getProductoGenero()->getDenominacion() );
                                
        $reporteCronologico->setPrecioDeluxe( $faltante->getCantidad() * $pedidoProductoItem->getPrecioDeluxe() );
        $reporteCronologico->setCosto( $faltante->getCantidad() * $pedidoProductoItem->getCosto() );
        $reporteCronologico->setCantidad( $faltante->getCantidad() );
                
        $reporteCronologico->setBonificacionDevolucionDeluxe( $bonificacion );
        $reporteCronologico->setBonificacionDevolucionMp( $efectivo );
        
        $reporteCronologico->setBonificacionMotivo('Faltante');
        
        $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
        $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
        $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
        $reporteCronologico->setClienteEmail( $usuario->getEmail() );

        $reporteCronologico->setLocalidad( $envioDetalle['localidad'] );
        $reporteCronologico->setProvincia( $envioDetalle['provincia'] );
        $reporteCronologico->setFormaPago( $pedido->getDescripcionFormaPago(' - ') );
        
        if ( $eshop ) {
            $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
            $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );
        }
        
        $reporteCronologico->save();
    }
    
    public function saveBAJAFP($params)
    {
        $idPedido = $params['idPedido'];
        $bonificacion = $params['bonificacion'];
        
        $pedido = $this->createQuery('p')
                       ->from('pedido p')
                       ->innerJoin('p.pedidoProductoItem ppi')
                       ->innerJoin('p.usuario u')
                       ->innerJoin('p.provincia prov')
                       ->addWhere('p.id_pedido = ?', $idPedido)
                       ->fetchOne();

        $envioDetalle = $pedido->getArrayEnvioDetalle();

        // Get de objetos relacionados al pedido
        $usuario = $pedido->getUsuario();
        $provincia = $pedido->getProvincia();
        $pedidoProductoItems = $pedido->getPedidoProductoItem();
        $eshop = $pedido->getEshop();
    
        $reporteCronologico = new reporteCronologico();
        $reporteCronologico->setAccion( 'Bonificacion' );
        $reporteCronologico->setIdPedido( $pedido->getIdPedido() );
                
        $precioDB = $cantidad = $costo = 0;
        foreach( $pedidoProductoItems as $pedidoProductoItem)
        {
            $precioDB += $pedidoProductoItem->getCantidad() * $pedidoProductoItem->getPrecioDeluxe();
            $costo += $pedidoProductoItem->getCantidad() * $pedidoProductoItem->getCosto();
            $cantidad += $pedidoProductoItem->getCantidad();
        }
        
        $reporteCronologico->setPrecioDeluxe( $precioDB );
        $reporteCronologico->setCosto( $costo );
        $reporteCronologico->setCantidad( $cantidad );
        
        if ($bonificacion)
        {
            $reporteCronologico->setBonificacionDevolucionDeluxe( $pedido->getMontoTotal() );
        }
        else
       {
            $reporteCronologico->setBonificacionDevolucionMp( $pedido->getMontoTotal() );
        }
        
        $reporteCronologico->setBonificacionMotivo('Pago fuera de plazo');
        
        $reporteCronologico->setCliente( $usuario->getNombreCompleto() );
        $reporteCronologico->setClienteTipoDocumento( $usuario->getTipoDocumento() );
        $reporteCronologico->setClienteDocumento( $usuario->getDocumento() );
        $reporteCronologico->setClienteEmail( $usuario->getEmail() );
        
        $reporteCronologico->setLocalidad( $envioDetalle['localidad'] );
        $reporteCronologico->setProvincia( $envioDetalle['provincia'] );
        $reporteCronologico->setFormaPago( $pedido->getDescripcionFormaPago(' - ') );
        
        if ( $eshop ) {
            $reporteCronologico->setIdEshop( $eshop->getIdEshop() );
            $reporteCronologico->setNombreEshop( $eshop->getDenominacion() );
        }
        
        $reporteCronologico->save();
    }
    
    protected function getFuente($pedidoProductoItem )
    {
        $pedidoProductoItemCampanas = $pedidoProductoItem->getPedidoProductoItemCampana();
        
        if (count($pedidoProductoItemCampanas))
        {
            $arr = array();
            foreach ($pedidoProductoItemCampanas as $pedidoProductoItemCampana)
            {
                $campana = $pedidoProductoItemCampana->getCampana();
                $arr[] = $campana->getDenominacion() . ' ' . $campana->getDateTimeObject('fecha_inicio')->format("d/m/Y") . ' al ' . $campana->getDateTimeObject('fecha_fin')->format("d/m/Y");
            }
        
            $fuente = implode('\n', $arr);
        }
        else
       {
            $fuente = ( $pedidoProductoItem->esOutlet() ) ? 'Outlet' : 'Stk. Permanente';
        }
        
        return $fuente;
    }
    
    public function getVentasReporteMensual($desde, $hasta)
    {
        $fuentes = $this->createQuery('r')
                        ->addSelect('r.fuente')
                        ->addSelect('SUM(r.precio_deluxe)/1.21 as precio_sin_iva')
                        ->addSelect('SUM(r.precio_deluxe) as precio_con_iva')
                        ->addSelect('SUM(r.costo) as costo_con_iva')
                        ->addSelect('SUM(r.costo/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as costo_sin_iva')
                        ->addSelect('SUM(r.cantidad) as unidades')  
                        ->addSelect('COUNT(DISTINCT(r.cliente)) as clientes')
                        ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos')
                        ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                        ->addWhere('r.accion = ?', 'Pedido Detalle' )
                        ->addWhere('r.id_eshop IS NULL' )
                        ->groupBy('fuente')
                        ->orderBy('precio_con_iva DESC')
                        ->fetchArray();
        
        $marcas = $this->createQuery('r')
                        ->addSelect('r.fuente')
                        ->addSelect('r.marca')
                        ->addSelect('SUM(r.precio_deluxe)/1.21 as precio_sin_iva')
                        ->addSelect('SUM(r.precio_deluxe) as precio_con_iva')
                        ->addSelect('SUM(r.costo) as costo_con_iva')
                        ->addSelect('SUM(r.costo/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as costo_sin_iva')
                        ->addSelect('SUM(r.cantidad) as unidades')
                        ->addSelect('COUNT(DISTINCT(r.cliente)) as clientes')
                        ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos')
                        ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                        ->addWhere('r.accion = ?', 'Pedido Detalle' )
                        ->addWhere('r.id_eshop IS NULL' )
                        ->groupBy('fuente, marca')
                        ->orderBy('precio_con_iva DESC')
                        ->fetchArray();
        
        $totales = $this->createQuery('r')
                        ->addSelect('\'Totales\' as fuente')
                        ->addSelect('SUM(r.precio_deluxe)/1.21 as precio_sin_iva')
                        ->addSelect('SUM(r.precio_deluxe) as precio_con_iva')
                        ->addSelect('SUM(r.costo) as costo_con_iva')
                        ->addSelect('SUM(r.costo/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as costo_sin_iva')
                        ->addSelect('SUM(r.cantidad) as unidades')
                        ->addSelect('COUNT(DISTINCT(r.cliente)) as clientes')
                        ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos')
                        ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                        ->addWhere('r.accion = ?', 'Pedido Detalle' )
                        ->addWhere('r.id_eshop IS NULL' )
                        ->fetchOne( array(), Doctrine::HYDRATE_ARRAY );
        
        // Se agrupan las marcas
        $data = array();
        foreach( $marcas as $row )
        {
            if ( !isset( $data[ $row['fuente'] ]) )
            {
                $data[ $row['fuente'] ] = array();
            }            
            
            $data[ $row['fuente'] ][] = $row;
        }         

        // Se arma el resultado final
        $fuente = null;
        $result = array();
        foreach( $fuentes as $row )
        {
            $result[] = $row;

            
            if ( count( $data[ $row['fuente'] ] ) > 1 )
            {
                $result = array_merge($result, $data[ $row['fuente'] ]);
            }
        }
        
        $result[] = $totales;
        
        return array('totalPrecioConIva' => $totales['precio_con_iva'], 'data' => $result);        
    }
    
    public function getVentasxDiaReporteMensual($desde, $hasta, $idEshop = null)
    {
        $q =  $this->createQuery('r')
                        ->addSelect('DATE(r.fecha) as fecha')
                        ->addSelect('SUM(r.precio_deluxe) as venta_con_iva')
                        ->addSelect('SUM(r.descuento) as descuentos')
                        ->addSelect('SUM(r.costo_envio) as envio')
                        ->addSelect('SUM(r.total_facturado) as total_facturado')
                        ->addSelect('SUM(r.cantidad) as unidades')
                        ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos')
                        ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                        ->addWhere('r.accion = ?', 'Pedido Total' )
                        ->groupBy('DATE(r.fecha)')
                        ->orderBy('DATE(r.fecha)');
        
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        $data = $q->fetchArray();
        
        $totalVentasConIva = 0;
        foreach( $data as $row )
        {
            $totalVentasConIva += $row['venta_con_iva'];
        }
        
        return array('totalVentasConIva' => $totalVentasConIva, 'data' => $data);
    }
    
    public function getVentasxProvinciaReporteMensual($desde, $hasta, $idEshop = null)
    {
        $q =  $this->createQuery('r')
                   ->addSelect('r.provincia as provincia')
                   ->addSelect('SUM(r.precio_deluxe) as venta_con_iva')
                   ->addSelect('SUM(r.descuento) as descuentos')
                   ->addSelect('SUM(r.costo_envio) as envio')
                   ->addSelect('SUM(r.total_facturado) as total_facturado')
                   ->addSelect('SUM(r.cantidad) as unidades')
                   ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos')
                   ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                   ->addWhere('r.accion = ?', 'Pedido Total' )
                   ->groupBy('r.provincia')
                   ->orderBy('venta_con_iva DESC');
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        $data = $q->fetchArray();
                
        $totalVentasConIva = 0;
        foreach( $data as $row )
        {
            $totalVentasConIva += $row['venta_con_iva'];
        }
    
        return array('totalVentasConIva' => $totalVentasConIva, 'data' => $data);
    }
    
    public function getDescuentosReporteMensual($desde, $hasta, $idEshop = null)
    {        
        $q = $this->createQuery('r')
                  ->addSelect('r.descuento_motivo')
                  ->addSelect('r.descuento_codigo')
                  ->addSelect('SUM(r.cantidad) as unidades')
                  ->addSelect('SUM(r.descuento) as monto')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.descuento_motivo IS NOT NULL')
                  ->groupBy('r.descuento_motivo, r.descuento_codigo');
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        return $q->fetchArray();
        
    }
    
    public function getDevolucionesReporteMensual($desde, $hasta, $idEshop = null)
    {
        $q = $this->createQuery('r')
                  ->addSelect('r.bonificacion_motivo')
                  ->addSelect('r.bonificacion_submotivo')
                  ->addSelect('SUM(r.cantidad) as unidades')
                  ->addSelect('SUM(r.bonificacion_devolucion_mp) as devolucion_mp')
                  ->addSelect(' SUM( IF(r.bonificacion_devolucion_mp <> 0, r.cantidad, 0) ) as unidades_mp')
                  ->addSelect('SUM(r.bonificacion_devolucion_deluxe) as devolucion_cuenta')
                  ->addSelect(' SUM( IF(r.bonificacion_devolucion_deluxe <> 0, r.cantidad, 0) ) as unidades_cuenta')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.bonificacion_motivo IS NOT NULL')
                  ->groupBy('r.bonificacion_motivo, r.bonificacion_submotivo');
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        return $q->fetchArray();
    }

    public function getFormaPagoReporteMensual($desde, $hasta)
    {
        $data = $this->createQuery('r')
        ->addSelect('r.forma_pago')
        ->addSelect('SUM(r.precio_deluxe) as ventas')
        ->addSelect('COUNT(DISTINCT(id_pedido)) as pedidos')
        ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
        ->addWhere('r.forma_pago IS NOT NULL')
        ->addWhere('r.accion = ?', 'Pedido Detalle' )
        ->addWhere('r.id_eshop IS NULL' )
        ->groupBy('r.forma_pago')
        ->fetchArray();
    
        $totalVentas = 0;
        foreach( $data as $row )
        {
            $totalVentas += $row['ventas'];
        }
    
        return array('totalVentas' => $totalVentas, 'data' => $data);
    
    }
    

    public function getEnvioReporteMensual($desde, $hasta, $idEshop = null)
    {
        $q = $this->createQuery('r')
                  ->addSelect('SUM(r.costo_envio) as envio')
                  ->addSelect('SUM(r.costo_envio_deluxe) as costo_envio')
                  ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos')
                  ->addSelect('COUNT(DISTINCT(IF(r.tipo_envio = \'DOM\', r.id_pedido, null))) as pedidos_domicilio')
                  ->addSelect('COUNT(DISTINCT(IF(r.tipo_envio = \'SUC\', r.id_pedido, null))) as pedidos_sucursal')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.accion = ?', 'Pedido Total' );
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        $reporteA = $q->fetchOne( array(), Doctrine::HYDRATE_ARRAY );
         
        $q = $this->createQuery('r')
                  ->addSelect('SUM(r.costo_envio_deluxe) as costo_envio_gratis')
                  ->addSelect('COUNT(DISTINCT(r.id_pedido)) as pedidos_envio_gratis')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.accion = ?', 'Pedido Total' )
                  ->addWhere('r.costo_envio = ?', 0 );
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        $reporteB = $q->fetchOne( array(), Doctrine::HYDRATE_ARRAY );
        
        $q = $this->createQuery('r')
                  ->addSelect('COUNT(*) as logistica_inversa_devoluciones')
                  ->addSelect('SUM(COALESCE(r.bonificacion_devolucion_mp, r.bonificacion_devolucion_deluxe)) as logistica_inversa_costo')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.accion = ?', 'Bonificacion - Envio' );
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        $reporteC = $q->fetchOne( array(), Doctrine::HYDRATE_ARRAY );
        
        $reporteC['logistica_inversa_costo'] = abs($reporteC['logistica_inversa_costo']);
        
        return array_merge( $reporteA, $reporteB, $reporteC );
    }
    
    public function getDetalleDevolucionesReporteMensual($desde, $hasta, $idEshop = null )
    {
        $q = $this->createQuery('r')
                  ->addSelect('r.bonificacion_submotivo')
                  ->addSelect('r.marca as marca')
                  ->addSelect('r.codigo_producto as codigo')
                  ->addSelect('r.producto as producto')
                  ->addSelect('SUM(r.cantidad) as unidades')
                  ->addSelect('AVG(r.precio_deluxe/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as precio_unitario_sin_iva')
                  ->addSelect('SUM(r.costo) as costo_con_iva')
                  ->addSelect('SUM(r.costo/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as costo_sin_iva')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.accion = ?', 'Bonificacion' )
                  ->addWhere('r.bonificacion_motivo = ?', 'Devolucion' )
                  ->groupBy('r.bonificacion_submotivo, r.marca, r.producto');
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        return $q->fetchArray();
    }
    
    public function getDetalleFaltantesReporteMensual($desde, $hasta, $idEshop = null )
    {
    
        $q = $this->createQuery('r')
                  ->addSelect('r.marca as marca')
                  ->addSelect('r.codigo_producto as codigo')
                  ->addSelect('r.producto as producto')
                  ->addSelect('SUM(r.cantidad) as unidades')
                  ->addSelect('AVG(r.precio_deluxe/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as precio_unitario_sin_iva')
                  ->addSelect('SUM(r.costo) as costo_con_iva')
                  ->addSelect('SUM(r.costo/IF(r.condicion_fiscal = \'RIN\', 1.21, 1)) as costo_sin_iva')
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.accion = ?', 'Bonificacion' )
                  ->addWhere('r.bonificacion_motivo = ?', 'Faltante' )
                  ->groupBy('r.bonificacion_submotivo, r.marca, r.producto');
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        return $q->fetchArray();
    }

    public function getProductosVendidosReporteMensual($desde, $hasta, $orden = 'DESC', $idEshop = null)
    {
        $orden = strtoupper( $orden );
        $orden = ( $orden == 'DESC' ) ? 'DESC' : 'ASC';         
        
        $q = $this->createQuery('r')
                  ->addSelect('r.codigo_producto, r.producto, r.marca')
                  ->addSelect('SUM(r.precio_deluxe)/1.21 as precio_sin_iva')
                  ->addSelect('SUM(r.precio_deluxe) as precio_con_iva')
                  ->addSelect('SUM(r.cantidad) as unidades')  
                  ->addWhere('(? <= DATE(r.fecha) AND DATE(r.fecha) <= ?)', array($desde, $hasta) )
                  ->addWhere('r.accion = ?', 'Pedido Detalle' )
                  ->groupBy('r.codigo_producto, r.producto, r.marca')
                  ->orderBy('unidades ' . $orden . ', precio_con_iva ' . $orden )
                  ->limit(20);
        
        if ( $idEshop ) {
            $q->addWhere('r.id_eshop = ?', $idEshop );
        } else {
            $q->addWhere('r.id_eshop IS NULL' );
        }
        
        return $q->fetchArray();
    }
    
}