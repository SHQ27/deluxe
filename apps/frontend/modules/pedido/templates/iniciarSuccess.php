	<?php sfContext::getInstance()->getResponse()->setTitle('Mi Carrito - Pago'); ?>

	<div id="checkout_carrito" class="paso2">
	
	    <div class="blank">
	
            <?php include_partial('carrito/carritoHeader', array('paso' => 3)); ?>
            
            <iframe class="mp" src="<?php echo $checkoutURL; ?>"></iframe>
            
        </div>
        
    </div>