<?php $promoPago = $form->getObject(); ?>

<div class="sf_admin_form_row">
	<?php echo $form["imagen"]->renderError(); ?>
	<label>Imagen<small> (<?php echo imageHelper::getInstance()->getWidth('promo_pago_imagen')?> x <?php echo imageHelper::getInstance()->getHeight('promo_pago_imagen')?>)</small></label>
	<?php echo $form["imagen"]; ?>
    <div class="promoPago_file">
    <?php if (!$promoPago->isNew()) : ?>
        <img src="<?php echo imageHelper::getInstance()->getUrl('promo_pago_imagen', $promoPago) ?>"/>
    <?php endif; ?>
    </div>
</div>


<div class="sf_admin_form_row">
	<?php echo $form["imagen_mobile"]->renderError(); ?>
	<label>Imagen para Mobile<small> (<?php echo imageHelper::getInstance()->getWidth('promo_pago_imagen_mobile')?> x <?php echo imageHelper::getInstance()->getHeight('promo_pago_imagen_mobile')?>)</small></label>
	<?php echo $form["imagen_mobile"]; ?>
    <div class="promoPago_file">
    <?php if (!$promoPago->isNew()) : ?>
        <img src="<?php echo imageHelper::getInstance()->getUrl('promo_pago_imagen_mobile', $promoPago) ?>"/>
    <?php endif; ?>
    </div>
</div>
