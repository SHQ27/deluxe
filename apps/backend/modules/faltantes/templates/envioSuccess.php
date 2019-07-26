<div id="sf_admin_container" class="faltantes">
    
    <h1>Faltantes - Envío</h1>
    		
    		
	<?php if ( isset($enviado) && $enviado ): ?>
	<p>El mensaje ha sido enviado.</p>
	<?php else: ?>    		
    <form method="post">
    	<?php echo $form['_csrf_token']; ?>
    	
    	<div class="row">
	    	<label>Pedido #</label>
			<?php echo $pedido->getIdPedido(); ?>
		</div>
		
    	<div class="row">
	    	<label>Usuario</label>
			<?php echo $pedido->getUsuario()->getNombre() ?> <?php echo $pedido->getUsuario()->getApellido() ?>
		</div>
		
    	<div class="row">
	    	<label>Email</label>
			<?php echo $pedido->getUsuario()->getEmail() ?>
		</div>
		
    	<div class="row">
	    	<label>Producto</label>
			<?php echo $productoItem->getProducto()->getDenominacion(); ?>
			<br/>
			Talle: <?php echo $productoItem->getProductoTalle()->getDenominacion(); ?> | Color: <?php echo $productoItem->getProductoColor()->getDenominacion(); ?>
		</div>
    	
    	<div class="row mensaje">
	    		<?php echo $form['mensaje']->renderLabel(); ?>
	    		<br/>	    	
	    		<p>
					Hola <?php echo $pedido->getUsuario()->getNombre() ?> <?php echo $pedido->getUsuario()->getApellido() ?>,
				</p>
				<p>
					<?php if ( count( $pedido->getPedidoProductoItem() ) > 1 ): ?>
					Te informamos que enviamos tu pedido #<?php echo $pedido->getIdPedido(); ?> con el faltante de (CANTIDAD) <?php echo $productoItem->getProducto()->getDenominacion(); ?> (Talle: <?php echo $productoItem->getProductoTalle()->getDenominacion(); ?> | Color: <?php echo $productoItem->getProductoColor()->getDenominacion(); ?>).
					<?php else: ?>
					Te informamos que no enviamos tu pedido #<?php echo $pedido->getIdPedido(); ?> por existir un faltante de (CANTIDAD) <?php echo $productoItem->getProducto()->getDenominacion(); ?> (Talle: <?php echo $productoItem->getProductoTalle()->getDenominacion(); ?> | Color: <?php echo $productoItem->getProductoColor()->getDenominacion(); ?>).
					<?php endif; ?>			
				</p>
				<?php if ( $form['mensaje']->getError() ): ?>
				<p class="error">
					<?php echo $form['mensaje']->getError(); ?>
				</p>
				<?php endif; ?>
				<p>
					<?php echo $form['mensaje']; ?>
				</p>
								
                <?php if ($pedido->getIdEshop() || $pedido->getIdFormaPago() == formaPago::MERCADOLIBRE): ?>
				<p>
					Por este motivo, realizamos el reintegro de dinero a través de MercadoPago.
				</p>
				<p>
					Desde ya te pedimos disculpas por las molestias ocasionadas.
				</p>
                <?php else: ?>
				<p>
					Por este motivo, te pedimos que elijas una de las siguientes opciones haciendo click en una de ellas:
				</p>
				<p>
				    Dejar el crédito a favor en Deluxebuys para realizar otra compra o realizar la devolución de dinero a través de MercadoPago a través de nuestro canal de atención al cliente
            	</p>
				<p>
					Desde ya te pedimos disculpas por las molestias ocasionadas y quedamos a la espera de tu respuesta.
				</p>
                <?php endif; ?>
				<br/>
		</div>
		
		<div class="row">	
	    	<?php echo $form['cantidad']->renderLabel(); ?>
			<?php echo $form['cantidad']; ?>
		</div>
		
        <input type="submit" value="Enviar" />        
    </form>
    <?php endif; ?>
    
</div>