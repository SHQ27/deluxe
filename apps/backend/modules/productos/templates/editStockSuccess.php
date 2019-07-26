<div id="sf_admin_container" class="editStock">
	<h1>Modificación masiva de stock de productos</h1>
	
	<p>
		<br />
		Stock Permanente:&nbsp;&nbsp;&nbsp;<a class="vaciarPermanente">Vaciar Columna</a> | <a class="restaurarPermanente">Restaurar Columna</a>
		<br /><br />
		Stock en Campaña:&nbsp;&nbsp;<a class="vaciarCampana">Vaciar Columna</a> | <a class="restaurarCampana">Restaurar Columna</a>
		<br /><br />
		Stock de Refuerzo:&nbsp;&nbsp;&nbsp;<a class="vaciarRefuerzo">Vaciar Columna</a> | <a class="restaurarRefuerzo">Restaurar Columna</a>
	</p>


	<form method="post">
		
		<?php echo $form['_csrf_token'] ?>
		
		<?php foreach ($productos as $producto):?>
		<div class="producto">
			<h2><?php echo $producto->getDenominacion(); ?> <a href="/backend/productos/<?php echo $producto->getIdProducto(); ?>/edit">Link al producto</a></h2>

			<p><strong>Es Outlet:</strong> <?php echo ( $producto->getEsOutlet() ) ? 'Si' : 'No'; ?></p>
			
			<div class="sf_admin_form_field_stock">
				<?php echo $form['stock_' . $producto->getIdProducto() ]; ?>
				<?php echo $form['stock_' . $producto->getIdProducto() ]->renderError(); ?>
			</div>
		</div>
		<?php endforeach; ?>
	
		
		<input type="submit" value="Guardar"/>
		
	</form>
	
</div>