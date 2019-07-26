<div id="sf_admin_container" class="editSetTalle">
	<h1>Modificación masiva de Set de Talles</h1>
	<form method="post">

		<?php foreach ($productosPorMarca as $marca => $productos): ?>
		<h2>Edición de talles para productos de la Marca <?php echo $marca ?></h2>
				
			<?php echo $form['_csrf_token'] ?>		
			<table>
				<tr>
					<th>Nombre</th>
					<th>Marca</th>
					<th>Imagen</th>
				</tr>
				<?php foreach ($productos as $producto):?>
				<tr>
					<td>
						<input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosSetTalles[ids][]">
						<?php echo $producto->getDenominacion(); ?>
					</td>
					<td><?php echo $producto->getMarca()->getNombre(); ?></td>
					<td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
				</tr>
				<?php endforeach; ?>
			</table>
			Aplicar set de Talle: <?php echo $form[ 'set_talle_' . $productos[0]->getIdMarca() ] ?>
		<?php endforeach; ?>

		<input class="button" type="submit" value="Guardar"/>

	</form>
	
</div>