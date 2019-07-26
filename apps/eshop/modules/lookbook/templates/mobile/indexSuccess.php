<section class="seccion lookbook">
	<div class="container">
	    <?php foreach ($eshopLookbooks as $eshopLookbook): ?>
		<div class="item">

			<?php if ($usaZoom): ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_lookbook_zoom', $eshopLookbook); ?>"/>
			<?php else: ?>
			<img src="<?php echo  imageHelper::getInstance()->getUrl('eshop_lookbook', $eshopLookbook); ?>"/>
    		<?php endif; ?>	

	        <?php $eshopLookbookProductos = $eshopLookbook->getEshopLookbookProducto(); ?>
	        <?php foreach ($eshopLookbookProductos as $eshopLookbookProducto):?>
        	<?php $producto = $eshopLookbookProducto->getProducto(); ?>
	        <div class="lookbookPointer" style="top: <?php echo $eshopLookbookProducto->getPositionTop(); ?>px ;left: <?php echo $eshopLookbookProducto->getPositionLeft(); ?>px;">
	        	<div class="indicador"></div>
	        	<div class="infoProducto">
	        		<div class="contenedor">
	        			<div class="titulo"><?php echo truncate_text($producto->getDenominacion(), 27) ; ?></div>
	        			<div class="precio">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
		        		<a class="link" href="<?php echo $producto->getDetalleUrl(); ?>">Comprar</a>
        			</div>
	        	</div>
	        </div>
	        <?php endforeach; ?>
		</div>
		<?php endforeach; ?>
	</div>

	<div id="infoProducto"></div>
	<div id="infoProductoOverlay"></div>
</section>

<div class="lookbookPopUp">
</div>