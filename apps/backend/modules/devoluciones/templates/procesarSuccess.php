<div id="sf_admin_container" class="procesarDevolucion">
    
    <h1>Devolución #<?php echo $devolucion->getIdDevolucion(); ?></h1>
    
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	<h2>Detalles de la devolucion</h2>
    	
    	<p>
    	   <label>Motivo</label>
    	   <?php echo $form['id_devolucion_motivo']; ?>
    	</p>
    	
    	<?php echo $form['devolucion']; ?>
    	
    	<p class="aclaraciones">
    	    <strong>Stk. Reseteado:</strong> Se refiere al stock del producto en su totalidad con todas sus variantes.
    	<p>
    	
    	<?php if ( $devolucion->getTipoCredito() == devolucion::credito_mp ): ?>
    	
    	<h2>Mensaje</h2>
    	
    	<div class="row mensaje">
    			<label class="bold">Seleccioná una opción</label>
				<?php echo $form['opcion']; ?>
		</div>
    	
    	<div class="row mensaje">
    			<label class="bold">Mensaje</label>
	    		<p>
					<strong>Hola <?php echo $usuario->getNombre() ?></strong>, ¿cómo estás?
				</p>
                <p>
                    Te confirmo que procedimos a reintegrar el dinero.
                </p>
				<p>
					<?php echo $form['mensaje']; ?>
				</p>
				<p>
					Ante cualquier consulta estamos a tu disposición.
				</p>
				<br/>
		</div>
		<?php endif; ?>
		
        <input type="submit" value="Procesar" />        
    </form>
    
</div>