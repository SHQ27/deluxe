<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<p>
	<strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
    <br /><br />
    Has solicitado una nueva contrase&ntilde;a para acceder como socio al eShop de <?php echo $eshop->getDenominacion(); ?>.
    <br />
    Tu nueva contrase&ntilde;a es: <strong><?php echo $password ?></strong>
	<br /><br />
	Ingres&aacute; al eShop para poder aprovechar nuestras ofertas haciendo <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href='http://<?php echo $eshop->getDominio(); ?>' target='_blank'>click aqu&iacute;</a>
	<br />
    Record&aacute; que pod&eacute;s modificar tu contrase&ntilde;a desde <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href='http://<?php echo $eshop->getDominio(); ?>/mi-cuenta' target='_blank'>mi cuenta</a>
</p>

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>