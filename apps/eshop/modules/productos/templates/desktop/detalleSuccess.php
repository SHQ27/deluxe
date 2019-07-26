<?php sfContext::getInstance()->getResponse()->setTitle( $producto->getDenominacion() ); ?>

<?php slot('imageSrc', imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) ) ?>
<?php sfContext::getInstance()->getResponse()->addMeta("og:description", $producto->getDescripcionCorta(ESC_RAW)); ?>

<?php $request = sfContext::getInstance()->getRequest();?>

<script>
	var dataProductoItems = <?php echo html_entity_decode($dataProductoItems); ?>;		
	var productoPrice = <?php echo $producto->getPrecioDeluxe(); ?>;
	var productoNombre = '<?php echo $producto->getDenominacion(); ?>';
	var productoURL = '<?php echo $producto->getDetalleUrl(true); ?>';
	var productoImagenURL = '<?php echo imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto)?>';
</script>

<section id="producto" class="seccion blanco">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
	
		<div class="pantalla">
			<div class="barra OS-11 lh16 color2">
				<div class="izquierda">Inicio &gt; <a href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $productoCategoria->getSlug() ) ); ?>"><?php echo $productoCategoria->getDenominacion() ?></a> &gt; <span class="bold"><?php echo $producto->getDenominacion() ?></span></div>
				<div class="derecha">
					<a href="<?php echo url_for('productos_listado_categoria', array('slugProductoCategoria' => $productoCategoria->getSlug() ) ); ?>" class="bold">&lt; Volver</a>
				</div>
			</div>
			<div class="contFotos inline">
				<div class="inline">
            	    <?php foreach($productoImagenes as $productoImagen): ?>
                	<div class="thumb" style="background-image: url(<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $productoImagen)?>)" data-imagen-grande="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagen)?>"></div>
                	<?php endforeach; ?>
				</div>
				<div id="foto_grande" class="inline">
					<img src="" width="100%" />
				</div>
			</div>
			<div class="contInfo inline">
               <?php if ($producto->hasProbador() && $productoGenero->getIdProductoGenero() != productoGenero::NINOS  ): ?>
               <a class="btProbar OS-9 color4 bold probadorOnline">PROBADOR<br />ONLINE!</a>
               <?php endif; ?>
				<div class="nombre MS-24"><?php echo $producto->getDenominacion() ?></div>
				<div class="contPrecio">
					<div class="precio MS-18 color8 inline">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
				    <?php if ( $producto->getMostrarPrecioLista() ): ?>
					<div class="precioViejo OS-18 color6 inline">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?></div>
					<?php endif; ?>
				</div>
				
				<form id="addProductoForm" action="<?php echo url_for('carrito')?>" method="POST">
								
				    <input type="hidden" id="mostrarCartelMezcla" value="0"/>
				    
				    <?php echo $form['id_producto'] ?>
				
				    <?php if ( ! $producto->estaAgotado() ): ?>
    				<div class="selectGroup">
    				    
    					<div class="talle inline">
    						<div class="titulo_select OS-11 color2 lh16">TALLE.</div>
    						<div class="customSelect">
    						    <?php echo $form['talle']->render( array('class' => 'OS-11 color2 lh16') ); ?>
    						</div>
    					</div>
    					<div class="color inline">
    						<div class="titulo_select OS-11 color2 lh16">COLOR.</div>
	    						<div class="customSelect" id="colorBlocks" >
	    						    <?php echo $form['color']->render( array('class' => 'OS-11 color2 lh16') ); ?>
	    						</div>
    					</div>
    					<div class="cantidad inline">
    						<div class="titulo_select OS-11 color2 lh16">CANTIDAD.</div>
    						<div class="customSelect">
    						    <?php echo $form['cantidad']->render( array('class' => 'OS-11 color2 lh16') ); ?>
    						</div>
    					</div>    					
    				</div>
    				    				
    				<input type="submit" value="<?php echo $eshop->getTextoAgregarAlCarro(); ?>" class="btOscuro MS-15 bold color7"/>
    				
					<?php else: ?>
					
    				<p class="agotado">
    				    AGOTADO
				    </p>
    				
    				<?php endif; ?>
    				
				</form>
							
				<div class="financiacion">
					<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/eshop/icon-tarjeta.png">Precios exhibidos para compras al contado, tarjeta de débito y tarjeta de crédito en un pago
					<a href="https://www.mercadopago.com/promociones/" target="_blank">CONSULTE POR PLANES DE FINANCIACIÓN AQUÍ</a>
				</div>

				<?php $img = imageHelper::getInstance()->getUrl('eshop_medios_pagos_producto', $eshop); ?>
				<?php if ( imageHelper::getInstance()->exists( $img ) ): ?>
				<div class="banner-medios-pagos">
					<img src="<?php echo $img; ?>" />
				</div>
				<?php endif; ?>
							
				<div class="subtitulo MS-13 color2">DETALLES DEL PRODUCTO</div>
				<div class="texto OS-11 lh16 color5">
                    <?php if ($mostrarAlertaRopaInterior): ?>
                    <p class="rojo"><strong><?php echo $mensajeCategoriasRestringidas ?></strong></p>
                    <?php endif; ?>
                    <?php if ( $productoCategoria->getIdProductoCategoria() == 91 ): ?>
                    <p class="rojo"><strong>Los productos de outlet no tienen cambio en los locales</strong></p>
                    <?php endif; ?>
                    
				    <?php echo preg_replace('/(style|class)="[^"]*"/', '', $producto->getDescripcion(ESC_RAW)); ?> 
				</div>

				<div class="subtitulo subtituloInfoGeneral MS-13 color2">INFORMACIÓN GENERAL</div>
				<div class="infoGeneral">
					<div id="devoluciones2" class="item inline">
						<div class="MS-13 color4">DEVOLUCIONES</div>
						<div class="OS-11 lh15 color5 descripcion">Si no te gusta, lo podes devolver</div>
					</div><div id="cambios2" class="item inline">
						<div class="MS-13 color4">CAMBIOS</div>
						<div class="OS-11 lh15 color5 descripcion"><span class="cambios"></span></div>
					</div><div id="envios2" class="item inline">
						<div class="MS-13 color4">ENVÍOS</div>
						<div class="OS-11 lh15 color5 descripcion">Despacho en 96 hs hábiles</div>
					</div>
				</div>
								
				<div class="subtitulo MS-13 color2">COMPARTE ESTE PRODUCTO</div>
				<div class="redes">
					<div class="btRed inline">
						<a id="pinit" href="//es.pinterest.com/pin/create/button/?url=<?php echo $request->getUri(); ?>&media=<?php echo urlencode( imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto) ); ?>&description=<?php echo urlencode($producto->getDenominacion() . ' en ' . $producto->getMarca() . '!'); ?>" data-pin-do="buttonPin" data-pin-config="none"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
					</div>
					<div class="btRed inline">
						<div class="fb-like" data-href="<?php echo $producto->getDetalleUrl(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
					</div>
					<div class="btRed inline">
						<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</div>
					<div class="btRed inline google-plus">
						<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
    <div id="alerta_agregar_producto">
        <div class="white-popup-chico" id="agregar-carro">
        	<div class="titulo MS-24 color8 alignC lh19">IMPORTANTE</div>
        	<div class="linea"><div class="triangulos"></div></div>
        	
        	<div class="detalle">
        		<div class="OS-12 alignC color4 lh19">Debes seleccionar <span class="bold">talle, color y cantidad</span><br>
        		para agregar el producto al carro.</div>
        		
        		<div class="alignC"><div onclick="$.magnificPopup.instance.close()" class="btOscuro MS-15 bold color7">CERRAR</div></div>
        		
        	</div>
    </div>
    
    <?php include_component('productos', 'probador', array('producto' => $producto, 'idProductoGenero' => $productoGenero->getIdProductoGenero() )); ?>
</section>