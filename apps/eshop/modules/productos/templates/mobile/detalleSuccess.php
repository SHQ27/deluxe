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

<div class="seccion productoImagenSlider">
	<ul class="slides">
	    <?php foreach($productoImagenes as $productoImagen): ?>
	    <li>
			<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagen)?>" width="100%"/>
		</li>
    	<?php endforeach; ?>
	</ul>
</div>

<div class="productoInfo">
	<div class="data">
		<div class="nombre"><?php echo $producto->getDenominacion() ?></div>
		<div class="precio">
			<span class="precioActual">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></span>
		    <?php if ( $producto->getMostrarPrecioLista() ): ?>
			&nbsp;|&nbsp;&nbsp;<span class="precioViejo">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?></span>
			<?php endif; ?>
		</div>

		<form id="addProductoForm" action="<?php echo url_for('carrito')?>" method="POST">
		    <?php echo $form['id_producto'] ?>
					
		    <?php if ( ! $producto->estaAgotado() ): ?>
	    	<div class="talle">
	    		<div class="customSelect"><?php echo $form['talle']->render(); ?></div>
	    	</div>
	    	<div class="color">
	    		<div class="customSelect" id="colorBlocks">
	    			<div class="customSelect" style="display: none"><?php echo $form['color']->render(); ?></div>
	    		</div>
	    	</div>
	    	<div class="cantidad">
	    		<div class="customSelect"><?php echo $form['cantidad']->render(); ?></div>
	    	</div>

			<input type="submit" value="<?php echo $eshop->getTextoAgregarAlCarro(); ?>" class="btAgregarCarrito"/>
			<?php else: ?>
		    <div class="row">
		    	<div class="col31">&nbsp;</div>
		    	<div class="col32">
					<p class="agotado">
					    AGOTADO
				    </p>
		    	</div>
		    	<div class="col33">&nbsp;</div>
		    </div>
			<?php endif; ?>
		</form>
	</div>

	<div class="detalle">
		<div class="titulo">DETALLES DEL PRODUCTO</div>
		<div class="desc">
            <?php if ($mostrarAlertaRopaInterior): ?>
            <p class="rojo"><strong><?php echo $mensajeCategoriasRestringidas ?></strong></p>
            <?php endif; ?>   
			<?php if ( $productoCategoria->getIdProductoCategoria() == 91 ): ?>
			<p class="rojo"><strong>Los productos de outlet no tienen cambio en los locales</strong></p>
			<?php endif; ?>
		    <?php echo preg_replace('/(style|class)="[^"]*"/', '', $producto->getDescripcion(ESC_RAW)); ?> 
		</div>
	</div>

	<div class="compartir">
		<hr />

		<div class="titulo">COMPARTI ESTE PRODUCTO</div>
		<div class="redes">
			<div class="btRed">
				<a id="pinit" href="//es.pinterest.com/pin/create/button/?url=<?php echo $request->getUri(); ?>&media=<?php echo urlencode( imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto) ); ?>&description=<?php echo urlencode($producto->getDenominacion() . ' en ' . $producto->getMarca() . '!'); ?>" data-pin-do="buttonPin" data-pin-config="none"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
			</div>
			<div class="btRed">
				<div class="fb-like" data-href="<?php echo $producto->getDetalleUrl(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
			</div>
			<div class="btRed">
				<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
			<div class="btRed google-plus">
				<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120"></div>
			</div>
		</div>

		<!--<hr />-->
	</div>

    <div id="alerta_agregar_producto">
        <div class="white-popup-chico" id="agregar-carro">
        	<div class="titulo">IMPORTANTE</div>

        	<div class="detalle">
        		<div>Debes seleccionar <span class="strong">talle, color y cantidad</span><br>
        		para agregar el producto al carro.</div>
        	</div>
    		
    		<div class="botonera"><div onclick="$.magnificPopup.instance.close()" class="btCerrar">CERRAR</div></div>
        </div>
    </div>
</div>

<!--
<div class="seccion bannerHome TEXTOPUEDEINTERESAR">
	<div class="container">
		<div class="titulo">TAMBIEN TE PUEDE INTERESAR</div>
	</div>
</div>

<div class="seccion bannerHome PRODE">
	<div class="groupPRODE">
		<div class="prodeleft">
			<div class="detalle">
				<div class="producto">
				  <img class="image" src="http://192.168.1.166/uploads/producto/lista/grande/173299.jpg" width="100%" />
				</div>
				<div class="nombre">Buzo Vestido Alexia - Estam...</div>
				<div class="row precio">
				    <div class="col31 precioActual">$668</div>
					<div class="col32">&nbsp;</div>
			        <div class="col33 precioViejo grisOscuro">$890</div>
			    </div>
				<a href="/producto/Abrigos/54389-buzo-vestido-alexia-estampado"></a>
			</div>
		</div>
		<div class="proderight">
			<div class="detalle">
				<div class="producto">
				  <img class="image" src="http://192.168.1.166/uploads/producto/lista/grande/173296.jpg" width="100%" />
				</div>
				<div class="nombre">Buzo Vanesa - Estampado</div>
				<div class="row precio">
				    <div class="col31 precioActual">$705</div>
					<div class="col32">&nbsp;</div>
			        <div class="col33 precioViejo">$940</div>
			    </div>
				<a href="/producto/Abrigos/54388-buzo-vanesa-estampado"></a>
			</div>
		</div>
	</div>
	<div class="groupPRODE">
		<div class="prodeleft">
			<div class="detalle">
				<div class="producto">
				  <img class="image" src="http://192.168.1.166/uploads/producto/lista/grande/173350.jpg" width="100%" />
				</div>
				<div class="nombre">Sweater Silvestre - Rayas</div>
				<div class="row precio">
				    <div class="col31 precioActual">$855</div>
					<div class="col32">&nbsp;</div>
			        <div class="col33 precioViejo grisOscuro">$1,140</div>
			    </div>
				<a href="/producto/Abrigos/54407-sweater-silvestre-rayas"></a>
			</div>
		</div>
		<div class="proderight">
			<div class="detalle">
				<div class="producto">
				  <img class="image" src="http://192.168.1.166/uploads/producto/lista/grande/173306.jpg" width="100%" />
				</div>
				<div class="nombre">Sweater Laura - Gris</div>
				<div class="row precio">
				    <div class="col31 precioActual">$980</div>
					<div class="col32">&nbsp;</div>
			        <div class="col33 precioViejo grisOscuro">$1,480</div>
			    </div>
				<a href="/producto/Abrigos/54391-sweater-laura-gris"></a>
			</div>
		</div>
	</div>
</div>
-->