<?php $pedido = $faltante->getPedido(); ?>
<?php if ( !$faltante->getMontoDevuelto() ): ?>
<?php $detallado = $faltante->getMontoADevolver(true); ?>

<?php if ( !$pedido->getIdEshop() && $pedido->getIdFormaPago() != formaPago::MERCADOLIBRE ): ?>
<strong>Por Bonificacion:</strong>
<br />
$ <?php echo formatHelper::getInstance()->decimalNumber( $detallado['BONIFICACION'] ); ?>
<br /><br />
<?php endif; ?>

<strong>Por MP:</strong>
<br />  
$ <?php echo formatHelper::getInstance()->decimalNumber( $detallado['MP']['EFECTIVO'] ); ?> Efec.
<br />
$ <?php echo formatHelper::getInstance()->decimalNumber( $detallado['MP']['BONIFICACION'] ); ?> Bonif.
<?php endif; ?>