<div id="onlineBag">
	<span class="carritoRapidoTotalPrendas totalPrendas Merriweather"><?php echo $totalItems?></span> <span class="totalPrendas Merriweather"><?php echo ngettext('PRENDA', 'PRENDAS', $totalItems); ?></span>
	<div class="sprite bag"></div>
	<div id="onlineBagContainer">
	
		<h3 class="Raleway">CONTENIDO DE TU CARRITO</h3>
		<div id="bag" class="bagListContainer">
		
		    <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
		    <?php $producto = $carritoProductoItem->getProductoItem()->getProducto(); ?>
			<div class="item">
			    <div class="cantidad hide"><?php echo $carritoProductoItem->getCantidad(); ?></div>
				<div id="carritoRapidoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem(); ?>" class="sprite row delete"></div>
				<div class="itemName"><a href="<?php echo $producto->getDetalleUrl(); ?>"><?php echo truncate_text($producto->getDenominacion(), 22)?></a></div>
				<div class="price">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?></div>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="total Raleway">
			TOTAL <span class="totalPrice">$ <?php echo formatHelper::getInstance()->decimalNumber($montoTotal) ?></span>
		</div>
		<a class="sprite showBag" href="<?php echo url_for('carrito'); ?>">VER MI CARRITO</a>
	</div>
</div>