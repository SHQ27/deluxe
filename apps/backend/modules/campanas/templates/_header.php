<div class="sf_admin_form_row">
	<?php echo $form["header"]->renderError(); ?>
	<label>Header<small>(<?php echo imageHelper::getInstance()->getWidth('campana_header')?> x <?php echo imageHelper::getInstance()->getHeight('campana_header')?>)</small></label>
	<?php echo $form["header"]; ?>
</div>
