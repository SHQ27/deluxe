<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
	Te informamos que tenemos tu pedido #<?php echo $pedido->getIdPedido(); ?> en nuestras oficinas, y podemos enviártelo nuevamente contrarreembolso a la sucursal o domicilio que nos confirmes.
	<br/><br/>
	Es importante que tengas presente que el pedido estará disponible durante el plazo de 30 días a partir de la fecha en la que te notificamos vía mail.
	<br/><br/>
	Quedamos a la espera de tu respuesta.
</p>

<?php echo include_partial('mails/footer'); ?>
