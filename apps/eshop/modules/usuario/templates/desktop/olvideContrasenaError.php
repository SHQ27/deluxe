<?php sfContext::getInstance()->getResponse()->setTitle( '¿Olvidaste tu contraseña?' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="pantalla">
			<div class="titulo MS-23">¿OLVIDASTE TU CONTRASEÑA?</div>
						
			<div class="texto OS-11 color4 lh18 text-center">
			    <br />
                No existe un usuario para el email ingresado.
                <br />
                Si estas segura/o que el email es correcto <a class="color-link" href="<?php echo url_for('consultas'); ?>">comunicate con nosotros.</a>
			</div>
			
		</div>
	</div>
</section>