<div id="sf_admin_container" class="reportes">
    
    <h1>Reporte de Marketing</h1>
		
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	<br/>
    	<?php echo $form['id_eshop']->renderLabel(); ?>
		<?php echo $form['id_eshop']; ?>
    	<br/><br/>
    	<?php echo $form['mes']->renderLabel(); ?>
		<?php echo $form['mes']; ?>
		<br/>
        <input type="submit" value="Descargar" class="button" />        
    </form>
</div>