<div class="sf_admin_form_row">
	<?php foreach ( $cupon->getCuponProducto() as $cuponProducto ): ?>
	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $cuponProducto->getProducto() );?>" width="100px" title="<?php echo $cuponProducto->getProducto()->getDenominacion(); ?>" alt="<?php echo $cuponProducto->getProducto()->getDenominacion(); ?>" />	
	<?php endforeach; ?>
</div>