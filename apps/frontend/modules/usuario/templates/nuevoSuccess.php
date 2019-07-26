<?php sfContext::getInstance()->getResponse()->setTitle( 'Bienvenida/o a Deluxebuys' ); ?>

<div class="estatica">

	<h1>Hola <?php echo $usuario->getNombre(); ?>, <br />bienvenido a Deluxebuys</h1>
	
    <p>
        Estás a un paso de poder comenzar a comprar las mejores ofertas en moda y tendencia en Deluxebuys.
    </p>
    
    <p>
        Acabamos de enviarte un e-mail de activación para validar tus datos.
    </p>
    
    <p>
        Puede que recibas éste mensaje en tu carpeta de correo no deseado.
        <br />
        En ese caso, agregá a deluxebuys.com como remitente seguro.
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