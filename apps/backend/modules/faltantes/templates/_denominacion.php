
<?php $denominacion = $faltante->getProductoItem()->getProducto()->getDenominacion(); ?>
<a href="/backend/productos/<?php echo $faltante->getProductoItem()->getIdProducto(); ?>/edit" title="<?php echo $denominacion; ?>" alt="<?php echo $denominacion; ?>"><?php echo truncate_text($denominacion, 25); ?></a>