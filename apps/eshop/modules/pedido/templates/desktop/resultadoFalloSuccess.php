<?php sfContext::getInstance()->getResponse()->setTitle( 'Tu compra no se pudo realizar' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="pantalla">
			<div class="titulo MS-23">¡LA COMPRA NO SE PUDO REALIZAR!</div>
						
			<div class="texto OS-11 color4 lh18 text-center">
                <br />
        		Por algún inconveniente en el proceso de pago, se ha cancelado la operación.
        		<br/><br/>
        		Puedes volver a intentar la compra, seleccionar otra forma de pago, o comunicarte con nuestro 
        		<br />
        		centro de atención al cliente completando nuestro <a class="color-link" href="<?php echo url_for('consultas')?>">formulario de contacto</a>
			</div>
		</div>
	</div>
</section>