    <div class="titulo">DETALLE DE PEDIDO</div>
	<div class="numero">PEDIDO Nº <?php echo $pedido->getIdPedido() ?></div>

    <table class="tableCarrito">
        <thead class="headerCarrito">
            <tr>
                <th class="carritoCol1y2" colspan="2">MIS PRODUCTOS</th>
                <th class="carritoCol3">CANT.</th>
                <th class="carritoCol4">PRECIO</th>
            </tr>
        </thead>
        <tbody class="itemsCarrito">
            <?php $i = 0; ?>
            <?php foreach ($pedido->getPedidoProductoItem() as $pedidoProductoItem): ?>
            <?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>
        	<?php $producto = $productoItem->getProducto(); ?>
            <tr class="item">
                <td class="carritoCol1 foto">
                    <img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>" width="100%" />
                </td>
                <td class="carritoCol2 datos">
                    <div class="nombre"><?php echo truncate_text( $producto->getDenominacion(), 18 ) ?></div>
                    <div class="talle">TALLE. <?php echo $productoItem->getProductoTalle()->getDenominacion() ?></div>
                    <div class="color">COLOR. <?php echo $productoItem->getProductoColor()->getDenominacion() ?></div>
                </td>
                <td class="carritoCol3">
                    <div class="cantidad">
                        <?php echo $pedidoProductoItem->getCantidad() ?>
                    </div>
                </td>
                <td class="carritoCol4 precio total">
                    $ <?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ) ?>.-
                </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

	<div class="grupo">
	    <div class="desc">DETALLE DEL PEDIDO</div>
		<span class="strong">Fecha de realización.</span> <?php echo date('d/m/Y', strtotime($pedido->getFechaAlta())); ?> 
		<br />
		<span class="strong">Estado.</span> <?php echo $pedido->getEstado() ?>
		<br />
	</div>

	<div class="grupo">
		<div class="desc">DETALLE DEL PAGO</div>
		
    	<?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
    	<span class="strong rojo">( El pago aún no se ha procesado )</span>
    	<br/>
    	<?php endif; ?>
		<span class="strong">Valor de los Productos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ) ?> 
		<br />
		<span class="strong">Cargo de envío.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) ?>
		<br />
		<?php if ( (float) $pedido->getMontoDescuento() ): ?>
		<span class="strong">Valor por descuentos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) ?>
		<br />
		<?php endif; ?>			
		<span class="strong">Valor Total.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ) ?>
		<br />
	</div>
	
	<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

	<div class="grupo">
		<div class="desc">PERSONA QUE RECIBIRÁ EL ENVÍO</div>
		<span class="strong">Destinatario.</span> <?php echo $envioDetalle['destinatario']; ?><br />
	</div>
	
	<div class="grupo">
		<?php if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL): ?>
		<div class="desc">ENTREGA EN SUCURAL "<?php echo $envioDetalle['sucursal']; ?>"</div>
		<span class="strong">Dirección.</span> <?php echo $envioDetalle['direccion']; ?>
		<br />
		<span class="strong">Localidad.</span> <?php echo $envioDetalle['localidad']; ?>
		<br />
		<span class="strong">Provincia.</span> <?php echo $envioDetalle['provincia']; ?>
		<br />
		<span class="strong">Teléfono de la sucursal.</span> <?php echo $envioDetalle['telefono']; ?>
		<br />
		<span class="strong">Horarios</span> <?php echo $envioDetalle['horario']; ?>
		<br />
		<?php else:?>
		<div class="desc">ENTREGA EN DOMICIO PROPIO</div>
		<span class="strong">Dirección.</span> <?php echo $envioDetalle['direccion']; ?>
		<br />
		<span class="strong">Localidad.</span> <?php echo $envioDetalle['localidad']; ?>
		<br />
		<span class="strong">Provincia.</span> <?php echo $envioDetalle['provincia']; ?>
		<br />
		<span class="strong">Código Postal.</span> <?php echo $envioDetalle['codigo_postal']; ?>
		<br />
		<?php endif;?>
	</div>
	
	<div class="botones"><div class="cerrar">CERRAR</div></div>