<?php include_partial('notificacionHeader', array('notificacionBackend' => $notificacionBackend)); ?>

<p class="notificacionMENSA"><?php echo $notificacionBackend->getResponse(ESC_RAW); ?></p>

<?php include_partial('notificacionFooter', array('notificacionBackend' => $notificacionBackend)); ?>