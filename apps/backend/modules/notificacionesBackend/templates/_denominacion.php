<?php echo $notificacion_backend->getDenominacion(); ?>
<?php if ( $notificacion_backend->getTipo() == notificacionBackend::TIPO_MENSAJE ): ?>
: <i><?php echo truncate_text( strip_tags( $notificacion_backend->getResponse(ESC_RAW) ), 100 ); ?></i>
<?php endif; ?>