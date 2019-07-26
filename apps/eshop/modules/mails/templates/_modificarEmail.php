<?php $url = 'http://' . $eshop->getDominio() . url_for('activar_cuenta', $usuario) . '?referrer=' . $referrer; ?>
<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>
	
<p>
	<strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
    <br /><br />
    Hemos modificado tu dirección de Email.
    <br /><br />
    Antes de continuar utilizando el eShop de <?php echo $eshop->getDenominacion(); ?> es necesario que hagas <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="<?php echo $url; ?>">click aqu&iacute;</a> para confirmar la operación y reactivar tu cuenta.
    <br /><br />
    En caso de no poder abrir el link, copi&aacute; el siguiente texto en tu navegador:
    <br />
    <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="<?php echo $url; ?>"><?php echo $url; ?></a>
</p>

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>