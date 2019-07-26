<div id="sf_admin_container" class="asignacionCSV">
    
    <h1>Edicion de Precios y Stocks via CSV</h1>
		
    <form enctype="multipart/form-data" method="post">
    
    	<?php echo $form['_csrf_token']; ?>
    	
    	<p>
    	   <br/>
    	   <br/>
    	   <?php echo $form['csv']->renderLabel(); ?>
    	   <?php echo $form['csv']; ?>
    	   <?php echo $form['csv']->renderError(); ?>
		</p>
		
        <input type="submit" value="Procesar" class="button" />        
    </form>
    
</div>