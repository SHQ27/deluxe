<div class="container">
    <div class="titulo MS-15 bold color1 alignC lh19">DETALLE DE PEDIDO</div>
	<div class="numero MS-13 color8 alignC lh19">PEDIDO Nº <?php echo $pedido->getIdPedido() ?></div>
	<div class="linea"><div class="triangulos"></div></div>
	
	<div class="detalle">
	
		<div class="grupo OS-11 color4 lh19">
		    <div class="desc MS-13">DETALLE DEL PEDIDO</div>
			<span class="bold">Fecha de realización.</span> <?php echo date('d/m/Y', strtotime($pedido->getFechaAlta())); ?> 
			<br />
			<span class="bold">Estado.</span> <?php echo $pedido->getEstado() ?>
			<br />
		</div>

		<div class="grupo OS-11 color4 lh19">
			<div class="desc MS-13">DETALLE DEL PAGO</div>
			
        	<?php if (!$pedido->getFechaPago() && !$pedido->getFechaBaja()): ?>
        	<span class="bold rojo">( El pago aún no se ha procesado )</span>
        	<br/>
        	<?php endif; ?>
			<span class="bold">Valor de los Productos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoProductos() ) ?> 
			<br />
			<span class="bold">Cargo de envío.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ) ?>
			<br />
    		<?php if ( (float) $pedido->getMontoDescuento() ): ?>
    		<span class="bold">Valor por descuentos.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ) ?>
    		<br />
    		<?php endif; ?>			
			<span class="bold">Valor Total.</span> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ) ?>
			<br />
		</div>
		
		<div class="grupo OS-11 color4 lh19">
			<div class="desc MS-13">PERSONA QUE RECIBIRÁ EL ENVÍO</div>
			<span class="strong">Destinatario.</span> <?php echo $pedido->getEnvioDestinatario() ?><br />
		</div>
		

    	<?php if ($envios = $pedido->getTracking()): ?>
		<div class="grupo separado OS-11 color4 lh19">
			<div class="desc MS-13">DETALLE DE ENVIO</div>
    	    <?php foreach ($envios as $row): ?>
    	    <span class="bold"><?php echo $row['fecha']; ?></span> <?php echo $row['mensaje']; ?>
    	    <br />
    	    <?php endforeach; ?>
    	</div>
    	<?php endif; ?>

		<div class="grupo separado OS-11 color4 lh19">
			<div class="desc MS-13">PEDIDO ENVIADO A TRAVÉS DE <?php echo strtoupper( EnvioPack::getInstance()->getNombreCorreo( $pedido->getEnvioCorreo() ) ); ?></div>

			Para obtener más información acerca de tu envío podés contactarte a:
			<br />
			<strong>Web:</strong> <a href="<?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?>"><?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?></a>
			<br />
			<strong>Teléfono:</strong> <?php echo EnvioPack::getInstance()->getTelefonoCorreo( $pedido->getEnvioCorreo()  ); ?>
			<br />
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $pedido->getEnvioCorreo(); ?>.png"/>
    	</div>			

		
		<div class="alignC"><div class="btOscuro MS-15 bold color7 cerrar">CERRAR</div></div>
		
	</div>
	
</div>
