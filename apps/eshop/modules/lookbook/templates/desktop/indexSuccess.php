<section class="seccion lookbook <?php echo ($usaZoom) ? 'con-zoom' : ''; ?>">

	<?php if ( $sf_data->getRaw('dataModal') ): ?>
	<script>
		var dataModal = <?php echo html_entity_decode( $sf_data->getRaw('dataModal') ); ?>;
	</script>
	<?php endif; ?>


	<div class="container">
	    <?php foreach ($eshopLookbooks as $eshopLookbook): ?>
		<div class="item" rel="<?php echo $eshopLookbook->getIdEshopLookbook(); ?>">
			<img src="<?php echo imageHelper::getInstance()->getUrl('eshop_lookbook', $eshopLookbook); ?>"/>

			<?php if ($usaZoom): ?>
			<div class="info info_<?php echo $imagenesXFila; ?>">
				<h3><?php echo $eshopLookbook->getDenominacion(); ?></h3>
				<p><?php echo nl2br($eshopLookbook->getTexto() ); ?></p>
			</div>
			<?php else: ?>
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
    		<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>

	<?php if ($usaZoom): ?>
	<div id="modalZoom">
		<div class="info">
			<h3></h3>
			<p></p>
		</div>

		<div class="imagen">
			<img width="<?php echo imageHelper::getInstance()->getWidth('eshop_lookbook_zoom'); ?>" height="<?php echo imageHelper::getInstance()->getHeight('eshop_lookbook_zoom'); ?>"/>
		</div>
	</div>
	<?php endif; ?>

</section>