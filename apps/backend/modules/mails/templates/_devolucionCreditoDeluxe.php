<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Te confirmo que el saldo ya se encuentra acreditado en tu cuenta.
    <br /><br />
    El crédito es muy fácil de utilizar. Una vez que estés en el paso 3 de la compra, tenés que hacer clic en el casillero "bonificaciones" y al desplegarse vas  a visualizar el saldo disponible; este se va a restar de tu pedido.
    <br /><br />
	Ante cualquier consulta estamos a tu disposición.
</p>

<?php echo include_partial('mails/footer'); ?>