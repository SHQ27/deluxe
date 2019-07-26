<?php $pedido = $devuelto_oca->getPedido(); ?>
<?php echo $pedido->getUsuario()->getNombre() ?>
<br/>
<?php echo $pedido->getUsuario()->getApellido() ?>
<br/>
<?php echo $pedido->getUsuario()->getEmail() ?>