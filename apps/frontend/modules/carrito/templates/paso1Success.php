	<?php sfContext::getInstance()->getResponse()->setTitle('Mi Carrito - Paso 1'); ?>


	<div id="checkout_carrito" class="paso1">
	
	    <div class="blank">
	
            <?php include_partial('carritoHeader', array('paso' => 1)); ?>

        	<div class="clear"></div>
        	<div class="checkoutDescription">
        		<div class="sprite ico checkoutBag"></div>
        		<p>
        			<span class="bold">MI CARRITO.</span> ESTOS SON LOS PRODUCTOS QUE DESEA COMPRAR:
        			
                    <?php if ($tieneOfertas):?>
        			<span class="black">
        				RECORDA QUE EL PEDIDO SE ENVIARA LUEGO DE LOS 10 DÍAS TERMINADA LA CAMPAÑA
        			</span>	
                    <?php endif; ?>
        		</p>
        	</div>
        
        	<div class="listProductItems checkout">
        	
            	<div class="hide" id="generalError"></div>
        	
                <?php $total = 0; ?>
                <?php foreach ($carritoProductoItems as $carritoProductoItem): ?>
        		<div class="item" id="carritoProductoItem_<?php echo $carritoProductoItem->getIdCarritoProductoItem() ?>">
        	
                	<a href="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDetalleUrl(); ?>">
                    	<img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $carritoProductoItem->getProductoItem()->getProducto() )?>" alt="<?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?>"/>
                	</a>
        		
        			<div class="producto">
        				<h3 class="Raleway">PRODUCTO</h3>
        				<h2 class="Raleway"><?php echo $carritoProductoItem->getProductoItem()->getProducto()->getDenominacion() ?></h2>
        				<p class="pink">
        					TALLE: <?php echo $carritoProductoItem->getProductoItem()->getProductoTalle()->getDenominacion() ?>
        					<span>COLOR: <?php echo $carritoProductoItem->getProductoItem()->getProductoColor()->getDenominacion() ?></span>
        				</p>
    	    	        <p class="alert hide"></p>
        			</div>
        			<div class="precioUnidad">
        				<h3 class="Raleway">PRECIO UNIDAD</h3>
        				<h2>$<?php echo formatHelper::getInstance()->decimalNumber( $carritoProductoItem->getProductoItem()->getProducto()->getPrecioDeluxe() ) ?>.-</h2>
        			</div>
        			<div class="cantidad">
        				<h3 class="Raleway">CANTIDAD</h3>
        				<div class="customSelect">
                        	<select>
                        		<?php $c = $carritoProductoItem->getProductoItem()->getMyCurrentStock(); ?>
                        		<?php for( $i = 1 ; $i <= $c ; $i++ ):?>
                        		<?php $selected = ($i == $carritoProductoItem->getCantidad())? 'selected="selected"' : ''; ?>
                        		<option <?php echo $selected ?> value="<?php echo $i; ?>"><?php echo sprintf('%02d', $i); ?></option>
                        		<?php endfor;?>
                        	</select>
                    	</div>
        				<span><a class="eliminar">Eliminar</a></span>
        			</div>
        			<div class="valor">
        				<h3 class="Raleway">TOTAL</h3>
        				<h2 class="total">$<?php echo formatHelper::getInstance()->decimalNumber($carritoProductoItem->getSubTotal()) ?>.-</h2>
        			</div>
        		</div>
                <?php $total += $carritoProductoItem->getSubTotal(); ?>
        		<?php endforeach; ?>
        		
        		
        	</div>
    	
		</div>
    
    	<div class="checkoutSubTotal">
    		<div class="fright">
    			<span class="fleft text">Subtotal sin gastos de envio cargados:</span>
    			<div
    				class="sprite yellowBgFlag fleft margin-lessTop10 margin-left10">
    				<span class="total">$<?php echo formatHelper::getInstance()->decimalNumber($total) ?></span>
    			</div>
    		</div>
    	</div>
    
    	<div class="checkoutFooterItem">
    		<div class="fleft">
            	<?php if ($dataMezcla['campana']): ?>
            	<a href="<?php echo url_for('ofertas_detalles', array('slugCampana' => $dataMezcla['campana']->getSlug() ) ) ?>">
            	<?php else: ?>	
            	<a href="<?php echo url_for('homepage'); ?>">
            	<?php endif; ?>
            	    <span>&lt;</span>
            	    SEGUIR COMPRANDO
        	    </a>
    		</div>
    		<div class="fright">
    			<a href="<?php echo url_for('carrito_paso_2'); ?>" class="pink" id="goToPaso2" onclick="ga('send', 'event', 'boton', 'intencion de compra', 'carrito');">
    			    CONTINUAR
    			    <span>&gt;</span>
    			</a>
    		</div>
    	</div>
	</div>

    <?php include_partial('global/tagsRemarketing', array('itemId1' => 'Carrito - Paso 1', 'pageType' => 'conversionintent')); ?>