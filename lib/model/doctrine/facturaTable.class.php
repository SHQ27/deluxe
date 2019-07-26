<?php


class facturaTable extends Doctrine_Table
{
	CONST MAYORES_O_IGUAL_A_MIL = 'MAYORES_O_IGUAL_A_MIL';
	CONST MENORES_A_MIL = 'MENORES_A_MIL';
	
	/**
	* Retorna una instancia de facturaTable;
	* 
	* @return facturaTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('factura');
    }
    
	/**
	* Inserta un pedido en la tabla de factura para que sea procesado por el cron
	* 
	* @param string  $idPedido
	* 
	* @return Doctrine_Collection
	*/
	public function insert($idPedido)
	{
		$configWS = sfConfig::get('app_afip_ws');

	  	$factura = new Factura();
	  	$factura->setIdPedido( $idPedido );
	   	$factura->setProcesada(false);
	   	$factura->setEntorno( $configWS['env'] );
	   	$factura->save();
	}
	
	/**
	* Retorna la factura a partir del pedido relacionado a la misma
	* 
	* @param int  $idPedido
	* @param string  $entorno
	* 
	* @return Doctrine_Collection
	*/
	public function getByIdPedido($idPedido, $entornoDefault = true)
	{
		if ( $entornoDefault === true )
		{
			$configWS = sfConfig::get('app_afip_ws');
			$entornoDefault = $configWS['env'];
		}
		
		return $this->createQuery('f')
	    			    ->addWhere('f.id_pedido = ?', array( $idPedido ))
	    			    ->addWhere('f.entorno = ?', array( $entornoDefault ))
	    			    ->fetchOne();
	}
	
	
	/**
	* Retorna el listado de todas las facturas pendientes de procesar
	* 
	* 
	* @return Doctrine_Collection
	*/
	public function listPendientes($opcion = null, $limit = false)
	{
	    $configWS = sfConfig::get('app_afip_ws');
	    
		$q = $this->createQuery('f')
				  ->innerJoin('f.pedido p')
				  ->addWhere('f.procesada = ?', false)
				  ->addWhere('f.entorno = ?', $configWS['env'] );
		
		if ($opcion == 'MAYORES_O_IGUAL_A_MIL') $q->addWhere('p.monto_facturacion >= 1000');
		if ($opcion == 'MENORES_A_MIL') $q->addWhere('p.monto_facturacion <= 1000');

		if ($limit) $q->limit( $limit );
		
		return $q->execute();
	}
	
	/**
	* Retorna el listado de todas las facturas que coincidan con el array de idsPedido enviado por parametro
	* 
	* @param array  $idsPedido
    * @param string  $entorno
	* 
	* @return Doctrine_Collection
	*/
	public function listByIdPedido($idsPedido, $entornoDefault = true)
	{
	    if ( $entornoDefault === true )
	    {
	        $configWS = sfConfig::get('app_afip_ws');
	        $entornoDefault = $configWS['env'];
	    }
	    
	    return $this->createQuery('f')
            	     ->whereIn('f.id_pedido', $idsPedido)
            	     ->addWhere('f.entorno = ?', $entornoDefault )
            	     ->execute();
	}
	
	/**
	 * Retorna todas las facturas donde su id este en el array $idsFactura
	 *
	 * @param array  $idsFactura
	 *
	 * @return Doctrine_Collection
	 */
	public function listByIdFactura($idsFactura)
	{
	    return $this->createQuery('f')
	    ->whereIn('f.id_factura', $idsFactura)
	    ->execute();
	}
	
	/**
	* Retorna el listado de todas las facturas pendientes a enviar al usuario via email
	* 
	* 
	* @return Doctrine_Collection
	*/
	public function listPendienteEnvio()
	{
		return $this->createQuery('f')
				  ->addWhere('f.procesada = ?', true)
				  ->addWhere('f.resultado = ?', 'A')
				  ->addWhere('f.cae IS NOT NULL')
				  ->addWhere('f.cae_vencimiento IS NOT NULL')
				  ->addWhere('f.comprobante IS NOT NULL')
				  ->addWhere('(f.mail_enviado IS NULL OR f.mail_enviado = ?)', false)
				  ->execute();
	}

	public function listByComprobante($comprobante)
	{
		$configWS = sfConfig::get('app_afip_ws');
		
	    return $this->createQuery('f')
		    ->addWhere('f.comprobante >= ?', $comprobante)
		    ->addWhere('f.entorno = ?', $configWS['env'])
		    ->orderBy('CAST(comprobante AS SIGNED) asc')
		    ->execute();
	}

	public function listar()
	{
		$configWS = sfConfig::get('app_afip_ws');
		
	    return $this->createQuery('f')
		    ->orderBy('CAST(comprobante AS SIGNED) asc')
		    ->addWhere('f.entorno = ?', $configWS['env'])
		    ->execute();
	}
	
