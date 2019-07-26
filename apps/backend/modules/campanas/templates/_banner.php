<div class="sf_admin_form_row">
	<?php echo $form["banner"]->renderError(); ?>
	<label>Banner <small>(<?php echo imageHelper::getInstance()->getWidth('campana_banner')?> x <?php echo imageHelper::getInstance()->getHeight('campana_banner')?>)</small></label>
	<?php echo $form["banner"]; ?>
</div>


<div class="sf_admin_form_row">
	<?php echo $form["banner_hover"]->renderError(); ?>
	<label>Banner Hover<small>(<?php echo imageHelper::getInstance()->getWidth('campana_banner')?> x <?php echo imageHelper::getInstance()->getHeight('campana_banner')?>)</small></label>
	<?php echo $form["banner_hover"]; ?>
</div>
