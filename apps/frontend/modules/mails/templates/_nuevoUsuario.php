<?php $url = sfConfig::get('app_host') . url_for('activar_cuenta', $usuario) . '?referrer=' . $referrer; ?>
<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Est&aacute;s a un paso de poder comenzar a comprar las mejores ofertas en moda y tendencia en Deluxebuys.
    <br /><br />
    Para poder <strong>activar tu cuenta</strong> hace <a style="color:#FD7977;" href="<?php echo $url; ?>">click aqu&iacute;.</a>
    <br /><br />
    En caso de no poder abrir el link, copi&aacute; el siguiente texto en tu navegador:
    <br />
    <a style="color:#FD7977;" href="<?php echo $url; ?>"><?php echo $url; ?></a>
</p>

<?php echo include_partial('mails/footer'); ?>