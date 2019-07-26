<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Te damos la bienvenida a Deluxebuys! en donde vas a encontrar las mejores ofertas en moda y tendencia.
    <br /><br />
    <strong>Tu usuario es:</strong> <?php echo $usuario->getEmail(); ?>
    <br />
    <strong>Tu contraseña es:</strong> <?php echo $password; ?>
    <br />
    Importante: Podrás modificar tu contraseña ingresando a <a href="<?php echo sfConfig::get('app_host'); ?><?php echo url_for('mi_cuenta'); ?>">Mi Cuenta</a>. Aquí deberás ingresar tu contraseña actual y la nueva.
</p>

<?php echo include_partial('mails/footer'); ?>