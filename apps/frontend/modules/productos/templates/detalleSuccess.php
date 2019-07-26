		
	<?php sfContext::getInstance()->getResponse()->setTitle( $producto->getDenominacion() . ' - ' . $producto->getMarca()->getNombre() . ' - Tienda de Moda Online' ); ?>
	
	<?php sfContext::getInstance()->getResponse()->addMeta('description', 'Comprá ' . $producto->getDenominacion() . ' - ' . $producto->getMarca()->getNombre() . ' - En DeluxeBuys la Tienda Online de Moda e Indumentaria hasta un 70% OFF' ); ?>

	<?php sfContext::getInstance()->getResponse()->addMeta('keywords', $producto->getDenominacion() . ', ' . $producto->getMarca()->getNombre() . ', ' . $productoCategoria->getDenominacion() . ', ' .$metaProductTags . 'Indumentaria, DeluxeBuys, Ropa' ); ?>
	
	<?php slot('imageSrc', imageHelper::getInstance()->getUrl('producto_detalle_chica', $productoImagenes[0]) ) ?>
	<?php sfContext::getInstance()->getResponse()->addMeta("og:description", $producto->getDescripcionCorta(ESC_RAW)); ?>

	<?php $request = sfContext::getInstance()->getRequest();?>

    <script>
        // Facebook Ads
        $(document).ready( function() {
            setTimeout(function(){
                if ( window._fbq ) {
                    window._fbq.push(['track', 'ViewContent', { content_ids: ['<?php echo $producto->getIdProducto(); ?>'], content_type: 'product' }]);
                 }
            }, 1000);
        } );
    </script>

<script>
    var dataProductoItems = <?php echo html_entity_decode($dataProductoItems); ?>;      
    var productoPrice = <?php echo $producto->getPrecioDeluxe(); ?>;
    var productoNombre = '<?php echo $producto->getDenominacion(); ?>';
    var productoURL = '<?php echo $producto->getDetalleUrl(true); ?>';
    var productoImagenURL = '<?php echo imageHelper::getInstance()->getUrl('producto_detalle_grande', $producto)?>';
