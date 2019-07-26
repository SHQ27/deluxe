<?php sfContext::getInstance()->getResponse()->setTitle('Ya estas suscripto a nuestro newsletter'); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="pantalla">
			<div class="titulo MS-23">¡YA ESTÁS SUSCRIPTO/A A NUESTRO NEWSLETTER!</div>
						
			<div class="texto OS-11 color4 lh18 text-center">
			    <br />
                Preparate para recibir las mejores ofertas
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
			if ( window._fbq ) { window._fbq('track', 'Lead'); }
		}, 1000);
	} );
</script>