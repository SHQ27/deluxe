<div id="sf_admin_container" class="ordenCompra">
    
    <h1>Enviar a Oca</h1>
    
    <table>
		<thead>
			<tr>
				<th>Imagen</th>
				<th>Producto</th>
				<th>Color</th>
				<th>Talle</th>
				<th>Cant.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $productos as $producto ): ?>
			<tr>
				<td>
					<a class="enlargeImage" href="<?php echo $producto['img_grande']; ?>"/>
						<img src="<?php echo $producto['img']; ?>"/>
					</a>
				</td>
				<td><?php echo $producto['nombre']; ?></td>>
				<td><?php echo $producto['color']; ?></td>
				<td><?php echo $producto['talle']; ?></td>
				<td><?php echo $producto['cantidad']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
    
</div>