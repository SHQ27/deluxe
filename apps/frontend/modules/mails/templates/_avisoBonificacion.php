<?php include_partial('mails/header', array('title' => $title) )?>

<p>
    Gracias por tu interés en formar parte de Deluxebuys. 

    <br />
    <br />

    <?php if ( $valor > 0 ): ?>
    Te regalamos un cupón* de <strong>$<?php echo $valor; ?></strong> para que comiences a comprar. Es muy simple de usar, <a style="color: #FD7977;" href="http://www.deluxebuys.com/usuario">registrate</a> y una vez que selecciones el producto que queres comprar al momento de confirmar tu pedido tendrás la opción de Bonificación y encontrarás el descuento mencionado.
    <br />
    <br />
    Seguinos en <a style="color: #FD7977;" href="http://www.facebook.com/pages/Deluxebuys/182338358315">Facebook</a> y <a style="color: #FD7977;" href="https://twitter.com/#!/Deluxebuys">Twitter</a>, y no te pierdas nuestro <a style="color: #FD7977;" href="http://deluxebuys.tumblr.com/">Blog</a> exclusivo!
    <br />
    <br />
    Hace <a style="color: #FD7977;" href="<?php echo sfConfig::get('app_host'); ?>/usuario">click aquí</a> para poder empezar a usar tu descuento.
    <br />
    <small>*Cupón válido por 15 días corrido.</small>
    <?php endif; ?>
</p>

<?php echo include_partial('mails/footer'); ?>