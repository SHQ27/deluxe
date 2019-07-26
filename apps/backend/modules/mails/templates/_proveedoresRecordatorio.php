<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong>Te recordamos que está disponible el seguimiento de las ventas de la campaña "<?php echo $campana->getDenominacion(); ?>"</strong>
    <br /><br />
    Podés acceder al mismo con los datos de acceso que te enviamos previamente ingresando a <a style="color:#FD7977;" href="http://www.deluxebuys.com/backend">www.deluxebuys.com/backend</a>:
</p>

<?php echo include_partial('mails/footer'); ?>