<div class="sf_admin_form_row">
    <?php $eshop = $form->getObject(); ?>
	<?php echo $form["banner_listado"]->renderError(); ?>
	<label>Banner <small>(<?php echo imageHelper::getInstance()->getWidth('eshop_banner_listado')?> x <?php echo imageHelper::getInstance()->getHeight('eshop_banner_listado')?>)</small></label>
	<?php echo $form["banner_listado"]; ?>
</div>
