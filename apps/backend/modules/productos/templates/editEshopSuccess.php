<div id="sf_admin_container" class="editSetTalle">
	<h1>Modificación masiva de eShop</h1>
	
	<h2>Edición de eShop</h2>
	
	<form method="post">
		
		<?php echo $form['_csrf_token'] ?>
		
		<table>
			<tr>
				<th>Nombre</th>
				<th>Marca</th>
				<th>Imagen</th>
				<th class="alerta">&nbsp;</th>
			</tr>
			<?php foreach ($productos as $producto):?>
			<tr>
				<td>
					<input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosEditarEshop[ids][]">
					<?php echo $producto->getDenominacion(); ?>
				</td>
				<td><?php echo $producto->getMarca()->getNombre(); ?></td>
				<td><img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px"></td>
				<td class="alerta">
				    <?php $publicacionML = $producto->getPublicacionMl(); ?>
				    <?php if ( $publicacionML && $publicacionML->estaVigente() ): ?>
				    Este producto se encuentra publicado en ML.
				    <br />
				    Antes de proseguir elimine la publicacion.
				    <?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
        
        <br />
        
        <label>Aplicar eshop</label>    
        <?php echo $form['eshop'] ?>
        
        <br /><br />
                
		<input type="submit" value="Guardar"/>
	</form>
	
</div>