	public function libroIvaVenta($fechaDesde = null, $fechaHasta = null)
	{
	    $configWS = sfConfig::get('app_afip_ws');

	    $configWS['env'] = 'prod';
	    
	    $sqlFacturas  = '';
	    $sqlFacturas .= 'SELECT \'FACTURA\' as tipo, p.fecha_facturacion as fecha, p.id_pedido as id_pedido, p.fecha_pago as fecha_pago, f.comprobante as comprobante, u.nombre as nombre, u.apellido as apellido, u.tipo_documento as tipo_documento, u.documento as documento, p.monto_facturacion as importe, (p.monto_envio - ( coalesce(pd.monto, 0) + coalesce(pb.monto, 0) ) ) as envio, SUM(ppi.costo/IF(m.condicion_fiscal = \'RIN\', 1.21, 1)) as costo_mercaderia, prov.nombre as provincia, fp.denominacion as forma_pago ';
	    $sqlFacturas .= 'FROM factura f ';
	    $sqlFacturas .= 'INNER JOIN pedido p ON p.id_pedido = f.id_pedido ';
	    $sqlFacturas .= 'INNER JOIN pedido_producto_item ppi ON ppi.id_pedido = p.id_pedido ';
	    $sqlFacturas .= 'INNER JOIN producto_item pi ON pi.id_producto_item = ppi.id_producto_item ';
	    $sqlFacturas .= 'INNER JOIN producto pr ON pr.id_producto = pi.id_producto ';
	    $sqlFacturas .= 'INNER JOIN marca m ON m.id_marca = pr.id_marca ';
	    $sqlFacturas .= 'INNER JOIN usuario u ON u.id_usuario = p.id_usuario ';
	    $sqlFacturas .= 'INNER JOIN provincia prov on prov.id_provincia = p.envio_id_provincia ';
	    $sqlFacturas .= 'INNER JOIN forma_pago fp on fp.id_forma_pago = p.id_forma_pago ';
	    $sqlFacturas .= 'LEFT JOIN pedido_descuento pd ON p.id_pedido = pd.id_pedido AND pd.id_tipo_descuento = \'FSHIP\'';
	    $sqlFacturas .= 'LEFT JOIN pedido_bonificacion pb ON p.id_pedido = pb.id_pedido AND pb.id_tipo_descuento = \'FSHIP\'';
	    $sqlFacturas .= 'WHERE f.entorno = ? AND date(p.fecha_facturacion) >= ? AND date(p.fecha_facturacion) <= ? AND f.resultado = ? ';
	    $sqlFacturas .= 'GROUP BY p.fecha_facturacion, p.id_pedido, p.fecha_pago, f.comprobante, u.nombre, u.apellido, p.monto_facturacion ';
	    
	    $sqlNCredito  = '';
	    $sqlNCredito .= 'SELECT \'NCREDITO\' as tipo, ncwr.fecha as fecha, group_concat(p.id_pedido separator \', \') as id_pedido, null as fecha_pago, nc.comprobante as comprobante, u.nombre as nombre, u.apellido as apellido, u.tipo_documento as tipo_documento, u.documento as documento, nc.importe as importe, \'\' as monto_envio, \'\' as costo_mercaderia, prov.nombre as provincia, \'\' as forma_pago ';
	    $sqlNCredito .= 'FROM ncredito nc ';
	    $sqlNCredito .= 'INNER JOIN ncredito_ws_request_ncredito ncwrnc ON ncwrnc.id_ncredito = nc.id_ncredito ';
	    $sqlNCredito .= 'INNER JOIN ncredito_ws_request ncwr ON ncwr.id_ncredito_ws_request = ncwrnc.id_ncredito_ws_request ';
	    $sqlNCredito .= 'INNER JOIN ncredito_factura ncf ON ncf.id_ncredito = nc.id_ncredito ';
	    $sqlNCredito .= 'INNER JOIN factura f ON f.id_factura = ncf.id_factura ';
	    $sqlNCredito .= 'INNER JOIN pedido p ON p.id_pedido= f.id_pedido ';
	    $sqlNCredito .= 'INNER JOIN usuario u ON u.id_usuario = p.id_usuario ';
	    $sqlNCredito .= 'INNER JOIN provincia prov on prov.id_provincia = p.envio_id_provincia ';
	    $sqlNCredito .= 'WHERE f.entorno = ? AND date(ncwr.fecha) >= ? AND date(ncwr.fecha) <= ? AND nc.resultado = ? ';
	    $sqlNCredito .= 'GROUP BY nc.id_ncredito ';
	    	    	    
	    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
	    
	    return  $q->fetchAll( "SELECT * FROM ($sqlFacturas UNION $sqlNCredito) T ORDER BY fecha ASC", array($configWS['env'], $fechaDesde, $fechaHasta, 'A', $configWS['env'], $fechaDesde, $fechaHasta, 'A'));
	}
}
