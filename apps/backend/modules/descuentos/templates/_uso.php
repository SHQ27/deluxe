<?php $descuento = $form->getObject(); ?>

<div class="sf_admin_form_row">
	<table>
		<tr>
			<th>Id Pedido</th>
			<th>Usuario</th>
			<th>Email</th>
			<th>Estado</th>
			<th>Monto del descuento </th>
			<th>Total del Pedido</th>
			<th>Info Adicional</th>
			<th></th>
		</tr>
		<?php $pedidos = pedidoTable::getInstance()->listByIdDescuento( $descuento->getIdDescuento() ); ?>
		<?php foreach ($pedidos as $pedido): ?>
		<tr>
			<td><?php echo $pedido->getIdPedido(); ?></td>
			<td><?php echo $pedido->getUsuario()->getNombreCompleto(); ?></td>
			<td><?php echo $pedido->getUsuario()->getEmail(); ?></td>
			<td>
				<?php if ($pedido->getFechaPago()): ?>
					<?php if ($pedido->getFechaEnvio()): ?>
						<span class="verde">Pagado</span>
						<br/>
						<span class="verde">Enviado</span>
					<?php else: ?>
						<span class="verde">Pagado</span>
						<br/>
						<span class="rojo">No enviado</span>
					<?php endif; ?>
					<br/>
					<?php if ($pedido->getFechaFacturacion()): ?>
						Facturado
					<?php else: ?>
						<span class="rojo">No Facturado</span>
					<?php endif; ?>
				<?php else: ?>
					<span class="rojo">No pagado</span>
				<?php endif; ?>
				<?php if ($pedido->getFechaBaja()): ?>
					<br/>
					<span class="rojo">Eliminado</span>
				<?php endif; ?>
			</td>
			<td>$ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ); ?></td>
			<td>$ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?></td>
			<td>
			    <?php $infoAdicional = $pedido->getPedidoDescuento()->getFirst()->getArrayInfoAdicional(); ?>
			    <?php foreach ( $infoAdicional as $key => $value ): ?>
			    <strong><?php echo ucfirst($key) ?></strong>: <?php echo $value; ?>
			    <br/>
			    <?php endforeach; ?>
			</td>
			<td><a class="coral" href="/backend/pedidos/<?php echo $pedido->getIdPedido(); ?>/ListView">Ver pedido</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	
	<?php $enCarrito = carritoDescuentoTable::getInstance()->quantityByIdDescuento( $descuento->getIdDescuento() ); ?>
	<?php if ( $enCarrito ): ?>
	<span class="coral"><strong>Este descuento también se encuentra en <?php echo $enCarrito; ?> <?php echo ($enCarrito == 1)? 'carrito' : 'carritos' ?></strong></span>
	<?php endif; ?> 
</div>
