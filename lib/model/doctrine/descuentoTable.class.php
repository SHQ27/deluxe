<?php


class descuentoTable extends Doctrine_Table
{
    
	/**
	* Retorna una instancia de descuentoTable;
	* 
	* @return descuentoTable
	*/
    public static function getInstance()
    {
        return Doctrine_Core::getTable('descuento');
    }
    
	/**
	* Retorna todos los productoImagen de un producto
	*  
	* @return descuento
	*/
	public function getAvailableByCodigo( $codigo, $idEshop )
	{
    	$q = $this->createQuery('d');
						    	
    	if ( $idEshop ) {
    	    $q->addwhere('d.id_eshop = ?', $idEshop );
    	} else {
    	    $q->addwhere('d.id_eshop IS NULL');
    	}
    	
    	$q->addWhere('lower(d.codigo) = lower(?)', $codigo)
    	  ->addWhere('( d.vigencia_desde IS NULL OR d.vigencia_desde < now() )')
    	  ->addWhere('( d.vigencia_hasta IS NULL OR d.vigencia_hasta > now() )')
    	  ->addWhere('d.utilizados < d.total');
    	
    	$descuentos = $q->execute();
    	
    	foreach( $descuentos as $descuento )
    	{
    	    if ( $this->isValid($descuento) ) return $descuento;
    	}
    	
    	return null;
	}
	
	protected function isValid($descuento)
	{	    	    
	    // Verifica que exista
	    if (!$descuento) return false;
	    	    
	    // Verifica que haya cantidad disponible
	    $cantidadEnCarrito = carritoDescuentoTable::getInstance()->quantityByIdDescuento( $descuento->getIdDescuento() );
	    if ( ($descuento->getUtilizados() + $cantidadEnCarrito) >= $descuento->getTotal() ) return false;
	    
	    // Verifica restricciones
	    $productos = array();
	    $productosItems = array();
	    $cantidad = 0;
	    $session = sessionTable::getInstance()->getSession();
	    $carritoProductoItems = carritoProductoItemTable::getInstance()->listByIdSession( $session->getIdSession() );
	    foreach ($carritoProductoItems as $carritoProductoItem)
	    {
	        $productos[] = $carritoProductoItem->getProductoItem()->getProducto();
	        $productosItems[] = $carritoProductoItem->getProductoItem();
	        $cantidad += $carritoProductoItem->getCantidad();
	    }
	    
	    $descuentoRestricciones = $descuento->getDescuentoRestriccion();
	    $agrupadas = array();
	    foreach( $descuentoRestricciones as $descuentoRestriccion )
	    {
	        $agrupadas[$descuentoRestriccion->getTipo()][] = $descuentoRestriccion;
	    }
	    
	    foreach( $agrupadas as $tipo => $descuentoRestricciones )
	    {
	        $method = 'validRestriccion' . $tipo;
	        if (!$this->$method( $descuentoRestricciones, $productos, $productosItems, $cantidad ) ) return false;
	    }
	    
	    return true;
	}
	
	protected function validRestriccionMARCA($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $descuentoRestriccion = current($descuentoRestricciones);
	
	    $valid = true;
	    
	    foreach ($productos as $producto)
	    {
	        if (( !$descuentoRestriccion->getExcluir() && $descuentoRestriccion->getValor() != $producto->getIdMarca() ) ||
 				(  $descuentoRestriccion->getExcluir() && $descuentoRestriccion->getValor() == $producto->getIdMarca() ) )
	        {
	            $valid = false;
	            break;
	        } 
	    }
	    
	    return $valid;
	}
	

	protected function validRestriccionCAMPA($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $valid = true;
	    
	    $valores = array();
	    foreach ($productos as $producto) {
	    	$productoCampanas = $producto->getProductoCampana();
	    	foreach ($productoCampanas as $productoCampana) {
	    		$valores[] = $productoCampana->getIdCampana();
	    	}
	    }

	    $idDescuento = $descuentoRestricciones[0]->getIdDescuento();
	    $excluir = $descuentoRestricciones[0]->getExcluir();

	    $valid = descuentoRestriccionTable::getInstance()->validarGrupo( $idDescuento, descuentoRestriccion::CAMPANA, $valores, $excluir );
	    
	    return $valid;
	}
	
	protected function validRestriccionRETAG($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $descuentoRestriccion = current($descuentoRestricciones);
	
	    $valid = true;
	
	    foreach ($productos as $producto)
	    {
	        $productosTag = $producto->getProductoTag();
	        
	        foreach( $productosTag as $productoTag )
	        {
	            $existTag = ( $descuentoRestriccion->getValor() == $productoTag->getIdTag() );
	            if ($existTag) break;
	        }
	        

	        if (( !$descuentoRestriccion->getExcluir() && !$existTag ) ||
 				(  $descuentoRestriccion->getExcluir() &&  $existTag ) )
	        {
	            $valid = false;
	            break;
	        }
	        
	    }
	
	    return $valid;
	}
	
