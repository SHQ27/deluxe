<a class="enlargeImage" href="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto)?>">
    <?php if ( $producto->getProductoSticker() && $producto->getProductoSticker()->exists() ): ?>
    <img class="sticker" src="<?php echo imageHelper::getInstance()->getUrl('producto_sticker_chico', $producto->getProductoSticker() ); ?>" />
	<?php endif; ?>
	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>"/>
</a>