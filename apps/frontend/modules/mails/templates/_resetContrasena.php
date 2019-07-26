<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
	<strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Has solicitado una nueva contrase&ntilde;a para acceder como socio a Deluxebuys.
    <br />
    Tu nueva contrase&ntilde;a es: <strong><?php echo $password ?></strong>
	<br /><br />
	Ingres&aacute; a Deluxebuys para poder aprovechar nuestras ofertas haciendo <a style="color:#FD7977;" href='http://www.deluxebuys.com' target='_blank'>click aqu&iacute;</a>
	<br />
    Record&aacute; que pod&eacute;s modificar tu contrase&ntilde;a desde <a style="color:#FD7977;" href='http://www.deluxebuys.com/mi-cuenta' target='_blank'>mi cuenta</a>
</p>

<?php echo include_partial('mails/footer'); ?>