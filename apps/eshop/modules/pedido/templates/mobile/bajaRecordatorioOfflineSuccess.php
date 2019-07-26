<?php sfContext::getInstance()->getResponse()->setTitle( 'Vamos a dar de baja tu pedido. ¿Estás Seguro/a?' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="pantalla">
			<div class="titulo">VAMOS A DAR DE BAJA TU PEDIDO. ¿ESTAS SEGURO/A?</div>
						
			<div class="texto">
                <br />
                Daremos de baja tu pedido y ya no recibirás el recordatorio de pago por tu pedido #<?php echo $pedido->getIdPedido(); ?>,
                <br />
                pero antes necesitamos tu confirmación.
                <br /><br />
                <a class="rojo" href="<?php echo url_for('pedido_BajaRecordatorioOfflineOk', array( "hash" => $hash ) ); ?>">Si, deseo dar de baja el pedido</a>
                <br /><br />
                <a class="verde" href="<?php echo url_for('homepage')?>">No, prefiero seguir recorriendo el sitio</a>
			</div>
			
			
		</div>
	</div>
</section>