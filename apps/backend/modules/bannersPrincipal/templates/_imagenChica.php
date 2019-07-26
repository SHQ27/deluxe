<div class="sf_admin_form_row">
	<?php echo $form["imagen_chica"]->renderError(); ?>
	<label>Banner Chico <small>(<?php echo imageHelper::getInstance()->getWidth('banner_principal_chico')?> x <?php echo imageHelper::getInstance()->getHeight('banner_principal_chico')?>)</small></label>
	<?php echo $form["imagen_chica"]; ?>
</div>

<div class="sf_admin_form_row">
	<?php echo $form["imagen_chica_hover"]->renderError(); ?>
	<label>Banner Chico Hover <small>(<?php echo imageHelper::getInstance()->getWidth('banner_principal_chico')?> x <?php echo imageHelper::getInstance()->getHeight('banner_principal_chico')?>)</small></label>
	<?php echo $form["imagen_chica_hover"]; ?>
</div>
