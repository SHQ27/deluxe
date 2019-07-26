<div class="container">
    <div class="titulo">DETALLE DE PEDIDO</div>
	<div class="numero">PEDIDO Nº <?php echo $pedido->getIdPedido() ?></div>

	<div class="grupo">
	    <div class="desc">DETALLE DEL PEDIDO</div>
		<span class="strong">Fecha de realización.</span> <?php echo date('d/m/Y', strtotime($pedido->getFechaAlta())); ?> 
		<br />
		<span class="strong">Estado.</span> <?php echo $pedido->getEstado() ?>
		<br />
	</div>

	<div class="grupo">
		<div class="desc">DETALLE DEL PAGO</div>
		
    	<?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
    	<span class="strong rojo">( El pago aún no se ha procesado )</span>
    	<br/>
    	<?php endif; ?>
		<span class="strong">Valor de los Productos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ) ?> 
		<br />
		<span class="strong">Cargo de envío.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) ?>
		<br />
		<?php if ( (float) $pedido->getMontoDescuento() ): ?>
		<span class="strong">Valor por descuentos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) ?>
		<br />
		<?php endif; ?>			
		<span class="strong">Valor Total.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ) ?>
		<br />
	</div>
	
	<div class="grupo">
		<div class="desc">PERSONA QUE RECIBIRÁ EL ENVÍO</div>
		<span class="strong">Destinatario.</span> <?php echo $pedido->getEnvioDestinatario() ?><br />
	</div>
	
	<?php if ($envios = $pedido->getTracking()): ?>
	<div class="grupo separado">
		<div class="desc">DETALLE DE ENVIO</div>
	    <?php foreach ($envios as $row): ?>
	    <span class="strong"><?php echo $row['fecha']; ?></span>&nbsp;&nbsp;&nbsp;<?php echo $row['mensaje']; ?>
	    <br />
	    <?php endforeach; ?>
	</div>
	<?php endif; ?>

	<div class="grupo separado">
		<div class="desc">PEDIDO ENVIADO A TRAVÉS DE <?php echo strtoupper( EnvioPack::getInstance()->getNombreCorreo( $pedido->getEnvioCorreo() ) ); ?></div>
		Para obtener más información acerca de tu envío podés contactarte a:
		<br />
		<strong>Web:</strong> <a href="<?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?>"><?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?></a>
		<br />
		<strong>Teléfono:</strong> <?php echo EnvioPack::getInstance()->getTelefonoCorreo( $pedido->getEnvioCorreo()  ); ?>
		<br />
		<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $pedido->getEnvioCorreo(); ?>.png"/>
	</div>	
	
	<div class="botones"><div class="cerrar">CERRAR</div></div>
</div>
