<?php include_partial('mails/headerESHOP', array('eshop' => $eshop, 'title' => $title) )?>
	
<p>
    <strong>Hola <?php echo ucfirst( $usuario->getNombre() ); ?> ¿Cómo estás?</strong>
    <br /><br />
	En este caso, te informo que el correo estará pasando a retirar el paquete dentro de las siguientes 48 horas hábiles de recibir este e-mail, en el horario de 8 a 19 horas.
    <br /><br />
    Podés entregarlo en caja o bolsa siempre y cuando la misma esté cerrada.
    <br /><br />
	Para verificar que el producto llegue en condiciones, te sugerimos que imprimas la siguiente etiqueta y la pegues en el frente del paquete
    <a style="color:#FD7977;" href="<?php echo $eshop->getDominio(); ?>/devoluciones/<?php echo $devolucion->getIdDevolucion(); ?>/imprimir-etiqueta">Hacé click para visualizar etiqueta</a>
    <br /><br />
	En el caso que no estés presente en el momento que pasen por el domicilio, estarán pasando una segunda vez. Si en ninguna de las 2 oportunidades podés entregar el paquete, te pedimos por favor que vuelvas a contactarnos para que solicitemos que hagan una nueva visita.
</p>

<?php echo include_partial('mails/footerESHOP', array('eshop' => $eshop) ) ?>