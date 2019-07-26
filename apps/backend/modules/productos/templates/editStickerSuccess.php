<div id="sf_admin_container" class="editSetTalle">
	<h1>Modificación masiva Stickers</h1>
	
	<h2>Edición de stickers</h2>
	
	<form method="post">
		
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
					<input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosStickers[ids][]">
					<?php echo $producto->getDenominacion(); ?>
				</td>
				<td><?php echo $producto->getMarca()->getNombre(); ?></td>
				<td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
			</tr>
			<?php endforeach; ?>
		</table>
        
        <br />
        
        <label>Aplicar Sticker</label>    
        <?php echo $form['sticker'] ?>
        
        <br /><br />
                
		<input type="submit" value="Guardar"/>
		
	</form>
	
</div>