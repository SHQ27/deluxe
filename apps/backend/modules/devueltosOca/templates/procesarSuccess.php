<div id="sf_admin_container" class="devueltosOca">
    
    <h1>Devueltos por OCA</h1>
            
	<?php if ( !isset($mailsEnviados) ): ?>           
	            
		<?php if ( isset($pedidos) && count($pedidos) ): ?>
	   <form class="formProcesar" method="post">
	   
	    	<?php echo $form['_csrf_token']; ?>
		    
		    <table>
		    	<thead>
		    		<tr>
		    			<th width="16"><input type="checkbox" id="procesarDevueltosOca_selectAll" /> </th>
		    			<th width="65">Id Pedido</th>
		    			<th width="300">Usuario</th>
		    			<th width="55">$ Total</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    	<?php $i = 0; ?>
		    	<?php foreach ($pedidos as $pedido): ?>
		    		<tr>
		    			<td><?php echo $form['id_pedido']->render( array('name' => 'procesarDevueltosOca[id_pedido][' . $i . ']', 'value' => $pedido->getIdPedido() ) ); ?></td>
		    			<td>
		    				<a target="_blank" href="/backend/pedidos/<?php echo $pedido->getIdPedido(); ?>/ListView"><?php echo $pedido->getIdPedido(); ?></a>
		    			</td>
		    			<td>
							<?php echo $pedido->getUsuario()->getNombre() ?>
							<br/>
							<?php echo $pedido->getUsuario()->getApellido() ?>
							<br/>
							<?php echo $pedido->getUsuario()->getEmail() ?>
						</td>
						<td><?php echo $pedido->getMontoTotal(); ?></td>				
					</tr>
					<?php $i++; ?>
		    	<?php endforeach; ?>
		    	</tbody>
		    </table>
		    
	        <input class="button" type="submit" value="Enviar mail de aviso al cliente" />        
	    </form>
	    
	    <?php else: ?>
	    <strong>Ninguno de los códigos de envio coincide con algun pedido en Deluxe Buys</strong>
	    
	    <?php endif; ?>
    
    <?php else: ?>
    	<strong>El proceso finalizo correctamente</strong>
    	<br/><br/>
    	Se enviaron <?php echo $mailsEnviados?> emails dando aviso a los clientes sobre la devolucion de su pedido
    	<br/>
    	por parte de OCA a las oficina de DeluxeBuys. 
    <?php endif; ?>
    
</div>