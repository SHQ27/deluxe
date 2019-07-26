<div id="sf_admin_container" class="prepararEnvio">
    
    <h1>Preparar Envio</h1>

    <?php if ( !$enviado ): ?>
    
	<form method="post">
	
		<?php echo $form['_csrf_token']; ?>
		    
	 	<table>
	 		<thead>
	 			<tr>
	    			<th>Cliente</th>
	    			<th>Calle</th>
	    			<th>Nº</th>
	    			<th>Piso</th>
	    			<th>Dpto</th>
	    			<th>C.P.</th>
	    			<th>Provincia</th>
	    			<th>Localidad</th>
	    			<th>Teléfono</th>
	    		</tr>
	    		</thead>
	    		<tbody>
	    		
	    		<tr>
	    			<td>
	    				<?php echo $devolucion->getNombre() ?>
	    				<br/>
	    				<?php echo $devolucion->getApellido() ?>
	    			</td>	    			
	    			<td class="calle"><?php echo $form['calle']->render( array( 'name' => 'devolucionEnvio[calle]', 'value' => $devolucion->getCalle() ) ); ?></td>
	    			<td class="numero"><?php echo $form['numero']->render( array( 'name' => 'devolucionEnvio[numero]', 'value' => $devolucion->getNumero() ) ); ?></td>
	    			<td class="piso"><?php echo $form['piso']->render( array( 'name' => 'devolucionEnvio[piso]', 'value' => $devolucion->getPiso() ) ); ?></td>
	    			<td class="dpto"><?php echo $form['dpto']->render( array( 'name' => 'devolucionEnvio[dpto]', 'value' => $devolucion->getDpto() ) ); ?></td>
	    			<td class="cp"><?php echo $form['cp']->render( array( 'name' => 'devolucionEnvio[cp]', 'value' => $devolucion->getCodigoPostal() ) ); ?></td>
	    			<td class="provincia" rel="<?php echo $devolucion->getIdProvincia(); ?>"><?php echo $form['provincia']->render( array( 'name' => 'devolucionEnvio[provincia]') ); ?></td>
	    			<td class="localidad" rel="<?php echo $devolucion->getLocalidad(); ?>"><?php echo $form['localidad']->render( array( 'name' => 'devolucionEnvio[localidad]', 'value' => $devolucion->getLocalidad()) ); ?></td>
					<td class="telefono"><?php echo $devolucion->getUsuario()->getTelefono() ?></td>
	    		</tr>
	    	</tbody>
	    </table>
	    
	    <input type="submit" value="Enviar a OCA" />
	</form>
	
	<?php else: ?>
		
		<?php if ( $status ): ?>
		<p>
			Se envió correctamente la información al correo
			<br/><br/>
			<a href="/backend/devoluciones">Regresar al listado de devoluciones</a>
			
		</p>
		<?php else: ?>
		<p>
			Se produjo un error al procesar la solicitud.
			<br/><br/>
			<small>Momentáneamente te pedimos que te comuniques con soporte para solucionar el problema.</small>
			<br/><br/>
			Detalle del Error:
			<pre>
				<?php echo json_encode($responseEP); ?>	
			</pre>
		</p>
		<?php endif; ?>
	<?php endif; ?>
    
</div>