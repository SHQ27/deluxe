<div id="sf_admin_container" class="recepcionMercaderia">
    
    <h1>Recepción de Mercaderia de la Marca "<?php echo $marca->getNombre(); ?>" en la Campaña "<?php echo $campana->getDenominacion(); ?>"</h1>

    <?php $recepcion = $sf_data->getRaw('recepcion'); ?>

    <form enctype="multipart/form-data" method="post">
    
    	<?php echo $form['_csrf_token']; ?>

		<?php if ( $usaStockRefuerzo ): ?>
	    <h3 class="rojo">
	        SE ESTA UTILIZANDO STOCK DE REFUERZO PARA ESTA CAMPAÑA Y MARCA EN PARTICULAR.
	    </h3>
	    <?php endif; ?>

	    <p>
	        <br />
	        <strong>ALERTA:</strong>
	        Al momento de recepcionar mercaderia la suma de las cantidades entregadas, recibidas y faltantes no deben superar a la cantidad requerida.
	        De no suceder esto el sistema lo informara en rojo sobre las celdas involucradas.
	    	<br /><br /><br />
			<a class="resetear">Resetear cantidades a cero</a>	
	    </p>
    	
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
					<th>Cantidad<br/>Entregada</th>
					<th>Faltantes<br/>informados</th>
					<th>Cantidad<br/>Recibida</th>
					<th>Cantidad<br/>Faltante</th>
					<th>Observaciones</th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ( $productos as $producto ): ?>

				<?php $faltante = isset( $faltantes[ $producto['id_producto_item'] ] ) ? $faltantes[ $producto['id_producto_item'] ] : 0; ?>

				<tr rel ="<?php echo $producto['id_producto_item']; ?>">
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
					<td class="center"><?php echo $producto['cantidad']; ?></td>
					<td class="center"><?php echo $recepcion[ $producto['id_producto_item'] ]['cantidad']; ?></td>
					<td class="center"><?php echo $faltante; ?></td>

					<?php $cantidadARecibir = $producto['cantidad'] - ( $recepcion[ $producto['id_producto_item'] ]['cantidad'] + $faltante ); ?>

					<?php if ( $cantidadARecibir > 0 ): ?>
					<td class="center">
						<?php echo $form['cantidad_recibida_' . $producto['id_producto_item']]; ?>
					</td>
					<?php else: ?>
					<td class="center"><span class="verde">No queda<br/>mercaderia por<br/>recepcionar</span></td>
					<?php endif; ?>
					<?php if ( $cantidadARecibir > 0 ): ?>
					<td class="center">
						<?php echo $form['cantidad_faltante_' . $producto['id_producto_item']]; ?>
					</td>
					<?php else: ?>
					<td class="center"><span class="verde">No queda<br/>mercaderia por<br/>recepcionar</span></td>
					<?php endif; ?>
					<td>
						<p>
							<?php echo nl2br( $recepcion[ $producto['id_producto_item'] ]['observaciones'] ); ?>
						</p>
						<?php if ( $cantidadARecibir > 0 ): ?>
						<?php echo $form['observacion_' . $producto['id_producto_item']]->render( array( 'placeholder' => 'Agregar una observación' ) ); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

        <input type="submit" value="Procesar" class="button" />

    </form>
    
</div>