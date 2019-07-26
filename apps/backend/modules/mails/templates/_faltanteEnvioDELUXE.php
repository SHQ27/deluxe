<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    <?php if ( count( $pedido->getPedidoProductoItem() ) > 1 ): ?>
    Te informamos que enviamos tu pedido #<?php echo $pedido->getIdPedido(); ?> con un faltante de:
    <?php else: ?>
    Te informamos que no enviamos tu pedido #<?php echo $pedido->getIdPedido(); ?> por existir un faltante de:
    <?php endif; ?>
    <br /><br />
    <?php echo $productoItem->getProducto()->getDenominacion(); ?> (<?php echo $cantidad; ?> u.) 
    <br />
    <strong>Talle:</strong> <?php echo $productoItem->getProductoTalle()->getDenominacion(); ?>
    <br />
    <strong>Color:</strong> <?php echo $productoItem->getProductoColor()->getDenominacion(); ?>).
    <br /><br />
    <?php echo $mensaje; ?>
    <br /><br />
    
    <?php if ($pedido->getIdFormaPago() == formaPago::MERCADOLIBRE): ?>
    Por este motivo, realizamos el reintegro de dinero a través de MercadoPago.
    <br /><br />
    Desde ya te pedimos disculpas por las molestias ocasionadas.
    <?php else: ?>
	Por este motivo, te pedimos que elijas una de las siguientes opciones haciendo click en una de ellas:
	<br/><br />
	<a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host'); ?>/faltante/<?php echo $faltante->getIdFaltante(); ?>">Dejar el crédito a favor en Deluxebuys para realizar otra compra</a>
	<br />
	o
	<br />
	<a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host'); ?>/consultas">Realizar la devolución de dinero a través de MercadoPago a través de nuestro canal de atención al cliente</a>
    <br /><br />
    Desde ya te pedimos disculpas por las molestias ocasionadas y quedamos a la espera de tu respuesta.
    <?php endif; ?>
</p>

<?php echo include_partial('mails/footer'); ?>