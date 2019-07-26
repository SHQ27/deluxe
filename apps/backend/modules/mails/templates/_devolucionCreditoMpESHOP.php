<?php include_partial('mails/headerESHOP', array('eshop' => $eshop, 'title' => $title) )?>
	
<p>
    <strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
    <br /><br />
    Te confirmo que procedimos a reintegrar el dinero.
    <br /><br />
    <?php echo $texto; ?>
    <br /><br />
	Ante cualquier consulta estamos a tu disposición.
</p>

<?php echo include_partial('mails/footerESHOP', array('eshop' => $eshop) ) ?>