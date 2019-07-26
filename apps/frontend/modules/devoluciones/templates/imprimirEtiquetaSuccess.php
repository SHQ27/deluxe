<?php if ( $error ): ?>
	<?php sfContext::getInstance()->getResponse()->setTitle( 'Devoluciones - Impresión de etiqueta' ); ?>

	<div class="estatica">

		<h1>¡Ha ocurrido un problema!</h1>
		
		<p>
			Verificá no haber modificado la URL recibida por email, en caso de persistir el problema
			<br/><br/>
			comunícate con nosotros desde el <a href="<?php echo url_for('consultas')?>">formulario de consultas</a>.
		</p>
		
		<p class="pie">
			deluxebuys.com
			<br/>
			Shopping Online de Moda
		<p>	
		
	</div>

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