<div class="sf_admin_form_row">
	<?php echo $form["banner_principal"]->renderError(); ?>
	<label>Banner Principal <small>(<?php echo imageHelper::getInstance()->getWidth('campana_banner_principal')?> x <?php echo imageHelper::getInstance()->getHeight('campana_banner_principal')?>)</small></label>
	<?php echo $form["banner_principal"]; ?>
</div>
