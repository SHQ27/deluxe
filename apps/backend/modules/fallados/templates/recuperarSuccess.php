<div id="sf_admin_container" class="falladosRecuperar">
    
    <h1>Recuperar Fallados</h1>
    		
    		
    <?php if ( $recuperados !== false ): ?>
        
    <p>Se <?php echo ngettext('marco', 'marcaron ', $recuperados); ?> <?php echo $recuperados; ?> <?php echo ngettext('producto', 'productos', $recuperados); ?> como <?php echo ngettext('recuperado', 'recuperados', $recuperados); ?>.</p>
    <br />
    <a href="<?php echo url_for('fallados'); ?>">Volver al listado</a> 
    
    <?php else: ?>    	
    	
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	<div class="selectButtons">
        	<a class="select-all">Seleccionar Todos</a>
        	|
        	<a class="remove-all">Deseleccionar Todos</a>
    	</div>
    	
        <table>
			<thead>
				<tr>
			        <th>Fecha</th>
				    <th>Imagen</th>
                    <th>Codigo</th>
                    <th>Denominación</th>
                    <th>Talle</th>
                    <th>Color</th>
                    <th>Marca</th>
                    <th>Costo</th>
                    <th>Descripción de la Falla</th>
                    <th>Confirmar</th>
				</tr>
			</thead>
			<tbody>
			    <?php foreach( $fallados as $fallado ): ?>			    
				<tr>
                    <td><?php echo date('d/m/Y H:i', strtotime( $fallado['fecha'] )); ?></td>
				    <td><img src="<?php echo sfConfig::get('app_upload_url'); ?>/producto/detalle/chica/<?php echo $fallado['id_producto_imagen']; ?>.jpg"/></td>
                    <td><?php echo $fallado['codigo']; ?></td>
                    <td><?php echo $fallado['denominacion']; ?></td>
                    <td class="center"><?php echo $fallado['talle']; ?></td>
                    <td class="center"><?php echo $fallado['color']; ?></td>
                    <td><?php echo $fallado['marca']; ?></td>
                    <td><?php echo $fallado['costo']; ?></td>
                    <td><?php echo $fallado['descripcion_falla']; ?></td>
                    <td class="center"><?php echo $form['confirmado']->render( array('name' =>'falladosRecuperarForm[confirmado][]', 'value' => $fallado['id_fallado'])); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		
        <a href="<?php echo url_for('fallados'); ?>">Volver al listado</a>
        <input class="submit" type="submit" value="Recuperar" />        
    </form>
    
    <?php endif; ?>    
    
</div>