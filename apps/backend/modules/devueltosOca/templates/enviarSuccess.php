<div id="sf_admin_container" class="devueltosOca">
    
    <h1>Devueltos por OCA</h1>
    
   <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	
    	<div class="row">
	    	<p class="label">Ingrese los codigos de envio de cada pedido separados por coma.</p>
			<?php echo $form['guias_envio']; ?>
		</div>
		
        <input class="button" type="submit" value="Buscar" />        
    </form>
        
</div>