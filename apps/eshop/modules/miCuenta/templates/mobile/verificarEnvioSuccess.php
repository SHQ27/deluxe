<?php if ( $pedido && $pedido->getIdUsuario() == $sf_user->getCurrentUser()->getIdUsuario() ): ?>

    <div class="estado"><span class="tituloestado">ESTADO.</span> <?php echo $pedido->getEstado(); ?></div>
	
	<?php if ( $pedido->getFechaEnvio() ): ?>
	
		<div class="title">DETALLE DEL SEGUIMIENTO DEL ENVÍO</div>
		<div class="detalle">
		<?php $envios = $pedido->getTracking(); ?>
		<?php if ( count($envios) ): ?>
		    <?php foreach ($envios as $row): ?>
		    <span class="bold separada"><?php echo $row['fecha']; ?></span>
            <?php echo $row['mensaje']; ?>
            <br />   
		    <?php endforeach; ?>
		<?php else: ?>
		Aún no tenemos informacion sobre el trackeo del envío
		<?php endif; ?>
		</div>

		<?php if ( count($envios) ): ?>
		<div class="title">PEDIDO ENVIADO A TRAVÉS DE <?php echo strtoupper( EnvioPack::getInstance()->getNombreCorreo( $pedido->getEnvioCorreo() ) ); ?></div>
		<div class="detalle">
			Para obtener más información acerca de tu envío podés contactarte a:
			<br />
			<strong>Web:</strong> <a href="<?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?>"><?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?></a>
			<br />
			<strong>Teléfono:</strong> <?php echo EnvioPack::getInstance()->getTelefonoCorreo( $pedido->getEnvioCorreo()  ); ?>
			<br />
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $pedido->getEnvioCorreo(); ?>.png"/>
		</div>
		<?php endif; ?>

	<?php else: ?>
	
		<?php $estimacionEntrega = $pedido->getEstimacionEntrega(true); ?>
		<?php if ( !$pedido->getFechaBaja() && $estimacionEntrega ): ?>
		<div class="MS-13 color4 u">
			<?php echo $estimacionEntrega; ?>
		</div>
		<?php endif; ?>
	
	<?php endif; ?>
		
<?php else: ?>

	<div class="error">
		El pedido consultado no existe o pertenece a otro usuario.
	</div>
	
<?php endif; ?>