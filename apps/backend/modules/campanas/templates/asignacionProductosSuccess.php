<div id="sf_admin_container" class="asignacionProductos">
	<h1>Asignar productos a la campaña "<?php echo ucfirst( $campana->getDenominacion() ); ?>"</h1>

	<p>
		<br />
		<strong>ALERTA: Al momento de asignar un producto a la campaña, verificar que el mismo no se encuentre simultaneamente en otra campaña</strong>
		<br />
	</p>

	<script>
		var idCampana = <?php echo $campana->getIdCampana(); ?>;
		var denominacionCampana = '<?php echo $campana->getDenominacion(); ?>';
	</script>

	<h4>Filtros</h4>

	<div class="filter">
		<label>Marca</label>
		<select id="marca">
			<option value=""></option>
			<?php foreach($marcas as $marca): ?>
			<option value="<?php echo $marca->getIdMarca(); ?>"><?php echo $marca->getNombre(); ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<input class="button filtrar" type="button" value="Filtrar">
	<a class="restablecer">Restablecer</a>

	<h4>Resultados</h4>

	<div class="results">
		<table>
			<thead>
				<tr>
					<td><input type="checkbox" class="all"></td>
					<td><strong>Título del producto</strong></td>
					<td><strong>Marca</strong></td>
					<td><strong>Categoría</strong></td>
					<td><strong>Diversidad</strong></td>
					<td><strong>Activo</strong></td>
					<td><strong>Stk. en<br>Perm</strong></td>
					<td><strong>Stk. de<br>Campañas</strong></td>
					<td><strong>Stk. en<br>Outlet</strong></td>
					<td><strong>Imagen</strong></td>
					<td><strong>Precio de Lista</strong></td>
					<td><strong>Precio Deluxebuys</strong></td>
					<td><strong>Costo</strong></td>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td style="text-align: center;" colspan="15">Debe aplicar filtros para mostrar los productos</td>
			</tr>
			</tbody>
		</table>
	</div>

	<input class="button asignar" type="button" value="Asignar Seleccionados">

	<h4>Asignados</h4>
	
	<div class="selectedItems">
		<table>
			<thead>
			<tr>
				<td><input type="checkbox" class="all"></td>
				<td><strong>Título del producto</strong></td>
				<td><strong>Marca</strong></td>
				<td><strong>Categoría</strong></td>
				<td><strong>Diversidad</strong></td>
				<td><strong>Activo</strong></td>

				<td><strong>Stk. en<br />Perm</strong></td>
				<td><strong>Stk. de<br />Campañas</strong></td>
				<td><strong>Stk. en<br />Outlet</strong></td>

				<td><strong>Imagen</strong></td>
				<td><strong>Precio de Lista</strong></td>
				<td><strong>Precio Deluxebuys</strong></td>
				<td><strong>Costo</strong></td>
			</tr>
			</thead>

			<tbody>
			<?php if ( count($productosAsignados) ): ?>
			<?php foreach($productosAsignados as $producto): ?>
  			<?php $productoCategoria = $producto->getProductoCategoria(); ?>
  			<?php $productoGenero 	 = $producto->getProductoCategoria()->getProductoGenero(); ?>
  			<?php $precioLista = ( $producto->getPrecioLista() )? $producto->getPrecioLista() : 0; ?>
  			<?php $precioDeluxe= ( $producto->getPrecioDeluxe() )? $producto->getPrecioDeluxe() : 0; ?>
  			<?php $costo = ( $producto->getCosto() )? $producto->getCosto() : 0; ?>
			
		  	<tr>
		  		<td><input type="checkbox" value="<?php echo $producto->getIdProducto(); ?>"></td>
		  		<td><?php echo $producto->getDenominacion(); ?></td>		  		  	
	  			<td class="marca "rel="<?php echo $producto->getMarca()->getIdMarca(); ?>"><?php echo $producto->getMarca()->getNombre(); ?></td>
		  		<td><?php echo $productoGenero->getDenominacion(); ?> - <?php echo $productoCategoria->getDenominacion(); ?></td>
				<td <?php echo ( $producto->getDiversidad() != $campana->getDenominacion() ) ? 'class="warning"' : ''; ?>><?php echo $producto->getDiversidad(); ?></td>
				<td><?php echo ( ( $producto->getActivo() )? '<img src="/backend/sfDoctrinePlugin/images/tick.png" title="Checked" alt="Checked">' : ''); ?></td>
		  		<td><?php echo $producto->getStockPermanente(); ?></td>
		  		<td><?php echo $producto->getStockCampana(); ?></td>
		  		<td><?php echo $producto->getStockOutlet(); ?></td>
		  		<td>
				  	<?php if ( $producto->getIdProductoSticker() ): ?>
		  			<div class="relative"><img class="sticker" src="<?php echo imageHelper::getInstance()->getUrl('producto_sticker_chico', $producto->getProductoSticker() ); ?>" /></div>
		  			<?php endif; ?>
		  			<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto); ?>"/></td>
		  		</td>
		  		<td><?php echo $producto->getPrecioLista(); ?></td>
		  		<td class="precioDeluxe"><?php echo $precioDeluxe; ?></td>
		  		<td><?php echo $costo; ?></td>
		  	</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr rel="0"><td colspan="14">No hay productos asignados</td></tr>
			<?php endif; ?>  			
			</tbody>
		</table>
	</div>

	<br />

	<div class="desactivarProductos">
		  <label for="desactivarProductos">Desactivar productos desasignados</label>
		  <input type="checkbox" id="desactivarProductos" class="inputDesactivarProductos">
  	</div>

  	<br />

	<input class="button desasignar" type="button" value="Desasignar Seleccionados">

	<div class="loader">
		<img src="/backend/images/ajax-loader.gif" />
		<br/><br/>
		Procesando...
	</div>

</div>