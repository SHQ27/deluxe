<?php sfContext::getInstance()->getResponse()->setTitle( 'Tu pedido ha sido dado de baja' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="pantalla">
			<div class="titulo">¡TU PEDIDO HA SIDO DADO DE BAJA!</div>
						
			<div class="texto OS-11 color4 lh18 text-center">
                <br />
                Ya no recibirás el recordatorio de pago por tu pedido, ya que el mismo ha sido dado de baja.
                <br /><br />
                <a class="color-link" href="<?php echo url_for('homepage')?>">Seguir recorriendo el sitio</a>
			</div>
		</div>
	</div>
</section>