<?php include_partial('mails/header', array('title' => $title) ) ?>
	
<p>
    <strong style="text-transform: uppercase;">Hola <?php echo $usuario->getNombre(); ?> ¿Cómo estás?</strong>
    <br /><br />
    Tu pedido <strong><?php echo $pedido->getIdPedido() ?></strong> ya fue enviado!
    <br />
    El número de ruta es <?php echo $pedido->getCodigoEnvio() ?>
    <br /><br />
    Podrás chequear el estado de tu pedido ingresando a <a style="color:#FD7977;" href='http://www.deluxebuys.com/mi-cuenta/consulta-tu-envio'>Mi Cuenta</a>
    <br /><br />
    Recordá que puede demorar hasta 24 horas para que la información de tu pedido esté online.
    <br /><br />
    
    <strong>*** Consideraciones sobre la Política de entrega de Deluxebuys ***</strong> 
    <br />
    - Se hacen 2 intentos para poder entregar el pedido, pero sí la entrega continúa sin éxito, el pedido retornará al Centro de Distribución de Deluxebuys . Para un nuevo intento será cobrado el valor del flete. 
    <br />
    - La entrega del Producto puede ser para terceros, parientes o porteros del edificio, mientras que estén debidamente autorizados por el comprador para recibir el pedido. 
    <br />
    - Nuestras transportadoras no están autorizadas para abrir el embalaje del producto o para entregar en forma "no tradicional" ( ventanas, techos, usando cuerdas o similar, etc.). 
    <br />
    - Se debe rechazar la entrega del producto si el embalaje del mismo se encuentra dañado o abierto. En cualquiera de estos casos se deberá notificar a Deluxebuys  dentro del plazo 3 días para tomar las medidas necesarias.
    
    
    <br /><br />
    Cualquier consulta que tengas podes dirigirte al formulario de contacto que se encuentra en <a style="color:#FD7977;" href="http://www.deluxebuys.com/consultas">www.deluxebuys.com/consultas</a>
    <br /><br />
    <strong>Muchas Gracias por tu compra!</strong>
</p>

<?php echo include_partial('mails/footer'); ?>