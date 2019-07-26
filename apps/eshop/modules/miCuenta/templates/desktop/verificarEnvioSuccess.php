<?php if ( $pedido && $pedido->getIdUsuario() == $sf_user->getCurrentUser()->getIdUsuario() ): ?>

    <div class="OS-11 color4 estado"><span class="MS-13">ESTADO.</span> <?php echo $pedido->getEstado(); ?></div>
	
	<?php if ( $pedido->getFechaEnvio() ): ?>
	
		<div class="MS-13 color4 t">DETALLE SEGUIMIENTO DEL ENVÍO</div>
		<div class="OS-11 color4 lh21">
		<?php $envios = $pedido->getTracking(); ?>
		<?php if ( count($envios) ): ?>
		    <?php foreach ($envios as $row): ?>
		    <span class="bold separada"><?php echo $row['fecha']; ?></span>
            <?php echo $row['mensaje']; ?>
            <br />   
		    <?php endforeach; ?>

			<br /><br />

			<div class="MS-13 color4 t">PEDIDO ENVIADO A TRAVÉS DE <?php echo strtoupper( EnvioPack::getInstance()->getNombreCorreo( $pedido->getEnvioCorreo() ) ); ?></div>
			
			Para obtener más información acerca de tu envío podés contactarte a:
			<br />
			<strong>Web:</strong> <a href="<?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?>"><?php echo EnvioPack::getInstance()->getWebCorreo( $pedido->getEnvioCorreo()  ); ?></a>
			<br />
			<strong>Teléfono:</strong> <?php echo EnvioPack::getInstance()->getTelefonoCorreo( $pedido->getEnvioCorreo()  ); ?>
			<br />
			<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $pedido->getEnvioCorreo(); ?>.png"/>
			

		<?php else: ?>
		Aún no tenemos informacion sobre el trackeo del envío
		<?php endif; ?>
		</div>

	<?php else: ?>
	
		<?php $estimacionEntrega = $pedido->getEstimacionEntrega(true); ?>
		<?php if ( !$pedido->getFechaBaja() && $estimacionEntrega ): ?>
		<div class="MS-13 color4 u">
			<?php echo $estimacionEntrega; ?>
		</div>
		<?php endif; ?>
	
	<?php endif; ?>
		
<?php else: ?>

	<div class="MS-13 color4 u">
		El pedido consultado no existe o pertenece a otro usuario.
	</div>
	
<?php endif; ?>