</script>
		
    <div id="ficha">
    
        <div class="breadcrum">
            <a href="<?php echo url_for('ofertas_listado'); ?>">OFERTAS</a>
            <?php if ( $campana ): ?>
             / 
             <a href="<?php echo url_for('ofertas_detalles', array('slugCampana' => $campana->getSlug() ) ); ?>"><?php echo $campana->getDenominacion()?></a> 
            <?php endif; ?>
             / 
             <span><?php echo $producto->getDenominacion()?></span>
          </div>

        <div class="blockContentTwo imagesBlock fleft">
        	<div class="product-picture">
                    <?php if ( $producto->getProductoSticker() && $producto->getProductoSticker()->exists() ): ?>
                    <div>
                        <img class="sticker" src="<?php echo imageHelper::getInstance()->getUrl('producto_sticker_grande', $producto->getProductoSticker() ); ?>" />
                    </div>
                    <?php endif; ?>
        	    <?php foreach($productoImagenes as $productoImagen): ?>
            	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_mediana', $productoImagen)?>" class="bigImage" width="390" height="588"/>
            	<?php endforeach; ?>
            </div>
            <div class="productRecordSlider">
                <ul class="slider">
        	    <?php foreach($productoImagenes as $productoImagen): ?>
        	    <li><a href="javascript:;"><img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $productoImagen)?>" width="96" height="146"/></a></li>
            	<?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="blockContentTwo ficha fright">
            <h1><?php echo $producto->getMarca()->getNombre(); ?></h1>
            <h2 class="margin-bottom10"><?php echo $producto->getDenominacion(); ?></h2>
            <div class="subTotal margin-bottom15">
                <div class="sprite yellowBgFlagTwo fleft price">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
                <?php if ( $producto->getMostrarPrecioLista() ): ?>
                <span class="listPrice fleft">PRECIO DE LISTA: <strong>$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ); ?></strong></span>
                <?php endif; ?>
                <div class="fb-like" data-href="<?php echo $request->getUri(); ?>" data-width="450" data-layout="button_count" data-show-faces="false" data-send="false"></div>
            </div>
            
            <div class="clear"></div>

        	<form id="addProductoForm" action="<?php echo url_for('carrito')?>" method="POST">
    		
    		    <input type="hidden" id="mostrarCartelMezcla" value="<?php echo ($mostrarCartelMezcla) ? 1 : 0; ?>"/>
    		
    		    <?php echo $form['id_producto'] ?>
    		
                <div class="fichaForm">
                   <?php if ( $productoGenero->getIdProductoGenero() != productoGenero::NINOS  ): ?>
                   <a class="sprite probadorOnline" href="#"></a>
                   <?php endif; ?>
                   
                   <?php if ( !$estaAgotado ): ?>
                   <div class="row">
                        <div class="label">ELEGI UN TALLE:</div>
                   		<div class="customSelect">
                   		    <?php echo $form['talle'] ?>
						</div>
                    </div> 
                   <div class="row">
                        <div class="label">ELEGI UN COLOR:</div>
                        <div class="customSelect" id="colorBlocks" >
                            <div style="display: none">
                            <?php echo $form['color'] ?>
                            </div>    
						</div>
                    </div> 
                   <div class="row">
                        <div class="label">CANTIDAD:</div>
                        <div class="customSelect">
                            <?php echo $form['cantidad'] ?>
						</div>
                    </div> 
                    <div class="fleft">
                        <input type="submit" value="" class="sprite agregarAlCarritoButton " />
                    </div>
                    <?php else: ?>	
                    <div class="agotado">
                        AGOTADO
                    </div>
                    <?php endif; ?>
                                    	
		            <div class="shareProduct hide">
		                <span>Compartir</span>
		                <ul>
		                    <li>
			                    <a class="sprite blackIcons facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( $request->getUri() )?>"></a>
		                    </li>
		                    <li>
	                            <a class="sprite blackIcons twitter" target="_blank" href="http://twitter.com/intent/tweet?url=<?php echo urlencode( $request->getUri() )?>&text=<?php echo urlencode($producto->getDenominacion(ESC_RAW) . ' - ' . formatHelper::getInstance()->formatPrice($producto->getPrecioDeluxe()) ) ?>"></a>
	                        </li>
		                    <li id="pinterest_button">
					            <script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
                                <a href="https://www.pinterest.com/pin/create/button/"
                                   data-pin-url="<?php echo urlencode( $request->getUri() ); ?>"
                                   data-pin-media="<?php echo urlencode( imageHelper::getInstance()->getUrl('producto_detalle_grande', $productoImagenes[0]) ); ?>"
                                   data-pin-description="<?php echo urlencode($producto->getDenominacion()); ?> en DeluxeBuys!"
                                   data-pin-custom="true"></a>
	                        </li>
		                    <li>
			                    <a class="sprite blackIcons mail"></a>
		                    </li>
		                </ul>
		                <div class="facebookLikeIt"></div>
		            </div>
		            
                </div>

            </form>
			<div class="clear"></div>
			
			<span class="sendingDateMsg">
            <?php  if ( $estimacionEntrega ): ?>
            <?php echo $estimacionEntrega;  ?>
            <?php  endif; ?>
			</span>

            <div class="clear margin-top10"></div>
            <div class="separator"></div>
            <div class="clear margin-bottom15"></div>

            <div class="cashPay">
            	<div class="fleft sprite textImage"></div>
                <div class="fright">
                    <img src="<?php echo $mediosDePago->getImage(); ?>" />
                </div>
            </div>
            <div class="clear margin-bottom15"></div>
            <div class="separator"></div>
            <div class="clear"></div>
            <div class="productDescription">
                <?php if ($mostrarAlertaRopaInterior): ?>
                <p class="rojo"><strong><?php echo $mensajeCategoriasRestringidas ?></strong></p>
                <?php elseif ( $producto->getEsOutlet() ): ?>
                <p class="rojo"><strong>Importante: los productos de esta promoción puntual, no tienen cambio ni devolución exceptuando fallas</strong></p>
                <?php else:  ?>
                <p><strong>Las devoluciones se realizan dentro de los 10 días de recibido el producto por intermedio de Deluxe Buys.</strong></p>
	            <?php endif; ?>
	            
            	<?php echo preg_replace('/(style|class)="[^"]*"/', '', $producto->getDescripcion(ESC_RAW)); ?>
            </div>
            <div class="clear margin-bottom15"></div>

            <?php $tags = $producto->listTags(); ?>
            <?php if ( count($tags) ): ?>
            <div class="tags">
                <span class="fleft margin-right15">Tags:</span>
                <ul>
  	                <?php foreach ($tags as $tag): ?>
                    <li><a href="<?php echo url_for('productos_listado_tag', array('queryTag' => $tag->getDenominacion() ) ); ?>"><?php echo $tag->getDenominacion() ?></a></li>
                    <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <div class="clear margin-bottom15"></div>
        </div>

        <div id="alerta_mezcla">
            <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/alerta_mezcla.jpg" />
        </div>
        
        <div id="alerta_agregar_producto">
            <img src="<?php echo sfConfig::get('app_host_static'); ?>/images/alert_agregar_producto.jpg" />
        </div>
    	
    	<?php include_component('productos', 'probador', array('producto' => $producto, 'idProductoGenero' => $productoGenero->getIdProductoGenero() )); ?>	
    	<?php include_component('common', 'recomendarProducto', array('idProducto' => $producto->getIdProducto()) )?>
        
    </div> 
    
    <script src="http://vu.adschoom.com/trafic/retar.php?type=PRODUIT&boutique=DELUXEBUYS&produit_id=<?php echo $producto->getIdProducto(); ?>" async="async" defer="defer"></script>

    <?php include_partial('global/tagsRemarketing', array('itemId1' => $producto->getDenominacion(), 'pageType' => 'offerdetail', 'value' => $producto->getPrecioDeluxe() )); ?>