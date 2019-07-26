<?php if ( $error ): ?>
	<?php sfContext::getInstance()->getResponse()->setTitle( 'Devoluciones - Impresión de etiqueta' ); ?>

	<section id="estatica" class="seccion blanco">
		<div class="container">
			<div class="linea"><div class="triangulos"></div></div>
			<div class="pantalla">
				<div class="titulo MS-23">¡HA OCURRIDO UN PROBLEMA</div>
							
				<div class="texto OS-11 color4 lh18 text-center">
					Verificá no haber modificado la URL recibida por email, en caso de persistir el problema
					<br/>
					comunícate con nosotros desde el <a class="color-link" href="<?php echo url_for('consultas')?>">formulario de consultas</a>.
				</div>
				
			</div>
		</div>
	</section>

<?php else: ?>

	<style>
	p {
	  font-size: 15px;
	  font-family: sans-serif;
	  font-style: normal;
	  text-align: center;
	}

	a {
	  color: <?php echo $linkColor; ?>;
	  text-decoration: none;
	}

	a:hover {
	  text-decoration: underline;
	}

	</style>

	<p style='margin: 40px 0 0 0;'>
		<a href="javascript:window.print()">
			Hace click aqui para Imprimir la etiqueta
			<br/>
			y luego pegala en el paquete a devolver
		</a>
	</p>
	<img src="data:image/png;base64,<?php echo $etiqueta; ?>"/>

<?php endif; ?>	