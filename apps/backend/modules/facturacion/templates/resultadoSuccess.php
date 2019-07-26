<div id="sf_admin_container" class="facturacionResultado">
	<h1>Facturación - Resultado</h1>
		
    <?php $facturas = sfContext::getInstance()->getUser()->getFlash('result_facturacion'); ?>
    
    <table>
        <tr>
         	<th>Id pedido</th>
         	<th>Datos cliente</th>
         	<th>Forma pago</th>
         	<th>$ Total</th>
         	<th>Resultado</th>
        </tr>
    
    <?php foreach ( $facturas as $factura ): ?>
        <?php $pedido = $factura->getPedido(); ?>
        <tr>
         	<td>
         	    <a href="/backend/pedidos/<?php echo $pedido->getIdPedido(); ?>/ListView" target="_blank"><?php echo $pedido->getIdPedido(); ?></a>
         	</td>
         	<td>
                <?php echo $pedido->getUsuario()->getNombre() ?>
                <br/>
                <?php echo $pedido->getUsuario()->getApellido() ?>
                <br/>
                <?php echo $pedido->getUsuario()->getEmail() ?>
         	</td>
         	<td>
         	    <?php echo $pedido->getDescripcionFormaPago(); ?>
         	</td>
         	<td>
         	    <?php echo $pedido->getMontoTotal(); ?>
         	</td>
         	<td>
         	    <?php if ( $factura->getProcesada() && $factura->getResultado() == 'A' ): ?>
         	        <span class="ok_<?php echo $factura->getEntorno(); ?>">OK (<?php echo $factura->getEntorno(); ?>)</span>
         	    <?php else:?>
         	        <span class="ko">Fallo</span>
         	    <?php endif;?>
         	</td>
        </tr>
    <?php endforeach; ?>
        
    </table>
    
    <p>
        <a href="<?php echo url_for('facturacion'); ?>">Volver al listado de facturacion</a>
    </p>
	
</div>