<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Recordá que tenes pendiente el pago de tu pedido #<strong><?php echo $pedido->getIdPedido() ?></strong>.
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
    Si ya abonaste tu pedido y recibiste este email, desestimá el recordatorio, el proceso de acreditación de tu pago puede demorarse hasta 48 hs y el sistema no se actualizó al momento de enviarte el recordatorio.
    <br /><br />				
    Si aún no abonaste tu pedido es muy importante que <strong>realices tu pago antes del día <?php echo $pedido->getFechaLimiteConTolerancia('d/m/Y') ?></strong>, una vez pasada esta fecha, tu carrito de compra se dará de baja y se liberarán los artículos seleccionados.
    <br /><br />
    Si cambiaste de opinion y ya no querés pagar tu pedido, por favor hacé <a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host') . '/pedido/aviso/' . $hash . '/bajaRecordatorioOffline'; ?>">click aquí</a>, de esta manera otros usuarios pueden disponer de los articulos que seleccionaste previamente.
	<br /><br />
	<strong>Muchas Gracias por tu compra!</strong>
</p>

<?php echo include_partial('mails/footer'); ?>
    