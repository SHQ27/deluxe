<div id="sf_admin_container" class="editPrices">
	<h1>Modificación masiva de precios de productos</h1>
	
	
	<h2>Aplicar un porcentaje</h2>
	<ul class="actualizar">
		<li>
			<label>Precio Lista</label>
			<br/>
			<input type="text" id="porc_precio_lista"/> %
			<a class="button_precio_lista" >Actualizar Tabla</a>
		</li>
		
		<li>	
			<label>Precio Normal</label>
			<br/>
			<input type="text" id="porc_precio_normal"/> %
			<a class="button_precio_normal" >Actualizar Tabla</a>
		</li>
		
		<li>	
			<label>Precio Outlet</label>
			<br/>
			<input type="text" id="porc_precio_outlet"/> %
			<a class="button_precio_outlet" >Actualizar Tabla</a>
		</li>
		
		<li>
			<label>Costo</label>
			<br/>
			<input type="text" id="porc_costo"/> %
			<a class="button_costo" >Actualizar Tabla</a>
		</li>
	</ul>

	<h2>Acciones Masivas</h2>
	<ul>
		<li>
			<a class="pasarPrecioListaANormal">Copiar el Precio de Lista en Precio Normal</a>
		</li>
		<li>
			<a class="redondear" rel="button_precio_lista">Redondear Precio de Lista</a>
		</li>
		<li>
			<a class="redondear" rel="button_precio_normal">Redondear Precio Normal</a>
		</li>
		<li>
			<a class="redondear" rel="button_precio_outlet">Redondear Precio de Outlet</a>
		</li>
	</ul>
	

	<h2>Edición de precios y costos</h2>
	
	<form method="post">
		
		<?php echo $form['_csrf_token'] ?>
		
		<table>
			<tr>
				<th>Código/s</th>
				<th>Nombre</th>
				<th>Marca</th>
				<th>Imagen</th>
				<th>Precio Lista</th>
				<th>Precio Normal</th>
				<th>Precio Outlet</th>
				<th>Costo</th>
			</tr>
			<?php foreach ($productos as $producto):?>
			<tr>
				<td>
					<input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosEditarPrecios[ids][]">
					<?php echo implode( '<br />', $producto->getCodigos()->getRawValue() ); ?>
				</td>
				<td>
					<input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosEditarPrecios[ids][]">
					<?php echo $producto->getDenominacion(); ?>
				</td>
				<td><?php echo $producto->getMarca()->getNombre(); ?></td>
				<td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
				<td><?php echo $form[ 'precio_lista_' . $producto->getIdProducto() ] ?></td>
				<td><?php echo $form[ 'precio_normal_' . $producto->getIdProducto() ]; ?></td>
				<td><?php echo $form[ 'precio_outlet_' . $producto->getIdProducto() ]; ?></td>
				<td><?php echo $form[ 'costo_' . $producto->getIdProducto() ]; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		
		<input type="submit" value="Guardar"/>
		
	</form>
	
	
	
	
	
</div>