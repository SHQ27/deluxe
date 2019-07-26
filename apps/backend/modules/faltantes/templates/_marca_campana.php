<?php echo $faltante->getProductoItem()->getProducto()->getMarca()->getNombre(); ?>

<?php if ( $faltante->getCampana() ): ?>
/
<br /> 
<?php echo $faltante->getCampana(); ?>
<?php endif; ?>