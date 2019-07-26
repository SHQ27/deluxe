<div id="sf_admin_container" class="recepcionMercaderia">
    
    <h1>Recepción de Mercaderia para eShops</h1>

    <form enctype="multipart/form-data" method="post">
    
    	<?php echo $form['_csrf_token']; ?>
    	
		<table class="tabla">
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Producto</th>
					<th>Cod prod</th>
					<th>Color</th>
					<th>Talle</th>
    				<th>Costo</th>
    				<th>Costo<br/>(Sin IVA)</th>
					<th>Cantidad<br/>Requerida</th>
					<th>Faltantes<br/>informados</th>
					<th>Cantidad<br/>Recibida</th>
					<th>Faltantes<br/>por Informar</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ( $productos as $producto ): ?>

				<tr>
					<td class="center">
						<a class="enlargeImage" href="<?php echo $producto['img_grande']; ?>"/>
							<img src="<?php echo $producto['img']; ?>"/>
						</a>
					</td>
					<td><?php echo $producto['nombre']; ?></td>
					<td><?php echo $producto['codigo']; ?></td>
					<td class="center"><?php echo $producto['color']; ?></td>
					<td class="center"><?php echo $producto['talle']; ?></td>
					<td>$<?php echo $producto['costo']; ?></td>
					<td>$<?php echo $producto['costoSinIva']; ?></td>
					<td class="center cantidadRequerida"><?php echo $producto['cantidad']; ?></td>
					<td class="center faltantesInformado"><?php echo $producto['faltantesInformado']; ?></td>

					<?php if ( $producto['cantidadARecibir'] > 0 ): ?>
					<td class="center">
						<?php echo $form['cantidad_recibida_' . $producto['id_producto_item']]; ?>
					</td>
					<?php else: ?>
					<td class="center"><span class="verde">No queda<br/>mercaderia por<br/>recepcionar</span></td>
					<?php endif; ?>
					<td class="center nuevosFaltante">0</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

        <input type="submit" value="Procesar" class="button" />

    </form>
    
</div>