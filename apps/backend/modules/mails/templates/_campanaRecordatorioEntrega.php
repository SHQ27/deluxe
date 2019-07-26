<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong>Hola!</strong>
    
    <br /><br />    
    
    Te  recordamos que la entrega aún está pendiente
    
    <br /><br />
    
    Para poder descargar las ventas o dejar de recibir este mail tenes que ingresar en el link a continuación y confirmar la fecha en que estarían entregando
    <br /> 
    <a style="color:#FD7977;" href="<?php echo sfConfig::get('app_host'); ?>/backend/ingresarFechaEntrega/<?php echo $hash; ?>"><?php echo sfConfig::get('app_host'); ?>/backend/ingresarFechaEntrega/<?php echo $hash; ?></a>
    
</p>

<?php echo include_partial('mails/footer', array('saludo' => 'MAXI')); ?>