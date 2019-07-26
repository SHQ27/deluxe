<?php if ( $error ): ?>
<?php sfContext::getInstance()->getResponse()->setTitle( 'Faltante - No hemos podido dar curso al proceso de faltante' ); ?>
<?php else: ?>
<?php sfContext::getInstance()->getResponse()->setTitle( 'Faltante - Generación de crédito a favor' ); ?>
<?php endif; ?>

<div class="estatica">

	<?php if ( $error ): ?>
	<h1>No hemos podido dar curso al proceso de faltante</h1>
	
	<p>
		<?php echo html_entity_decode($error); ?>
	</p>
	
	<?php else: ?>
	
	
    <h1>¡Hemos generado un credito a tu favor!</h1>

    <p>
		Dejamos $<?php echo formatHelper::getInstance()->decimalNumber( $valor ) ?> a tu favor en tu cuenta. Que podés utilizar para comprar lo que mas te guste en nuestro sitio.
    </p>
    
    <a class="button "href="<?php echo url_for('homepage')?>">Seguir recorriendo el sitio</a>
    
    <p>
		Muchas gracias.
    </p>
    
	<?php endif; ?>
	
    
	<p class="pie">
		deluxebuys.com
		<br/>
		Shopping Online de Moda
	<p>	
	
</div>