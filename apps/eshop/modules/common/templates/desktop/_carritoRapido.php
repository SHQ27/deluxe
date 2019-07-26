<a id="btMiCarro" class="btMiCarro item semiBold" rel="header"><?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?><span class="inline totalPrendas carritoRapidoTotalPrendas"><?php echo $totalItems?></span></a>

<div id="onlineBag" class="desplegable">
	<span class="arrow"></span>
	
	<div class="titulo MS-13"><?php echo $eshop->getTextoCarroDeCompras(); ?></div>
	
	<ul class="items">
	    <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
	    <?php $producto = $carritoProductoItem->getProductoItem()->getProducto(); ?>
		<li class="item">
			<div class="foto inline">
				<img class="producto" src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_chica', $producto); ?>" width="36" />
			</div>
			<div class="inline">
				<div class="nombre OS-13">
				    <a href="<?php echo $producto->getDetalleUrl(); ?>"><div class="inline cantidad"><?php echo $carritoProductoItem->getCantidad(); ?></div> x <?php echo truncate_text($producto->getDenominacion(), 22)?></a>
				</div>
				<div class="MS-13 price">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?></div>
			</div>
			<div id="carritoRapidoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem(); ?>" class="delete"></div>
		</li>
		<?php endforeach; ?>
	</ul>
	
	<div class="total MS-13">TOTAL . <span class="totalPrice">$ <?php echo formatHelper::getInstance()->decimalNumber($montoTotal) ?></span></div>
	
	<a href="<?php echo url_for('carrito'); ?>" class="d_btVerCarro inblock alignC MS-13">VER <?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?></a>
	
</div>