	protected function validRestriccionFCOLO($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $descuentoRestriccion = current($descuentoRestricciones);
	
	    $valid = true;
	
	    foreach ($productosItems as $productosItem)
	    {
	        $productoColor = $productosItem->getProductoColor();
	        $familiaColor = $productoColor->getFamiliaColor();
	
	        if ( !$familiaColor )
	        {
	            $valid = false;
	            break;
	        }

	        if (( !$descuentoRestriccion->getExcluir() && $descuentoRestriccion->getValor() != $familiaColor->getIdFamiliaColor() ) ||
 				(  $descuentoRestriccion->getExcluir() && $descuentoRestriccion->getValor() == $familiaColor->getIdFamiliaColor() ) )
	        {
	            $valid = false;
	            break;
	        }
	    }
	
	    return $valid;
	}
	
	protected function validRestriccionMOMIN($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $descuentoRestriccion = current($descuentoRestricciones);
	    $session = sessionTable::getInstance()->getSession();
	    $montoProductos = sessionTable::getInstance()->getMontoProductos( $session->getIdSession() );
	    return ( $montoProductos >= $descuentoRestriccion->getValor() );
	}
	
	protected function validRestriccionMOMAX($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $descuentoRestriccion = current($descuentoRestricciones);
	    $session = sessionTable::getInstance()->getSession();
	    $montoProductos = sessionTable::getInstance()->getMontoProductos( $session->getIdSession() );
	    return ( $montoProductos <= $descuentoRestriccion->getValor() );
	}
	
	protected function validRestriccionPRODU($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $valid = true;
	    
	    $valores = array();
	    foreach ($productos as $producto) {
			$valores[] = $producto->getIdProducto();
	    }

	    $idDescuento = $descuentoRestricciones[0]->getIdDescuento();
	    $excluir = $descuentoRestricciones[0]->getExcluir();

	    $valid = descuentoRestriccionTable::getInstance()->validarGrupo( $idDescuento, descuentoRestriccion::PRODUCTOS, $valores, $excluir );
	    
	    return $valid;
	}

	protected function validRestriccionCATEG($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $valid = true;
	    
	    $valores = array();
	    foreach ($productos as $producto) {
			$valores[] = $producto->getIdProductoCategoria();
	    }

	    $idDescuento = $descuentoRestricciones[0]->getIdDescuento();
	    $excluir = $descuentoRestricciones[0]->getExcluir();

	    $valid = descuentoRestriccionTable::getInstance()->validarGrupo( $idDescuento, descuentoRestriccion::CATEGORIA, $valores, $excluir );
	    
	    return $valid;
	}
	
