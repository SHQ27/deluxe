	<?php sfContext::getInstance()->getResponse()->setTitle( $eshop->getMiCarroTitulo() . ' - Paso 1'); ?>
    <section id="checkout_carrito" class="seccion blanco paso1">
    	<div class="container">
    		<div class="linea"><div class="triangulos"></div></div>
    		<div class="pantalla">
    			
    			<?php include_partial('carritoHeader', array('paso' => 1, 'eshop' => $eshop)); ?>
    			    			
    			<div class="barra">
    				<div class="header MS-13 color4 inline c1">
    					MIS PRODUCTOS
    				</div><div class="header MS-13 color4 inline c2">
    					PRECIO UNITARIO
    				</div><div class="header MS-13 color4 inline c3">
    					CANTIDAD
    				</div><div class="header MS-13 color4 inline c4">
    					SUBTOTAL
    				</div>
    			</div>
    			<div class="items">    			
    	            <?php $total = 0; ?>
                    <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
    				<div class="item" id="carritoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem() ?>">
    				    <div class="MS-13 rojo alert hide"></div>
    					<div class="columna c1 inline">
    						<div class="foto inline">
    						  <img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $carritoProductoItem->getProductoItem()->getProducto() )?>" alt="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?>" />
						    </div>
    						<div class="inline datos">
    							<div class="nombre MS-18 color1"><?php echo truncate_text( $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion(), 25 ) ?></div>
    							<div class="OS-11 color1 lh18">TALLE. <?php echo $carritoProductoItem->getProductoItem()->getProductoTalle()->getDenominacion() ?></div>
    							<div class="OS-11 color2 lh18">COLOR. <?php echo $carritoProductoItem->getProductoItem()->getProductoColor()->getDenominacion() ?></div>
    							<div class="btEliminar btOscuro MS-15 bold color7 eliminar">ELIMINAR</div>
    						</div>  						
    					</div>
    					
    					<div class="columna c2 inline">
    						<div class="unitario MS-18 color1">$<?php echo formatHelper::getInstance()->decimalNumber( $carritoProductoItem->getProductoItem()->getProducto()->getPrecioDeluxe() ) ?>.-</div>
    					</div>
    					<div class="columna c3 inline">
    						<div class="cantidad">
    						    <div class="customSelect">
        							<select class="OS-11 color2 lh16">
                                		<?php $c = $carritoProductoItem->getProductoItem()->getMyCurrentStock(); ?>
                                		<?php for( $i = 1 ; $i <= $c ; $i++ ):?>
                                		<?php $selected = ($i == $carritoProductoItem->getCantidad())? 'selected="selected"' : ''; ?>
        								<option <?php echo $selected ?> value="<?php echo $i; ?>"><?php echo sprintf('%02d', $i); ?></option>
        								<?php endfor;?>
        							</select>
    							</div>
    						</div>
    					</div>
    					<div class="columna c4 inline">
    						<div class="subtotal MS-18 color8 total">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?>.-</div>
    					</div>
    				</div>
                    <?php $total += $carritoProductoItem->getSubTotal(); ?>
            		<?php endforeach; ?>
    				
    			</div>
    			
    			<div class="renglones">
                    <div id="generalError" class="MS-13 rojo hide"></div>
    				<div class="renglon alto dotted MS-13 color4 lh18 alignR checkoutSubTotal">
    					<div class="detalle inline MS-13 color4 lh18">
    						SUBTOTAL
    						<span class="inblock OS-11 color5">SIN GASTOS DE ENVÍO</span>
    					</div>
    					<span class="MS-18 color8 total">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?>.-</span>
    				</div>
    				<div class="renglon alto ancho dotted MS-13 color4 lh18">
    					<a href="<?php echo url_for('productos_listado'); ?>" class="inline btLink izquierda MS-15 bold color1"><span></span>SEGUIR COMPRANDO</a>
    					<div class="inline floatR">
    						<a id="goToPaso2" href="<?php echo url_for('carrito_paso_2'); ?>" class="inline btLink derecha MS-15 bold color8">CONTINUAR<span></span></a>
    					</div>
    				</div>
    			</div>
    			
    			
    		
    		</div>
    	</div>
    </section>
    
    <div class="scrollToTop"></div>