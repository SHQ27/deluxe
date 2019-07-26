<br/>

<?php if ( $pedido && $pedido->getIdUsuario() == $sf_user->getCurrentUser()->getIdUsuario() ): ?>

	<p>Estado: <?php echo $pedido->getEstado(); ?></p>
	
	<?php if ( $pedido->getFechaEnvio() ): ?>
	
		<p>
			Detalle del seguimiento del envío
			<br /><br />
			<?php $envios = $pedido->getTracking(); ?>
			<?php if ( count($envios) ): ?>
			    <?php foreach ($envios as $row): ?>
			            <span class="fecha"><?php echo $row['fecha']; ?></span>
			            <span class="destino"><?php echo $row['mensaje']; ?></span><br />   
			    <?php endforeach; ?>
			<?php else: ?>
			Aún no tenemos informacion sobre el trackeo del envío
			<?php endif; ?>
		</p>

		<p>
			Pedido enviado a través de <?php echo EnvioPack::getInstance()->getNombreCorreo( $pedido->getEnvioCorreo()  ); ?>
			<br /><br />
			Para obtener más información acerca de tu envío podés contactarte a:
			<br />
			<span>Web:</span> <a href="<?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?>"><?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?></a>
			<br />
			<span>Teléfono: <?php echo EnvioPack::getInstance()->getTelefonoCorreo( $pedido->getEnvioCorreo()  ); ?></span>
			<br />
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $pedido->getEnvioCorreo(); ?>.png"/>
		</p>
	
	<?php else: ?>
	
		<?php $estimacionEntrega = $pedido->getEstimacionEntrega(true); ?>
		<?php if ( !$pedido->getFechaBaja() && $estimacionEntrega ): ?>
		<p>
			<?php echo $estimacionEntrega; ?>
		</p>
		<?php endif; ?>
	
	<?php endif; ?>
		
<?php else: ?>

	<p>
		El pedido consultado no existe o pertenece a otro usuario.
	</p>
	
<?php endif; ?>