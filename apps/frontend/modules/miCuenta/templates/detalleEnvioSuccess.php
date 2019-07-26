<h1>
    <span class="sprite icon-star-left"></span>
    <span class="Raleway">Tracking</span>
    <span class="sprite icon-star-right"></span>
</h1>

<h2>Este es el detalle del pedido #<?php echo $pedido->getIdPedido() ?></h2>


<div class="contain">
	
	
	<p>
		<label>Fecha de realización:</label>
		<?php echo date('d/m/Y', strtotime($pedido->getFechaAlta())); ?>
		<br />
		<label>Nº de Referencia:</label>
		<?php echo $pedido->getCodigoEnvio(); ?>
		<br />
		<label>Estado:</label>
		<?php echo $pedido->getEstado() ?>.
	</p>
	
	
	
	<h3>
	    Detalle del pago
    	<?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
    	<span class="alerta-pago">( El pago aún no se ha procesado )</span>
    	<?php endif; ?>
    </h3>
	
	<p>			
		<label>Valor de los productos:</label> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ) ?>
		<br />
		<label>Cargo de envío:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) ?>
		<br />
		<?php if ( (float) $pedido->getMontoDescuento() ): ?>
		<label>Valor por descuentos:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) ?>
		<br />
		<?php endif; ?>
		<?php if ( (float) $pedido->getMontoBonificacion() ): ?>
		<label>Valor por bonificaciones:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoBonificacion() ) ?>
		<br />
		<?php endif; ?>
		<label>Valor Total:</label> $ <?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ) ?> 
	</p>
	
	<?php if ($envios = $pedido->getTracking()): ?>
	<h3>Detalle de Envio</h3>
		
	<p>
	    <?php foreach ($envios as $row): ?>
		<label><?php echo $row['fecha']; ?></label>
	    <?php echo $row['mensaje']; ?>
	    <br />   
	    <?php endforeach; ?>
	</p>
	<?php endif; ?>


	<h3>Pedido enviado a través de <?php echo EnvioPack::getInstance()->getNombreCorreo( $pedido->getEnvioCorreo()  ); ?></h3>
	<p>
		Para obtener más información acerca de tu envío podés contactarte a:
		<br />
		<label>Web:</label> <a href="<?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?>"><?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?></a>
		<br />
		<label>Teléfono:</label> <?php echo EnvioPack::getInstance()->getTelefonoCorreo( $pedido->getEnvioCorreo()  ); ?>
		<br />
		<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $pedido->getEnvioCorreo(); ?>.png"/>
	</p>
	
	<a class="cerrar">Cerrar</a>
	
</div>