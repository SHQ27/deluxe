<?php  if ( $configuracion->getTipo() == configuracion::TIPO_BOOLEAN ): ?>
<?php echo $configuracion->getValor() ? 'Si' : 'No'; ?>
<?php elseif ( $configuracion->getTipo() == configuracion::TIPO_IMAGEN ): ?>
<img src="<?php echo $configuracion->getImage(); ?>" height="20" />
<?php else: ?>
<?php echo $configuracion->getValor(); ?>
<?php endif; ?>
