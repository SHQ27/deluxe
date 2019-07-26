<?php if ( $devuelto_oca->getFechaRetirado() ): ?>
<?php echo $devuelto_oca->getDateTimeObject('fecha_retirado')->format("d/m/Y") ?>
<?php endif; ?>