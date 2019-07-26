<?php sfContext::getInstance()->getResponse()->setTitle( 'Tu pedido ha sido dado de baja' ); ?>

<div class="estatica">

	<h1>¡Tu pedido ha sido dado de baja!</h1>
	
    <p>
        Ya no recibirás el recordatorio de pago por tu pedido, ya que el mismo ha sido dado de baja.
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