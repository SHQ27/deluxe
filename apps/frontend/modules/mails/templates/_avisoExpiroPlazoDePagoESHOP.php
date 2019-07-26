<?php include_partial('mails/headerESHOP', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<p>
	<strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
    <br /><br />
	Te informamos que finalizó el período de pago de tu pedido #<?php echo $pedido->getIdPedido(); ?> dándose de baja el mismo.
    <br /><br />
    Si pagaste tu pedido y se acreditó desestima este mail, de lo contrario para recibir la devolución de tu dinero deberás contactarnos desde el formulario de consultas <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="http://<?php echo $eshop->getDominio(); ?>/consultas"><?php echo $eshop->getDominio(); ?>/consultas</a>
    <br /><br />
	Es muy importante que para la próxima vez tengas en cuenta que los pagos deben realizarse 48 hs antes que finalice la oferta, tal como se indica en la descripción del producto y en el mail de la confirmación de la compra.
    <br /><br />
	Cualquier consulta podes dirigirte al formulario de contacto <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="http://<?php echo $eshop->getDominio(); ?>/consultas"><?php echo $eshop->getDominio(); ?>/consultas</a>

</p>

<?php echo include_partial('mails/footerESHOP', array('eshop' => $eshop) ) ?>