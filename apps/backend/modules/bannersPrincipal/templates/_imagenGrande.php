<div class="sf_admin_form_row">
	<?php echo $form["imagen_grande"]->renderError(); ?>
	<label>Banner Grande <small>(<?php echo imageHelper::getInstance()->getWidth('banner_principal_grande')?> x <?php echo imageHelper::getInstance()->getHeight('banner_principal_grande')?>)</small></label>
	<?php echo $form["imagen_grande"]; ?>
</div>
