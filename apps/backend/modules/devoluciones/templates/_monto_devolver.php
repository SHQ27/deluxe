<?php if ( $devolucion->getMontoTotal() ): ?>
$ <?php echo formatHelper::getInstance()->decimalNumber( $devolucion->getMontoTotal() ); ?>
<?php else: ?>
$ <?php echo formatHelper::getInstance()->decimalNumber( $devolucion->calcularMontoTotal() ); ?>
<?php endif; ?>