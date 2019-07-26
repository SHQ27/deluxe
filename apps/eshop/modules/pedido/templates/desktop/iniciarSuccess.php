	<?php sfContext::getInstance()->getResponse()->setTitle($eshop->getMiCarroTitulo() . ' - Pago'); ?>

    <section id="checkout_carrito" class="seccion blanco paso3">
    	<div class="container">
    		<div class="linea"><div class="triangulos"></div></div>
    		<div class="pantalla">
    		
    			<?php include_partial('carrito/carritoHeader', array('paso' => 3, 'eshop' => $eshop)); ?>

    			<iframe class="mp" src="<?php echo $checkoutURL; ?>"></iframe>

    		</div>
    	</div>
    </section>
    <div class="scrollToTop"></div>