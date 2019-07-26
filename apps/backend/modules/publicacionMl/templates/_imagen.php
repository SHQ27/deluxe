<?php $producto = $publicacion_ml->getProducto(); ?>
<?php if ( is_file( imageHelper::getInstance()->getPath('producto_detalle_chica', $producto) ) ):?>
<a class="enlargeImage" href="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $producto)?>">
	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto)?>"/>
</a>
<?php endif; ?>