<div class="sf_admin_form_row">
    <?php $eshop = $form->getObject(); ?>
	<?php echo $form["banner_medios_pago_carrito"]->renderError(); ?>
	<label>Banner en Carrito
	<br />
	<small>(Ancho <?php echo imageHelper::getInstance()->getWidth('eshop_medios_pagos_carrito')?>px)</small></label>
	<?php echo $form["banner_medios_pago_carrito"]; ?>
</div>
