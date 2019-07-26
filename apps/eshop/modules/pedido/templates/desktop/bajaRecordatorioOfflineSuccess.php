<?php sfContext::getInstance()->getResponse()->setTitle( 'Vamos a dar de baja tu pedido. ¿Estás Seguro/a?' ); ?>

<section id="estatica" class="seccion blanco">
	<div class="container">
		<div class="linea"><div class="triangulos"></div></div>
		<div class="pantalla">
			<div class="titulo MS-23">VAMOS A DAR DE BAJA TU PEDIDO. ¿ESTÁS SEGURO/A?</div>
						
			<div class="texto OS-11 color4 lh18 text-center">
                <br />
                Daremos de baja tu pedido y ya no recibirás el recordatorio de pago por tu pedido #<?php echo $pedido->getIdPedido(); ?>,
                <br />
                pero antes necesitamos tu confirmación.
                <br /><br />
                <a class="rojo" href="<?php echo url_for('pedido_BajaRecordatorioOfflineOk', array( "hash" => $hash ) ); ?>">Si, deseo dar de baja el pedido</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="verde" href="<?php echo url_for('homepage')?>">No, prefiero seguri recorriendo el sitio</a>
			</div>
			
			
		</div>
	</div>
</section>