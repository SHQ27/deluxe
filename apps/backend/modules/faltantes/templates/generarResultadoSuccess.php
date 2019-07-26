<?php if ( isset($pedidos) && count($pedidos) ): ?>
<table>
	<thead>
		<tr>
			<th>Id Pedido</th>
			<th>Usuario</th>
			<th>Estado</th>
			<th>Es Outlet?</th>
			<th># de este item de producto</th>
			<th># Productos</th>
			<th>$ Total</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($pedidos as $pedido): ?>
		<tr>
			<td>
				<a target="_blank" href="/backend/pedidos/<?php echo $pedido->getIdPedido(); ?>/ListView"><?php echo $pedido->getIdPedido(); ?></a>
			</td>
			<td>
				<?php echo $pedido->getUsuario()->getNombre() ?>
				<br/>
				<?php echo $pedido->getUsuario()->getApellido() ?>
				<br/>
				<?php echo $pedido->getUsuario()->getEmail() ?>
			</td>
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
			</td>
			<td><?php echo ( $esOutlet[ $pedido->getIdPedido() ] ) ? 'Si' : 'No'; ?></td>
			<td><?php echo $pedido->getCantidadProductoItem($idProductoItem); ?></td>
			<td><?php echo count($pedido->getPedidoProductoItem()); ?></td>				
			<td><?php echo $pedido->getMontoTotal(); ?></td>
			<td><a href="<?php echo url_for('faltantes_envio', array('idPedido' => $pedido->getIdPedido(),'idProductoItem' => $idProductoItem) ); ?>">Enviar Aviso</a></td>				
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>