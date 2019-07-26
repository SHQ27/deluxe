<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Recibimos tu pedido <strong>#<?php echo $pedido->getIdPedido() ?></strong>!
    <br /><br />
    Hemos detectado que seleccionaste Pago Fácil, RapiPago, Banelco o Red Link para realizar el pago.
    <br /><br />
	Es muy importante que <strong>realices tu pago antes del día <?php echo $pedido->getFechaLimiteConTolerancia('d/m/Y') ?></strong>, de lo contrario no podremos asegurarte el stock de tu pedido y el mismo se dará de baja automáticamente.
	<br /><br />
	Si la mencionada fecha ya ha pasado, por favor realiza nuevamente tu pedido, seleccionando como forma de pago Tarjeta de crédito.
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
			<th style="border-bottom: solid #ccc 1px;" align="center">Cantidad</th>
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

<?php $envioDetalle = $pedido->getArrayEnvioDetalle(); ?>

<p>	
    <br />
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

<p>	
	<br />
	Cualquier consulta que tengas podes dirigirte al formulario de contacto que se encuentra en <a style="color:#FD7977;" href="http://www.deluxebuys.com/consultas">www.deluxebuys.com/consultas</a>
	<br /><br />
	<strong>Muchas Gracias por tu compra!</strong>
</p>

<?php echo include_partial('mails/footer'); ?>