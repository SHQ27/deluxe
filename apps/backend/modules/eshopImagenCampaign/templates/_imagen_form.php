<div class="sf_admin_form_row">
    <?php $eshopImagenForm = $form->getObject(); ?>
	<?php echo $form["imagen"]->renderError(); ?>
	<label>Banner <small>(Ancho: <?php echo imageHelper::getInstance()->getWidth('eshop_imagen_campaign')?> px)</small></label>
	
	<?php echo $form["imagen"]; ?>
    <div class="banner_file">
    <?php if (!$eshopImagenForm->isNew()) : ?>
        <img src="<?php echo imageHelper::getInstance()->getUrl('eshop_imagen_campaign', $eshopImagenForm) ?>" width="1000px"/>
    <?php endif; ?>
    </div>
</div>
