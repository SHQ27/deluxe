<?php include_partial('mails/headerESHOP', array('eshop' => $eshop, 'title' => $title) )?>
	
<p>
    <strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
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
    
    Por este motivo, realizamos el reintegro de dinero a través de MercadoPago.
    <br /><br />
    Desde ya te pedimos disculpas por las molestias ocasionadas.
</p>

<?php echo include_partial('mails/footerESHOP', array('eshop' => $eshop) ) ?>