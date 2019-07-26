<div class="sf_admin_form_row">
    <?php $eshop = $form->getObject(); ?>
	<?php echo $form["banner_medios_pago_producto"]->renderError(); ?>
	<label>Banner en Detalle de Producto <small>
	<br />
	(Ancho <?php echo imageHelper::getInstance()->getWidth('eshop_medios_pagos_producto')?>px)</small></label>
	<?php echo $form["banner_medios_pago_producto"]; ?>
</div>
