<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />

	Te informamos que se ha procesado correctamente tu pago del pedido <strong>#<?php echo $pedido->getIdPedido() ?></strong>
	<br />
	Una vez enviado, recibirás un mail con las indicaciones para poder ver online el estado del pedido de entrega.
	<br /><br />
	<strong>DETALLE DE TU PEDIDO</strong>
</p>	
	
<table style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; line-height: 25px;" width="550px" cellpadding="10" cellspacing="0" border="0">
	<thead>
		<tr>
			<th style="border-bottom: solid #ccc 1px;" align="left">Producto</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Talle</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Color</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Cantidad</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">$</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($pedido->getPedidoProductoItem() as $pedidoProductoItem): ?>
		<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
		<tr>
    		<td style="border-bottom: solid #ccc 1px;" align="left"><?php echo $producto->getDenominacion(); ?></td>
    		<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?></td>
    		<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?></td>
    		<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $pedidoProductoItem->getCantidad(); ?>u.</td>
    		<td style="border-bottom: solid #ccc 1px;" align="center">$<?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() * $pedidoProductoItem->getCantidad() ); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<p>	
	<?php if ( (int) $pedido->getMontoBonificacion() ): ?>
	<strong>Bonificaciones:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoBonificacion() ); ?>
	<br/>
	<?php endif; ?>
	<?php if ( (int) $pedido->getMontoDescuento() ): ?>
	<strong>Descuentos:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoDescuento() ); ?>
	<br/>
	<?php endif; ?>
	<strong>Costo de envío:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoEnvio() ); ?>
	<br/>
	<strong>Total:</strong> $<?php echo formatHelper::getInstance()->decimalNumber( $pedido->getMontoTotal() ); ?>

    <br /><br />


	<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

    <strong>EL PEDIDO SERA ENTREGADO EN:</strong>
    <br />
	<?php if ($envioDetalle['tipo'] == CarritoEnvio::SUCURSAL): ?>
		Sucursal <?php echo $envioDetalle['sucursal']; ?>
		<br />
		<?php echo $envioDetalle['direccion']; ?>
		<br />
		<?php echo $envioDetalle['localidad']; ?>
		<br />
		<?php echo $envioDetalle['provincia']; ?>
		<br />
    	<br />
		Horarios: <?php echo $envioDetalle['horario']; ?>
	<?php else:?>
		<?php echo $envioDetalle['direccion']; ?>
		<br />
		<?php echo $envioDetalle['localidad']; ?>, <?php echo $envioDetalle['codigo_postal']; ?>
		<br />
		<?php echo $envioDetalle['provincia']; ?>
	<?php endif;?>
	
</p>

<?php echo include_partial('mails/footer'); ?>    