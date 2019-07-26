<?php $url = sfConfig::get('app_host') . url_for('activar_cuenta', $usuario) . '?referrer=' . $referrer; ?>
<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
	<strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Hemos modificado tu dirección de Email.
    <br /><br />
    Antes de continuar utilizando DeluxeBuys es necesario que hagas <a style="color:#FD7977;" href="<?php echo $url; ?>">click aqu&iacute;</a> para confirmar la operación y reactivar tu cuenta.
    <br /><br />
    En caso de no poder abrir el link, copi&aacute; el siguiente texto en tu navegador:
    <br />
    <a style="color:#FD7977;" href="<?php echo $url; ?>"><?php echo $url; ?></a>
</p>

<?php echo include_partial('mails/footer'); ?>