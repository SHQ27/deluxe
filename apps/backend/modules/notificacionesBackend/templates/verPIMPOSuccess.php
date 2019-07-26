<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<?php if ($error): ?>
<p class="ko">
	<strong>No se pudo realizar el proceso. Finalizo con el siguiente error:</strong>
	<br /><br />
	<?php echo $error; ?>
</p>

<?php else: ?>
<p class="ok"><strong>El proceso finalizo correctamente</strong></p>
<?php endif; ?>

<br/><br/>
Hace <a href="/backend/productos/importar">click aquí</a> para volver al primer paso.

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>