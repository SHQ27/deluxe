<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<p>
    El resultado de la publicacion en Mercado Libre fué:
</p>

<table>
    <thead>
	<tr>
		<th>Id Producto</th>
		<th>Imagen</th>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Marca</th>
		<th>Talle</th>
		<th>Color</th>
		<th>Stock</th>
		<th>Resultado</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($productos as $producto):?>
	<?php $productoItems = $producto->getProductoItem(); ?>
	<?php $categoriaML = $producto->getCategoriaMl(); ?>
	<?php foreach ($productoItems as $productoItem):?>
	
	<?php if ( $productoItem->getCurrentStock() <= 0 ): ?>
	<?php continue; ?>
	<?php endif;?>
	
	<tr>
		<td>
		    <input type="hidden" value="<?php echo $producto->getIdProducto(); ?>" name="productosPublicarML[ids][]">
		    <?php echo $producto->getIdProducto(); ?>
	    </td>
		<td>
		    <img src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_chica', $producto) ?>" width="100px">
	    </td>
		<td><?php echo htmlentities($productoItem->getCodigo()); ?></td>
		<td><a href="/backend/productos/<?php echo $producto->getIdProducto() ?>/edit"><?php echo $producto->getDenominacion(); ?></a></td>
		<td><?php echo $producto->getMarca()->getNombre(); ?></td>
		<td><?php echo $productoItem->getProductoTalle(); ?></td>
		<td><?php echo $productoItem->getProductoColor(); ?></td>
		<td><?php echo $productoItem->getCurrentStock(); ?></td>
		<td>
    		<?php if ( !$producto->getIdCategoriaMl() ): ?>
		    <span class="ko">
			    Este producto no se puede publicar.
			    <br/>
			    Pues no tiene categoria de Mercado Libre asignada.
			    <br/><br/>
		    </span>
    		<?php elseif ( $categoriaML->getAttributeTypes() != categoriaMl::ATTR_TYPE_VARIATIONS && count($productoItems) != 1 ): ?>
		    <span class="ko">
			    Este producto no se puede publicar en la categoría "<?php echo $categoriaML->getDenominacion(); ?>".
			    <br/>
			    Pues dicha categoría no permite variaciones de producto.
			    <br/><br/>
		    </span>
		    <?php elseif ( $producto->getPublicacionMl()->estaVigente() && !isset($result[ $producto->getIdProducto() ]) ): ?>
		    <span class="ko">
			    Este producto no se puede publicar.
			    <br/>
			    Pues ya está publicado en Mercado Libre
			    <br/><br/>
		    </span>
			<?php else: ?>
			<span class="<?php echo $result[ $producto->getIdProducto() ]['status_code'] ?>">
		    <?php echo html_entity_decode($result[ $producto->getIdProducto() ]['status']) ?>
		    </span>
    		<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php endforeach; ?>
	</tbody>
</table>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>