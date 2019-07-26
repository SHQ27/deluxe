<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
	<strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
	Te contamos que ya se encuentra disponible el crédito correspondiente a la promoción de la compra <strong>#<?php echo $idPedido; ?></strong>.
    <br /><br />
    Utilizarla es muy fácil, una vez que estés en el paso 3 de la compra, tenés que hacer clic en el casillero "bonificaciones" y al desplegarse vas a poder visualizar el importe; el mismo se va a restar del monto total de tu pedido.

</p>

<?php echo include_partial('mails/footer'); ?>