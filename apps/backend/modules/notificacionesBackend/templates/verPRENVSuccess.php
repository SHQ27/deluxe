<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<?php $response = $notificacionBackend->getResponseArray(); ?>

<p>
	<strong><?php echo $response['procesados']; ?> envío/s procesado/s</strong>
</p>


<?php if ( count($error)  ): ?>
<div class="errores">
	<h3>Los siguientes pedidos no pudieron informarse a EnvioPack</h3>
	<small>Momentáneamente te pedimos que te comuniques con soporte para solucionar el problema.</small>

	<br />

    <?php foreach ($error as $idPedido): ?>
    <br />
	<a href="/backend/pedidos/<?php echo $idPedido; ?>/ListView"><?php echo $idPedido; ?></a>
    <?php endforeach; ?>
</div>

<br /><br />
<br /><br />
<br /><br />

<?php endif; ?>

<?php if ( count($ok) ): ?>
<div>
	<h3>Los siguientes pedidos se informaron correctamente a EnvioPack</h3>
	<small>Podes verificar que pedidos estan listos para impresión de remitos filtrando en el listado de pedidos por estado "Pagado y Enviado"</small>

	<br />

    <?php foreach ($ok as $idPedido): ?>
    <br />
	<a href="/backend/pedidos/<?php echo $idPedido; ?>/ListView"><?php echo $idPedido; ?></a>
    <?php endforeach; ?>
</div>


<?php endif; ?>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>