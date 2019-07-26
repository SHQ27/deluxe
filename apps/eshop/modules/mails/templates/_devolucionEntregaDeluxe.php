<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<p>
	<strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
    <br /><br />
	Para realizar la devolución podés venir de lunes a viernes de 9.30 a 13 y de 14.30 a 17 horas a Guatemala 4551 (Portería).
    <br /><br />
	Tenés que traer el producto con el embalaje donde lo recibiste y este formulario completo, el cual podras descargar haciendo <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="<?php echo sfConfig::get('app_host_static'); ?>/resources/<?php echo $fileForm; ?>">click aquí</a>.
    <br /><br />
	¡Te esperamos!

</p>

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>