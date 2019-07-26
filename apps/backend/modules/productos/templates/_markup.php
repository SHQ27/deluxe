<?php if ( (int) $producto->getCosto() ): ?>
<?php echo round( ( ( $producto->getPrecioDeluxe() / $producto->getCosto() ) - 1 ) * 100 ); ?>%
<?php else: ?>
-
<?php endif; ?>