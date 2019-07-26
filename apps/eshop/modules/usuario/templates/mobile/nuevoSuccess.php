<?php sfContext::getInstance()->getResponse()->setTitle( 'Bienvenida/o' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="pantalla">
			<div class="titulo">BIENVENIDO/A <?php echo $usuario->getNombre(); ?>!</div>
						
			<div class="texto">
                <br />
                Acabamos de enviarte un e-mail de activación para validar tus datos.
                <br /><br />
                Puede que recibas éste mensaje en tu carpeta de correo no deseado.
                <br />
                En ese caso, agreganos como remitente seguro.
                <br /><br />
                <a class="color-link" href="<?php echo url_for('homepage')?>">Seguir recorriendo el sitio</a>
			</div>
		</div>
	</div>
</section>

<script>
	// Facebook Ads
	$(document).ready( function() {
		setTimeout(function(){
			if ( window._fbq ) { window._fbq('track', 'CompleteRegistration'); }
		}, 1000);
	} );
</script>