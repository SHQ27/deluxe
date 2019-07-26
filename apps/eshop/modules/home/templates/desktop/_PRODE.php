<section id="destacados" class="seccion">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="titulo MS-24 color1"><?php echo $eshopHome->getTexto(ESC_RAW); ?></div>
		
		<!-- SLIDER 1 -->
		<div class="flexslider">
			<ul class="slides">
			    <?php foreach ($productosDestacados as $producto): ?>
                <li>
    				<div class="producto">
					  <img class="principal" src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_grande', $producto); ?>" />
					  <img class="hover" src="<?php echo imageHelper::getInstance()->getUrl('producto_lista_grande', $producto->getProductoImagenHover() ); ?>" />
    				</div>
    				<div class="nombre"><?php echo truncate_text($producto->getDenominacion(), 28) ; ?></div>
    				<div class="precio">
        		    	<?php if ( $producto->getMostrarPrecioLista() ): ?>
        		        <span class="precioViejo">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?></span>
        				<?php endif; ?>
    				    $<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?>
				    </div>
    				<a href="<?php echo $producto->getDetalleUrl(); ?>"></a>
				</li>			    
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>