
<div id="sf_admin_container" class="importarProductos">

	<h1>Importación de productos - Preview</h1>
	
	<h2>Marca: <?php echo $marca->getNombre(); ?></h2>
		
	<div id="sf_admin_content">
		
		<?php if (!$csvFileExists || !$imagenesFileExists): ?>
			<br/>
			<strong>Antes de hacer el preview es necesario que se suban los archivos productos.csv e imagenes.zip</strong>
			<br/><br/>
			Hace <a href="/backend/productos/importar">click aquí</a> para volver a la pantalla anterior.
				
				
		<?php else: ?>
				
			<?php if (count($errores) == 0):?>
				
			<table>
						<tr>
							<td><strong>Imagen</strong></td>
							<td><strong>Denominación</strong></td>
							<td><strong>Descrip.</strong></td>
							<td><strong>Categoria</strong></td>
							<td><strong>Tags</strong></td>
							<td><strong>Precio Lista</strong></td>
							<td><strong>Precio Deluxe</strong></td>
							<td><strong>Costo</strong></td>
							<td><strong>Peso</strong></td>
							<td><strong>Set de Talles</strong></td>
							<td><strong>Código</strong></td>
							<td><strong>Talle</strong></td>
							<td><strong>Color</strong></td>
							<td><strong>Cant.</strong></td>
						</tr>
									
					<?php foreach ($productos as $index => $producto):?>
					
						<?php $rowSpan = count($producto['items']);?>
					
						<tr>
							<td rowspan="<?php echo $rowSpan; ?>"><img src="/backend/productos/importar/showImage/<?php echo $index; ?>"></td>
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['denominacion']; ?></td>
							<td rowspan="<?php echo $rowSpan; ?>" style="text-align: center;"><a class="addTooltip" title="<?php echo html_entity_decode( $producto['descripcion'] ); ?>">Leer</a></td>
							
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['categoria']->getDenominacion(); ?></td>
							
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['tags']; ?></td>
							
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['precioLista']; ?></td>
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['precioDeluxe']; ?></td>
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['costo']; ?></td>
							<td rowspan="<?php echo $rowSpan; ?>"><?php echo $producto['peso']; ?></td>
							<td rowspan="<?php echo $rowSpan; ?>">
							<?php if ( $producto['talleSet']): ?>
							    <?php echo $producto['talleSet']->getDenominacion(); ?>
                            <?php else:?>
                                Sin Asignar	
							<?php endif;?>	
							</td>
					
						<?php $i = 0?>
						<?php foreach ($producto['items'] as $item):?>
						
						<?php if ($i != 0 ):?>
						<tr>
						<?php endif;?>	
							<td><?php echo $item['codigo']; ?></td>
							<td><?php echo $item['talle']->getDenominacion(); ?></td>
							<td><?php echo $item['color']->getDenominacion(); ?></td>
							<td><?php echo $item['cantidad']; ?></td>
							<?php $i++; ?>
						</tr>
						
						<?php endforeach;?>
						
					<?php endforeach;?>
					
				</table>
						
				<p class="sf_admin_actions">
		  			<a href="<?php echo url_for('producto_importar_procesar', array('origen' => $origen, 'idMarca' => $marca->getIdMarca(), 'idEshop' => $idEshop)); ?>"><input type="button" value="Procesar"/></a>
		  			<a href="/backend/productos/importar">Cancelar</a>  			
		  		</p>
					
			<?php else: ?>
				<br/>
				
				<h3>Se han producido los siguientes errores:</h3>
				
				<br/>
			
				<ul>
							
				<?php for ( $i = 0; $i < count($errores) ; $i++):?>
					<li><?php echo $errores->getRaw($i); ?></li>
				<?php endfor;?>
				</ul>
				
				<br/>
				
				Hace <a href="/backend/productos/importar">click aquí</a> para volver a la pantalla anterior.
					
			<?php endif; ?>
			
		<?php endif; ?>
				
	</div>
	
</div>

