<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong>Te queríamos comentar que tu campaña ya se encuentra online.</strong>
    <br /><br />
    Previamente queríamos recordarte que toda la mercadería que se ha puesto a la venta es la que la marca se ha comprometido y no podemos tener faltantes luego de finalizada la venta.
    <br /><br />
	Para esto te pedimos que la mercadería que nos dieron para vender sea separada y dejada de lado a Deluxebuys.
	<br/><br/>
    <strong>Te enviamos los datos de acceso para que puedas ver en directo
    <br/>
    la venta de la campaña "<?php echo $campana->getDenominacion(); ?>"</strong>
    <br /><br />
	Podrás hacer el seguimiento ingresando a <a style="color:#FD7977;" href="http://www.deluxebuys.com/backend">www.deluxebuys.com/backend</a> con los siguientes datos de acceso:
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usuario: <?php echo $usuario; ?>
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password: <?php echo $password; ?>
</p>

<?php echo include_partial('mails/footer'); ?>