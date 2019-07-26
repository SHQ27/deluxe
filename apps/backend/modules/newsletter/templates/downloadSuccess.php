<div id="sf_admin_container">

	<h1>Newsletter (Descargar)</h1>
			
	<br />
			
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	<div>
        	<?php echo $form['password']->renderLabel(); ?>
    		<?php echo $form['password']; ?>
		</div>
		
		<br />
		
        <input type="submit" value="Descargar" class="button" />        
    </form>
		    
</div>