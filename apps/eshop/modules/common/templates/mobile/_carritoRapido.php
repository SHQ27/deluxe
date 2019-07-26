<nav class="navCarrito" id="onlineBag">
	<ul>
	    <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
	    <?php $producto = $carritoProductoItem->getProductoItem()->getProducto(); ?>
		<li class="liprod item">
			<div class="row">
				<div class="col15">
					<div class="foto">
						<img class="producto" src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_chica', $producto); ?>" width="100%" />
					</div>
				</div>
				<div class="col70">
					<div class="nombre">
					    <a href="<?php echo $producto->getDetalleUrl(); ?>"><?php echo truncate_text($producto->getDenominacion(), 30)?></a>
					</div>
					<div class="price">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?></div>
				</div>
				<div class="col15">
					<div id="carritoRapidoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem(); ?>" class="delete"></div>
				</div>
			</div>
		</li>
		<?php endforeach; ?>
		<li class="li">
			<div class="total">TOTAL . <span class="totalPrice">$ <?php echo formatHelper::getInstance()->decimalNumber($montoTotal) ?></span></div>
		</li>
		<li class="liBoton">
			<a href="<?php echo url_for('carrito'); ?>" class="btIniciarCompra">INICIAR COMPRA</a>
		</li>
	</ul>
</nav>