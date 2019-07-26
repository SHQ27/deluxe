<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Te confirmo que procedimos a reintegrar el dinero.
    <br /><br />
    <?php echo $texto; ?>
    <br /><br />
	Ante cualquier consulta estamos a tu disposición.
</p>

<?php echo include_partial('mails/footer'); ?>