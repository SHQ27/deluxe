<?php sfContext::getInstance()->getResponse()->setTitle( 'Tu compra no se pudo realizar' ); ?>

<div class="estatica">

	<h1>¡La compra no se pudo realizar!</h1>
	

    <p>
		Por algún inconveniente en el proceso de pago, se ha cancelado la operación.
		<br/><br/>
		Puedes volver a intentar la compra, seleccionar otra forma de pago, o comunicarte con nuestro centro de atención al cliente
		completando nuestro <a href="<?php echo url_for('consultas')?>">formulario de contacto</a>
    </p>
        
    <p>
		Muchas gracias.
    </p>
    
	
	<p class="pie">
		deluxebuys.com
		<br/>
		Shopping Online de Moda
	<p>	
	
</div>