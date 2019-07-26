<?php sfContext::getInstance()->getResponse()->setTitle( 'Vamos a dar de baja tu pedido. ¿Estás Seguro/a?' ); ?>

<div class="estatica">

	<h1>Vamos a dar de baja tu pedido. ¿Estás Seguro/a?</h1>
	
    <p>
        Daremos de baja tu pedido y ya no recibirás el recordatorio de pago por tu pedido #<?php echo $pedido->getIdPedido(); ?>, pero antes necesitamos tu confirmación.
    </p>
    
    <a class="button" href="<?php echo url_for('pedido_BajaRecordatorioOfflineOk', array( "hash" => $hash ) ); ?>">Si, deseo dar de baja el pedido</a>
    
    <a class="buttonSimple" href="<?php echo url_for('homepage')?>">No, prefiero seguri recorriendo el sitio</a>
    
    <p>
		Muchas gracias.
    </p>
    
	<p class="pie">
		deluxebuys.com
		<br/>
		Shopping Online de Moda
	<p>	
	
</div>