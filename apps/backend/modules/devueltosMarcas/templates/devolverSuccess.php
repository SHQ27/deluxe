<div id="sf_admin_container" class="devueltosMarcasDevolver">
    
    <h1>Devolver a la Marca</h1>
    		
    		
    <?php if ( $devueltos !== false ): ?>
        
    <p>Se <?php echo ngettext('marco', 'marcaron ', $devueltos); ?> <?php echo $devueltos; ?> <?php echo ngettext('producto', 'productos', $devueltos); ?> como <?php echo ngettext('devuelto', 'devueltos', $devueltos); ?>.</p>
    <br />
    <a href="<?php echo url_for('devueltosMarcas'); ?>">Volver al listado</a> 
    
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
                    <th>Confirmar</th>
				</tr>
			</thead>
			<tbody>
			    <?php foreach( $devueltosMarcas as $devueltoMarca ): ?>			    
				<tr>
                    <td><?php echo date('d/m/Y H:i', strtotime( $devueltoMarca['fecha'] )); ?></td>
				    <td><img src="<?php echo sfConfig::get('app_upload_url'); ?>/producto/detalle/chica/<?php echo $devueltoMarca['id_producto_imagen']; ?>.jpg"/></td>
                    <td><?php echo $devueltoMarca['codigo']; ?></td>
                    <td><?php echo $devueltoMarca['denominacion']; ?></td>
                    <td class="center"><?php echo $devueltoMarca['talle']; ?></td>
                    <td class="center"><?php echo $devueltoMarca['color']; ?></td>
                    <td><?php echo $devueltoMarca['marca']; ?></td>
                    <td><?php echo $devueltoMarca['costo']; ?></td>
                    <td class="center"><?php echo $form['confirmado']->render( array('name' =>'devueltosMarcasDevolverForm[confirmado][]', 'value' => $devueltoMarca['id_devuelto_marca'])); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		
        <a href="<?php echo url_for('devueltosMarcas'); ?>">Volver al listado</a>
        <input class="submit" type="submit" value="Devolver" />        
    </form>
    
    <?php endif; ?>    
    
</div>