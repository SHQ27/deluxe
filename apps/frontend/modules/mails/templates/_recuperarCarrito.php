<?php $url = sfConfig::get('app_host') . str_replace( $_SERVER['SCRIPT_NAME'], '', url_for('recuperar_carrito', array('hash' => $hash))) . '?source=emailmkt&utm_source=EmailMKT&utm_medium=Base&utm_campaign=Pendiente'; ?>
<?php include_partial('mails/header', array('title' => $title) )?>

<p>	
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />	
    Vimos que <strong>agregaste productos a tu carrito de compras</strong>, pero que por alguna razón no pudiste concretar el pago.
    <br /><br />
    <strong>Si querés retomar tu compra</strong> podes hacerlo haciendo <a style="color:#FD7977;" href="<?php echo $url; ?>">click aquí</a>.
    <br /><br />
    Recordá que tenes tiempo hasta el <?php echo date( 'd/m/Y H:i', strtotime($fechaLimite) ); ?> hs. que es cuando finaliza la oferta en donde compraste.
</p>	
	
<table style="font-family: Trebuchet MS, Helvetica, sans-serif; color: #333; font-size: 12px; line-height: 25px;" width="550px" cellpadding="10" cellspacing="0" border="0">
	<thead>
		<tr>
		    <th style="border-bottom: solid #ccc 1px;" align="left"></th>
			<th style="border-bottom: solid #ccc 1px;" align="left">Producto</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Talle</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Color</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Cantidad</th>
			<th style="border-bottom: solid #ccc 1px;" align="center">Cantidad</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($pedidoProductoItems as $pedidoProductoItem): ?>
		<?php $producto = $pedidoProductoItem->getProductoItem()->getProducto(); ?>
		<tr>
		    <td style="border-bottom: solid #ccc 1px;" align="left"><a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host') . str_replace( $_SERVER['SCRIPT_NAME'], '', $producto->getDetalleUrl()); ?>"><img src="<?php echo imageHelper::getInstance()->getUrl('producto_detalle_chica', $producto) ?>" style="border:1px solid #999999" border="0"/></a></td>
    		<td style="border-bottom: solid #ccc 1px;" align="left"><a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host') . str_replace( $_SERVER['SCRIPT_NAME'], '', $producto->getDetalleUrl()); ?>"><?php echo $producto->getDenominacion(); ?></a></td>
    		<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $pedidoProductoItem->getProductoTalle()->getDenominacion(); ?></td>
    		<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $pedidoProductoItem->getProductoColor()->getDenominacion(); ?></td>
    		<td style="border-bottom: solid #ccc 1px;" align="center"><?php echo $pedidoProductoItem->getCantidad(); ?>u.</td>
    		<td style="border-bottom: solid #ccc 1px;" align="center">$<?php echo formatHelper::getInstance()->decimalNumber( $pedidoProductoItem->getPrecioDeluxe() * $pedidoProductoItem->getCantidad() ); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<p style="text-align: center;">
    <br />
    <a href="<?php echo $url; ?>"><img src="<?php echo sfConfig::get('app_host_static'); ?>/images/button_recupero_carrito.png" border="0"/></a>
</p>

<p>
    <br /><br />
    Si ya la concretaste desestima este e-mail.
    <br /><br />
    Si tenés dudas podes contactarte con nuestro Centro de Atención al Cliente mediante nuestro <a style="color:#FD7977;" href="http://www.deluxebuys.com/consultas">formulario de contacto</a>.
</p>	


<?php echo include_partial('mails/footer'); ?>