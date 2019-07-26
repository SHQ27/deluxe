<div id="sf_admin_container" class="reportes">
    
    <h1>Ventas por periodo</h1>
	
    <?php $error = sfContext::getInstance()->getUser()->getFlash('ventasPorPeriodo_error'); ?>
    <?php if ($error): ?>
    <ul class="error_list">
    	<li><?php echo $error ?></li>
    </ul>
    <?php endif; ?>
	
    <form method="post">
    	<?php echo $reporteVentasPorPeriodoForm['_csrf_token']; ?>
    	<?php echo $reporteVentasPorPeriodoForm['periodo']->renderLabel(); ?>
		<?php echo $reporteVentasPorPeriodoForm['periodo']; ?>
        <input type="submit" value="Descargar" class="button" />        
    </form>
</div>