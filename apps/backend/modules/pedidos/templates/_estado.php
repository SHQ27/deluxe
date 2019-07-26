<?php if ($pedido->getFechaPago()): ?>
	<span class="verde">Pagado</span>
	<br/>

	<?php if ($pedido->getFechaEnvio()): ?>
	<span class="verde">Enviado</span>
	<?php elseif ($pedido->getEnvioIdPedidoEnvioPack()): ?>
	<span class="amarillo">Informado a EnvioPack</span>
	<?php else: ?>
	<span class="rojo">No enviado</span>
	<?php endif; ?>
	<br/>
	<?php if ($pedido->getFechaFacturacion()): ?>
		Facturado
	<?php else: ?>
		<span class="rojo">No Facturado</span>
	<?php endif; ?>
<?php else: ?>
	<span class="rojo">No pagado</span>
<?php endif; ?>
<?php if ($pedido->getFechaBaja()): ?>
	<br/>
	<span class="rojo">Eliminado</span>
<?php endif; ?>

<?php if ($pedido->getRequiereIntervencionManual() == 1): ?>
	<br/>
	<span class="amarillo"><strong>Requiere Intervencion Manual</strong></span>
<?php endif; ?>

<?php if ($pedido->getRequiereIntervencionManual() == 2): ?>
	<br/>
	<span class="rojo"><strong>Requiere Intervencion Manual</strong></span>
<?php endif; ?>

<?php if ($pedido->getTieneProblemaOca()): ?>
	<br/>
	<span class="amarillo"><strong>Tiene Problemas OCA</strong></span>
<?php endif; ?>