	protected function validRestriccionOUTLE($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{	    
	    foreach( $productos as $producto ) if (!$producto->getEsOutlet()) return false;
	    return true;
	}
	
	protected function validRestriccionCOMIN($descuentoRestricciones, $productos, $productosItems, $cantidad)
	{
	    $descuentoRestriccion = current($descuentoRestricciones);
	    $cantidadMinima = $descuentoRestriccion->getValor();
	    	    
	    $valid = true;
	
	    if ( $cantidad <= $cantidadMinima )
	    {
	        $valid = false;
	    }
	
	    return $valid;
	}
	
	/**
	* Update del numero de usos de un descuento
	*/
	public function updateUso( $idDescuento )
	{

		$enCarritos = carritoDescuentoTable::getInstance()->quantityByIdDescuento( $idDescuento );
		$enPedidos = pedidoDescuentoTable::getInstance()->contarUtilizados( $idDescuento );
		$total = $enCarritos + $enPedidos;

        $this->createQuery('d')
		     ->update()
		     ->set('utilizados', $total)
		     ->addWhere('d.id_descuento = ?', $idDescuento)
		     ->execute();
	}
	
	
	public function deleteNoUtilizados()
	{
	    $idsNoborrar = pedidoDescuentoTable::getInstance()->listIdsDescuentos();
	    
	    $idsBorrar = $this  ->createQuery('d')
                	        ->select('d.id_descuento')
                    	    ->whereNotIn('d.id_descuento', $idsNoborrar)
                    	    ->addWhere('d.vigencia_hasta < now()')
                    	    ->addWhere('d.utilizados = 0')
                	        ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
	    
	    
	    descuentoProductoTable::getInstance()->deleteByIdsDescuento($idsBorrar);

	    if ( count( $idsBorrar ) )
	    {
    	    $this->createQuery('dp')
    	    ->whereIn('dp.id_descuento', $idsBorrar)
    	    ->whereNotIn('dp.id_descuento', $idsNoborrar)
    	    ->delete()
    	    ->execute();
	    }	    	    
	}
	
	public function deleteNoVendidos($codigos, $prefix, $descuentoBase)
	{	    
	    $idsNoborrar = $this->createQuery('d')
                    	    ->select('d.id_descuento')
                    	    ->whereIn('d.codigo', $codigos)
                    	    ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
		    
	    $idsBorrar = $this  ->createQuery('d')
	    ->select('d.id_descuento')
	    ->whereNotIn('d.id_descuento', $idsNoborrar)
	    ->addWhere('d.codigo like ?', $prefix . "%" )
	    ->addWhere('d.vigencia_hasta = ?', $descuentoBase->getVigenciaHasta() )
	    ->addWhere('d.id_tipo_descuento = ?', $descuentoBase->getIdTipoDescuento() )
	    ->addWhere('d.valor = ?', $descuentoBase->getValor() )
	    ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
	    
	    $cantBorrados = count( $idsBorrar );
	    
	    if ( $cantBorrados )
	    {
	        $this->createQuery('dp')
	        ->whereIn('dp.id_descuento', $idsBorrar)
	        ->whereNotIn('dp.id_descuento', $idsNoborrar)
	        ->delete()
	        ->execute();
	    }
	    
	    return $cantBorrados;
	}
	
	public function descuentosConErrorAlBorrarVendidos($codigos, $prefix, $descuentoBase)
	{
	    $idsNoborrar = $this->createQuery('d')
	    ->select('d.id_descuento')
	    ->whereIn('d.codigo', $codigos)
	    ->execute( array(), Doctrine::HYDRATE_SINGLE_SCALAR );
	
	    return $this   ->createQuery('d')
                	    ->select('d.*')
                	    ->innerJoin('d.pedidoDescuento pd')
                	    ->whereNotIn('d.id_descuento', $idsNoborrar)
                	    ->addWhere('d.codigo like ?', $prefix . "%" )
                	    ->addWhere('d.vigencia_hasta = ?', $descuentoBase->getVigenciaHasta() )
                	    ->addWhere('d.id_tipo_descuento = ?', $descuentoBase->getIdTipoDescuento() )
                	    ->addWhere('d.valor = ?', $descuentoBase->getValor() )
                	    ->execute();
	}
	
	
	public function reporteCuponeras($params)
	{	    	    
	    $data    = array();
	    
	    $q1 = $this->createQuery('d')
    	          ->addSelect('SUM(p.monto_total) as monto_total')
    	          ->addSelect('SUM(p.monto_productos) as monto_productos')
    	          ->addSelect('SUM(p.monto_envio) as monto_envio')
    	          ->addSelect('SUM(pd.monto) as monto_descuentos_utilizados')
    	          ->addSelect('MAX(d.valor) as valor')
    	          ->addSelect('MAX(d.id_tipo_descuento) as id_tipo_descuento')
    	          ->addSelect('COUNT(d.id_descuento) as utilizados')
    	          ->innerJoin('d.pedidoDescuento pd')
    	          ->innerJoin('pd.pedido p')
    	          ->addWhere('d.codigo like ?', $params['prefijo'] . "%" )
    	          ->addWhere('p.fecha_baja IS NULL' )
    	          ->addWhere('p.fecha_pago IS NOT NULL' );
    	         
        if ( $params['vigencia_desde'] )
        {
            $q1->addWhere('date(d.vigencia_desde) = ?', $params['vigencia_desde'] );
        }
        
        $q1->addWhere('date(d.vigencia_hasta) = ?', $params['vigencia_hasta'] );
    	                       	         
        $data[0] = $q1->fetchArray();
    
        $data[0] = current($data[0]);
	    
	    $q2 = $this->createQuery('d')
             	  ->addSelect('SUM(ppi.costo) as costo')
             	  ->innerJoin('d.pedidoDescuento pd')
             	  ->innerJoin('pd.pedido p')
            	  ->innerJoin('p.pedidoProductoItem ppi')
            	  ->addWhere('d.codigo like ?', $params['prefijo'] . "%" )
            	  ->addWhere('p.fecha_baja IS NULL' )
            	  ->addWhere('p.fecha_pago IS NOT NULL' );
                    	 
    	if ( $params['vigencia_desde'] )
    	{
    	    $q2->addWhere('date(d.vigencia_desde) = ?', $params['vigencia_desde'] );
    	}
    	 
    	$q2->addWhere('date(d.vigencia_hasta) = ?', $params['vigencia_hasta'] );
                    	 
                    	 
    	$data[1] = $q2->fetchArray();
	    
	    $data[1] = current($data[1]);
	    
	    $arr = array_merge( $data[0], $data[1] );
	    $data = $arr;
	    
	    $data['valor_pagado'] = $params['valor_pagado'];
	    $data['comision_cuponera'] = $params['comision_cuponera'] * 100;
	    
	    $data['monto_cupones_utilizados'] = $params['valor_pagado'] * $data['utilizados'];
	    $data['monto_comision_cuponera'] = $data['monto_cupones_utilizados'] * $params['comision_cuponera']; 
	    $data['total_ingresos'] = $data['monto_cupones_utilizados'] + $data['monto_total'];
	    $data['total_egresos'] = $data['monto_envio'] + $data['costo'] + $data['monto_comision_cuponera'];
	    $data['resultado'] = $data['total_ingresos'] - $data['total_egresos'];
	    
	    return $data;
	}
	
}