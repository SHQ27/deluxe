<div id="sf_admin_container" class="prepararEnvio">
    
	<script>
		var mostrarPreFiltro = <?php echo ( $mostrarPreFiltro ) ? 'true' : 'false'; ?>;
		var marcaIngresoMercaderia = '<?php echo ( $marca ) ? $marca->getNombre() : ''; ?>';
	</script>

    <h1>Preparar Envio</h1>
        

    <p class="filtrado">
    	<strong>Ya hay pedidos listos para despachar:</strong>
    	<br/>
    	<span>Previamente, tenes que indicar algunas de las 3 opciones</span>
    	<br/><br/><br/>
    	<a class="unicaMarca">1) Quiero despachar pedidos que tengan únicamente la marca ingresada<br>(serían pedidos que contengan solamente la marca ingresada y no están combinados)</a>
    	<br/><br/><br/>
    	<a class="distintasMarca">2) Quiero despachar pedidos de la marca ingresada y que se combinen con otras.</a>
    	<br/><br/><br/>
    	<a class="todos">3) Quiero despachar todos los pedidos de la campaña que esten listos para envio.</a>
    	<br/><br/><br/>
    	<a href="<?php echo url_for('campanas_logistica'); ?>">4) Regresar al panel de logistica, sin proceder al envio.</a>
    </p>


	<form method="post">
	
		<?php echo $form['_csrf_token']; ?>

		<p class="avisoEshop">
		  Este envío se realizará via los correos seleccionados, para el eshop de <strong><?php echo $eshopNombre; ?></strong>
     	</p>
    
	 	<table>
	 		<thead>
	 			<tr>
	   				<th><input type="checkbox" id="prepararEnvio_selectAll" /> </th>
	    			<th>Id Pedido</th>
	    			<th>Tipo de Envío</th>
	    			<th>Cliente</th>
	    			<th>Calle</th>
	    			<th>Nº</th>
	    			<th>Piso</th>
	    			<th>Dpto</th>
	    			<th>C.P.</th>
	    			<th>Provincia</th>
	    			<th>Localidad</th>
	    			<th>Teléfono</th>
	    			<th>Correo</th>
	    			<th>Marca/s</th>
	    		</tr>
	    		</thead>
	    		<tbody>
	    		<?php $pedidos = ( isset($result['pedidos']) ) ? $result['pedidos'] : $pedidos; ?>
	    		
	    		<?php foreach ( $pedidos as $pedido ): ?>
	    		<?php $i = $pedido->getIdPedido(); ?>
	    		<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>
	    		<tr>
	    			<td><?php echo $form['id_pedido']->render( array('name' => 'prepararEnvio[id_pedido][' . $i . ']', 'value' => $pedido->getIdPedido() ) ); ?></td>
	    			<td><?php echo $pedido->getIdPedido() ?></td>
					<td>
						<?php if( $pedido->getEnvioTipo() == carritoEnvio::SUCURSAL ):?>
						Suc.: <?php echo $envioDetalle['sucursal'] ?>
						<?php else:?>
						A Domicilio
						<?php endif;?>
	    			</td>
	    			<td>
	    				<?php echo $envioDetalle['destinatario'] ?>
	    			</td>
	    			
	    			<?php if ($pedido->getEnvioTipo() == carritoEnvio::SUCURSAL): ?>
	    			<td class="calle" colspan="5"><?php echo $envioDetalle['direccion'] ?></td>
    				<?php else: ?>
	    			<td class="calle"><?php echo $form['calle']->render( array( 'name' => 'prepararEnvio[calle][' . $i . ']', 'value' => $pedido->getEnvioCalle() ) ); ?></td>
	    			<td class="numero"><?php echo $form['numero']->render( array( 'name' => 'prepararEnvio[numero][' . $i . ']', 'value' => $pedido->getEnvioNumero() ) ); ?></td>
	    			<td class="piso"><?php echo $form['piso']->render( array( 'name' => 'prepararEnvio[piso][' . $i . ']', 'value' => $pedido->getEnvioPiso() ) ); ?></td>
	    			<td class="dpto"><?php echo $form['dpto']->render( array( 'name' => 'prepararEnvio[dpto][' . $i . ']', 'value' => $pedido->getEnvioDepto() ) ); ?></td>
	    			<td class="cp"><?php echo $form['cp']->render( array( 'name' => 'prepararEnvio[cp][' . $i . ']', 'value' => $pedido->getEnvioCodigoPostal() ) ); ?></td>
    				<?php endif; ?>
	    			
	    			<td><?php echo $envioDetalle['provincia'] ?></td>
					<td><?php echo $envioDetalle['localidad'] ?></td>
	    			<td class="telefono"><?php echo $form['telefono']->render( array( 'name' => 'prepararEnvio[telefono][' . $i . ']', 'value' => $pedido->getTelefono() ) ); ?></td>
	    			<td class="center">
	    				<img src="<?php echo sfConfig::get('app_host_static'); ?>/images/enviopack/<?php echo $envioDetalle['correo']; ?>.png"/>
	    			</td>
	    			<td class="marcas"><?php echo implode(', ', $pedido->getMarcas()->getRawValue()) ?></td>
	    		</tr>
	    		<?php endforeach; ?>
	    	</tbody>
	    </table>
	    
	    <input class="button" type="submit" value="Enviar" />
	</form>
    
</div>