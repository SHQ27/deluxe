<div id="sf_admin_container" class="generarNotaCredito">
    
    <h1>Generar Nota de Credito</h1>
    	
    <?php $error = sfContext::getInstance()->getUser()->getFlash('generarNotaCredito_error'); ?>
    <?php if ($error): ?>
    <ul class="error_list">
    	<li><?php echo $error ?></li>
    </ul>
    <?php endif; ?>
	
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	<div class="row">
	    	<?php echo $form['id_pedido']->renderLabel(); ?>
			<?php echo $form['id_pedido']; ?>
			<?php echo $form['id_pedido']->renderError(); ?>
		</div>
		
		<div class="row">	
	    	<?php echo $form['importe']->renderLabel(); ?>
			<?php echo $form['importe']; ?>
			<?php echo $form['importe']->renderError(); ?>
		</div>
		
        <input type="submit" value="Generar" />        
    </form>
    
</div>
