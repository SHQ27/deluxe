<?php if ( isset($form) ) $producto = $form->getObject(); ?>

<?php $productoImagenes = productoImagenTable::getInstance()->listByIdProducto( $producto->getIdProducto() ) ?>

<div class="administrar_imagenes">
<?php foreach ($productoImagenes as $productoImagen):?>
	<div class="imagen">
		<?php if( $productoImagen->canOrderUp() ):?>
		<a onclick="formProducto.doImagen('subir', <?php echo $producto->getIdProducto()?>, <?php echo $productoImagen->getIdProductoImagen()?>);" class="prev"></a>
		<?php else: ?>
		<span class="spacer"></span>
		<?php endif; ?>
		<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $productoImagen) ?>" width="103px" height="155px"/>
		<?php if( $productoImagen->canOrderDown() ):?>
		<a onclick="formProducto.doImagen('bajar', <?php echo $producto->getIdProducto()?>, <?php echo $productoImagen->getIdProductoImagen()?>);" class="next"></a>
		<?php else: ?>
		<span class="spacer"></span>
		<?php endif; ?>
		<br/>
		<a onclick="formProducto.doImagen('eliminar', <?php echo $producto->getIdProducto()?>, <?php echo $productoImagen->getIdProductoImagen()?>);" class="delete">Eliminar</a>		
	</div>
<?php endforeach;?>
</div>