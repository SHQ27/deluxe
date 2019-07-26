<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
	<strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
	Tu factura correspondiente a tu pedido #<?php echo $pedido->getIdPedido(); ?> ya está disponible y la podes descargar accediendo a <a style="color:#FD7977;" href="http://www.deluxebuys.com/mi-cuenta/pedidos">Mi Cuenta / Pedidos</a>
    <br /><br />
	En caso de requerir facturas con fecha previa te pedimos que te contactes con Atención al Cliente por medio de slguiente link <a style="color:#FD7977;" href="http://www.deluxebuys.com/consultas">www.deluxebuys.com/consultas</a>
</p>

<?php echo include_partial('mails/footer'); ?>