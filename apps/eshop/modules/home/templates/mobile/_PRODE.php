<section class="seccion bannerHome TEXTOPRODE">
	<div class="container">
		<div class="titulo"><?php echo $eshopHome->getTexto(ESC_RAW); ?></div>
	</div>
</section>

<section class="seccion bannerHome PRODE">
	<div class="groupPRODE">
		<?php for ($i = 0; $i < 4; $i++): ?> 
		<?php if ( isset( $productosDestacados[$i] ) ): ?> 
		<?php $producto = $productosDestacados[$i]; ?> 
		<div class="<?php echo ( $i % 2 == 0 ) ? 'prodeleft' : 'proderight' ?>">
			<div class="detalle">
				<div class="producto">
				  <img class="image" src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_grande', $producto); ?>" width="100%" />
				</div>
				<div class="nombre"><?php echo truncate_text($producto->getDenominacion(), 20) ; ?></div>
				<div class="row precio">
			    	<?php if ( $producto->getMostrarPrecioLista() ): ?>
				    <div class="col31 precioActual">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
				    <div class="col32">&nbsp;</div>
			        <div class="col33 precioViejo">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?></div>
			    	<?php else: ?>
				    <div class="col31">&nbsp;</div>
				    <div class="col32 precioActual">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
			        <div class="col33">&nbsp;</div>
					<?php endif; ?>
			    </div>
				<a href="<?php echo $producto->getDetalleUrl(); ?>"></a>
			</div>
		</div>
		<?php endif; ?> 
		<?php endfor; ?> 
	</div>
</section>