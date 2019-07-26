<?php if ( $faltante->getMontoDevuelto() ): ?>
$ <?php echo formatHelper::getInstance()->decimalNumber( $faltante->getMontoDevuelto() ); ?>
<?php endif; ?>