<div class="sf_admin_form_row">
    <?php $banner = $form->getObject(); ?>
	<?php echo $form["imagen"]->renderError(); ?>
	<label>Imagen<small>(<?php echo imageHelper::getInstance()->getWidth('banner_imagen')?> x <?php echo imageHelper::getInstance()->getHeight('banner_imagen')?>)</small></label>
	<?php echo $form["imagen"]; ?>
    <div class="banner_file">
    <?php if (!$banner->isNew()) : ?>
        <img src="<?php echo imageHelper::getInstance()->getUrl('banner_imagen', $banner) ?>"/>
    <?php endif; ?>
    </div>
</div>
