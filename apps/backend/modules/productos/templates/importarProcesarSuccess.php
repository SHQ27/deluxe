
<div id="sf_admin_container" class="importarProductos">

	<h1>Importación de productos - Resultado</h1>
		
	<div id="sf_admin_content">
		
		<br/><br/>
				
	    <?php $error = sfContext::getInstance()->getUser()->getFlash('result_executeImportarProcesar_' . $proceso); ?>
				
		<?php if ($error): ?>
		<strong>No se pudo realizar el proceso. Finalizo con el siguiente error:</strong>
		<?php echo $error; ?>
		<?php else: ?>
		<strong>El proceso finalizo correctamente</strong>
		<?php endif; ?>
			
		<br/><br/>
		Hace <a href="/backend/productos/importar">click aquí</a> para volver al primer paso.
		
	</div>
	
</div>

