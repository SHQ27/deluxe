<div class="detalleDevolucion">

	<h2 class="first">Datos de la Devolucion</h2>
	
	<ul>
	    <li><strong>eShop:</strong> <?php echo $devolucion->getEshop(); ?></li>
		<li><strong>Envio:</strong> <?php echo $devolucion->getTipoEnvio() == 'DELUXE' ? 'Propio' : 'Via OCA'; ?></li>
		<li><strong>Devolución via:</strong> <?php echo $devolucion->getTipoCredito() == 'DELUXE' ? 'Bonificación' : 'Mercado Pago'; ?></li>
		<li><strong>Motivo:</strong> <?php echo $devolucion->getDevolucionMotivo()->getDenominacion(); ?> <?php echo ( $devolucion->getMotivoOtro() ) ? '- ' . $devolucion->getMotivoOtro() : '' ?></li>
	</ul>
	
	<h2>Detalle de productos</h2>
	
	<table class="detalleProductos">
		<tr>
		    <td><strong>Pedido</strong></td>
			<td><strong>Codigo</strong></td>
			<td><strong>Producto</strong></td>
			<td><strong>Diversidad</strong></td>
			<td><strong>Marca</strong></td>
			<td><strong>Talle</strong></td>
			<td><strong>Color</strong></td>
			<td><strong>Cantidad</strong></td>
			<td><strong>Precio</strong></td>
		</tr>
		<?php $i = 0; ?>
		<?php foreach($devolucion->getDevolucionProductoItem() as $devolucionProductoItem): ?>
		<?php $pedidoProductoItem = $devolucionProductoItem->getPedidoProductoItem(); ?>


		<?php if ( $devolucionProductoItem->getIdProductoItem() ): ?>
		<?php $productoItem = $devolucionProductoItem->getProductoItem(); ?>
		<?php else: ?>
		<?php $productoItem = $devolucionProductoItem->getPedidoProductoItem()->getProductoItem(); ?>
		<?php endif; ?>

		<tr class="<?php echo ($i%2 == 0)? 'blanco' : 'gris' ?>">
			<?php $producto = $productoItem->getProducto(); ?>
			
			
			<td class="first"><a href="/backend/pedidos/<?php echo $pedidoProductoItem->getIdPedido(); ?>/ListView"><?php echo $pedidoProductoItem->getIdPedido(); ?></a></td>
			<td><?php echo htmlentities($productoItem->getCodigo()); ?></td>
			<td><a href="/backend/productos/<?php echo $producto->getIdProducto(); ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
			<td><?php echo $pedidoProductoItem->getDiversidad(ESC_RAW) ?></td>
			<td><?php echo $producto->getMarca()->getNombre(); ?></td>
			<td><?php echo $productoItem->getProductoTalle()->getDenominacion(); ?></td>
			<td><?php echo $productoItem->getProductoColor()->getDenominacion(); ?></td>
			<td><?php echo $devolucionProductoItem->getCantidad(); ?></td>
			<td class="last">$<?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() ); ?></td>
		</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
	</table>
	
	<?php if ($devolucion->getTipoEnvio() == 'OCA'): ?>
	<h2>Direccion de retiro</h2>
	
	<ul>
		<li><strong>Dirección:</strong> <?php echo $devolucion->getCalle(); ?> <?php echo $devolucion->getNumero(); ?> <?php echo $devolucion->getPiso(); ?> <?php echo $devolucion->getDpto(); ?></li>
		<li><strong>Localidad:</strong> <?php echo $devolucion->getLocalidad(); ?></li>
		<li><strong>Provincia:</strong> <?php echo $devolucion->getProvincia()->getNombre(); ?></li>
		<li><strong>Código postal:</strong> <?php echo $devolucion->getCodigoPostal(); ?></li>
	</ul>
	<?php endif; ?>
	
	<?php $tracking = $devolucion->getTracking(); ?>
	
	<?php if ( $tracking && count($tracking) ): ?>
		
	<h2>Seguimiento del Envio</h2>
	
	<table>
		<tr>
			<th>Fecha</th>
			<th>Estado</th>
		</tr>
	
	    <?php $i = 0; ?>
	    <?php foreach ($tracking as $row): ?>
        <tr class="<?php echo ($i%2 == 0)? 'blanco' : 'gris' ?>">
           	<td class="first"><?php echo $row['fecha']; ?></td>
          	<td class="last"><?php echo $row['mensaje']; ?></td>
        </tr>   
        <?php $i++; ?>
	    <?php endforeach; ?>
	    
	<?php endif; ?>
	</table>
		
</div>