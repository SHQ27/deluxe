<?php sfContext::getInstance()->getResponse()->setTitle( 'Tu compra ha sido exitosa' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="pantalla">
			<div class="titulo">¡TU COMPRA HA SIDO EXITOSA!</div>
						
			<div class="texto">
                <br />
                Te hemos enviado a tu mail un detalle del pedido con el número de orden.
                <br />
                En él encontrarás toda la información necesaria para realizar el seguimiento del pedido.
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
			if ( window._fbq ) { window._fbq('track', 'Purchase', {value: '<?php echo $pedido->getMontoTotal(); ?>', currency:'ARS'}); }
		}, 1000);
	} );
</script>