<?php $url = 'http://' . $eshop->getDominio() . url_for('activar_cuenta', $usuario) . '?referrer=' . $referrer; ?>
<?php include_partial('mails/header', array('eshop' => $eshop, 'title' => $title) ) ?>

<p>
    Est&aacute;s a un paso de poder disfrutar la colección nueva de <?php echo $eshop->getDenominacion(); ?>.
    <br /><br />
    Para poder <strong>activar tu cuenta</strong> hace <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="<?php echo $url; ?>">click aqu&iacute;.</a>
    <br /><br />
    En caso de no poder abrir el link, copi&aacute; el siguiente texto en tu navegador:
    <br />
    <a style="color:<?php echo $eshop->getLinkColor(); ?>; font-weight: bold;" href="<?php echo $url; ?>"><?php echo $url; ?></a>
</p>

<?php echo include_partial('mails/footer', array('eshop' => $eshop) ) ?>