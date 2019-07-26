<?php sfContext::getInstance()->getResponse()->setTitle( 'No hay stock para recuperar tu carrito' ); ?>

<div class="estatica">

    <h1>Se agotó el stock para tu carrito</h1>

    <p>
		Intentamos recuperar tu carrito, pero en este momento no hay stock disponible<br />para ninguno de los productos agregados.
    </p>
    
    <a class="button "href="<?php echo url_for('homepage')?>">Seguir recorriendo el sitio</a>
    
    <p>
		Muchas gracias.
    </p>	
    
	<p class="pie">
		deluxebuys.com
		<br/>
		Shopping Online de Moda
	<p>	
	
</div>