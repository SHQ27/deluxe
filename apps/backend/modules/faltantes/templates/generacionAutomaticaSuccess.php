<div id="sf_admin_container" class="faltantes">
    
    <h1>Generacion automatica de los faltantes durante la recepción de Mercaderia</h1>

    <?php if ($tipo == 'CAMPANA'): ?>
    <h4>Campaña: <?php echo $campana->getDenominacion(); ?>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;Marca: <?php echo $marca->getNombre(); ?></h4>
	<?php endif; ?>
	    
	<div class="resultado">
		<table>
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Producto</th>
					<th>Talle</th>
					<th>Color</th>
					<th>Id Pedido</th>
					<th>Usuario</th>
					<th>Estado</th>
					<th>Cant.<br/>Faltante</th>
					<th>Cant. Tot.<br/>Productos</th>
					<th>$ Total<br/>Pedido</th>
				</tr>
			</thead>
			<tbody>
					<?php foreach ($data as $dataRow): ?>

						<?php $productoItem = $dataRow['productoItem']; ?>
						<?php $producto = $productoItem->getProducto(); ?>
						<?php $row = $dataRow['row']; ?>

						<?php foreach ($row as $dataRow2): ?>

							<?php $pedido = $dataRow2['pedido']; ?>
							<?php $cantidad = $dataRow2['cantidad']; ?>
						<tr>
							<td class="center">
								<a class="enlargeImage" href="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto)?>">
									<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>"/>
								</a>
							</td>
							<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
							<td><?php echo $productoItem->getProductoTalle()->getDenominacion(); ?></td>
							<td><?php echo $productoItem->getProductoColor()->getDenominacion(); ?></td>
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
							<td><?php echo $cantidad ?></td>
							<td><?php echo count($pedido->getPedidoProductoItem()); ?></td>				
							<td><?php echo $pedido->getMontoTotal(); ?></td>
						</tr>
					<?php endforeach;?>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>

	<ul class="sf_admin_actions">
		<li class="sf_admin_action_none"><a class="no-padding" href="<?php echo $linkConfirmacion; ?>"><input type="button" class="button" value="Confirmar"/></a></li>
		
		<?php if ($tipo == 'CAMPANA'): ?>
		<li class="sf_admin_action_none"><a href="<?php echo $linkProximoPaso; ?>">Saltear la generación de faltantes</a></li>
		<?php endif; ?>
	</ul>

    
</div>