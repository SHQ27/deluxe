<div id="sf_admin_container" class="reportes">
    
    <h1>Libro IVA Venta</h1>
		
    <form method="post">
    	<?php echo $libroIvaVentaForm['_csrf_token']; ?>
    	<br/>
    	<?php echo $libroIvaVentaForm['periodo']->renderLabel(); ?>
		<?php echo $libroIvaVentaForm['periodo']; ?>
		<br/>
        <input type="submit" value="Descargar" class="button" />        
    </form>
    
</div>