<div class="sf_admin_form_row compra_minima">
    <div>
        <?php echo $form["compra_minima"]->renderLabel(); ?>
    	<div class="content">
    	    <?php echo $form["compra_minima"]; ?>&nbsp;&nbsp;<span>Unidades.</span>&nbsp;&nbsp;&nbsp;&nbsp;<span><small>Ej. Si compra mínima = 2, el descuento aplica sobre la 3er unidad.</small></span>
    	</div>
    	<?php echo $form["compra_minima"]->renderError(); ?>
	</div>
</div>