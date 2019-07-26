<div id="sf_admin_container" class="reportes">
    
    <h1>Citi Ventas</h1>
		
    <form method="post">
    	<?php echo $citiVentasForm['_csrf_token']; ?>
    	<br/>
    	<?php echo $citiVentasForm['periodo']->renderLabel(); ?>
		<?php echo $citiVentasForm['periodo']; ?>
		<br/>
        <input type="submit" value="Descargar" class="button" />        
    </form>
    
</div>