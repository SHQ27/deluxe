<div class="container">
    <div class="titulo MS-15 bold color1 alignC lh19">DETALLE DE PEDIDO</div>
	<div class="numero MS-13 color8 alignC lh19">PEDIDO Nº <?php echo $pedido->getIdPedido() ?></div>
	<div class="linea"><div class="triangulos"></div></div>
	
	<div class="detalle">
	
		<div class="grupo OS-11 color4 lh19">
		    <div class="desc MS-13">DETALLE DEL PEDIDO</div>
			<span class="bold">Fecha de realización.</span> <?php echo date('d/m/Y', strtotime($pedido->getFechaAlta())); ?> 
			<br />
			<span class="bold">Estado.</span> <?php echo $pedido->getEstado() ?>
			<br />
		</div>
	
		<div class="barra">
			<div class="header MS-13 color4 inline c1">
				MIS PRODUCTOS
			</div><div class="header MS-13 color4 inline c3">
				CANTIDAD
			</div><div class="header MS-13 color4 inline c4">
				SUBTOTAL
			</div>
		</div>
				
		<div class="items">		
            <?php $i = 0; ?>
            <?php foreach ($pedido->getPedidoProductoItem() as $pedidoProductoItem): ?>
            <?php $productoItem = $pedidoProductoItem->getProductoItem(); ?>
        	<?php $producto = $productoItem->getProducto(); ?>
            	
			<div class="item">
				<div class="columna c1 inline">
					<div class="foto inline">
					<img width="90" src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>" alt="<?php echo $producto->getDenominacion() ?>" />
					</div>
					<div class="inline datos">
						<div class="nombre MS-18 color1" title="<?php echo $producto->getDenominacion(); ?>"><?php echo truncate_text( $producto->getDenominacion(), 18 ) ?></div>						
						<div class="OS-11 color1 lh18">TALLE. <?php echo $productoItem->getProductoTalle()->getDenominacion() ?></div>
						<div class="OS-11 color2 lh18">COLOR. <?php echo $productoItem->getProductoColor()->getDenominacion() ?></div>
					</div>
				</div>
				<div class="columna c3 inline">
					<div class="cantidad OS-11 color2 lh16"><?php echo $pedidoProductoItem->getCantidad() ?></div>
				</div>
				<div class="columna c4 inline">
					<div class="subtotal MS-18 color8">$ <?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ) ?>.-</div>
				</div>
			</div>
            <?php $i++; ?>
            <?php endforeach; ?>
		</div>
		
		<div class="grupo OS-11 color4 lh19">
			<div class="desc MS-13">DETALLE DEL PAGO</div>
			
        	<?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
        	<span class="bold rojo">( El pago aún no se ha procesado )</span>
        	<br/>
        	<?php endif; ?>
			<span class="bold">Valor de los Productos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ) ?> 
			<br />
			<span class="bold">Cargo de envío.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) ?>
			<br />
    		<?php if ( (float) $pedido->getMontoDescuento() ): ?>
    		<span class="bold">Valor por descuentos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) ?>
    		<br />
    		<?php endif; ?>			
			<span class="bold">Valor Total.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ) ?>
			<br />
		</div>
		
		<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

		<div class="grupo OS-11 color4 lh19">
			<div class="desc MS-13">PERSONA QUE RECIBIRÁ EL ENVÍO</div>
			<span class="bold">Destinatario.</span> <?php echo $envioDetalle['destinatario']; ?><br />
		</div>
		
		<div class="grupo OS-11 color4 lh19">
			<?php if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL): ?>
    		<div class="desc MS-13">ENTREGA EN SUCURAL "<?php echo $envioDetalle['sucursal']; ?>"</div>
    		<span class="bold color2">Dirección.</span> <?php echo $envioDetalle['direccion']; ?>
    		<br />
    		<span class="bold">Localidad.</span> <?php echo $envioDetalle['localidad']; ?>
    		<br />
    		<span class="bold">Provincia.</span> <?php echo $envioDetalle['provincia']; ?>
    		<br />
    		<span class="bold">Teléfono de la sucursal.</span> <?php echo $envioDetalle['telefono']; ?>
    		<br />
    		<span class="bold">Horarios</span> <?php echo $envioDetalle['horario']; ?>
    		<br />
			<?php else:?>
    		<div class="desc MS-13">ENTREGA EN DOMICIO PROPIO</div>
    		<span class="bold">Dirección.</span> <?php echo $envioDetalle['direccion']; ?>
    		<br />
    		<span class="bold">Localidad.</span> <?php echo $envioDetalle['localidad']; ?>
    		<br />
    		<span class="bold">Provincia.</span> <?php echo $envioDetalle['provincia']; ?>
    		<br />
    		<span class="bold">Código Postal.</span> <?php echo $envioDetalle['codigo_postal']; ?>
    		<br />
			<?php endif;?>


		</div>
		
		<div class="alignC"><div class="btOscuro MS-15 bold color7 cerrar">CERRAR</div></div>
		
	</div>
</div>