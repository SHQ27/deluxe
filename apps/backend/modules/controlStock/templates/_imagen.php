<?php if ( is_file( imageHelper::getInstance()->getPath('producto_detalle_chica', $producto_item->getProducto() ) ) ):?>
<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto_item->getProducto() ); ?>"/>
<?php endif; ?>