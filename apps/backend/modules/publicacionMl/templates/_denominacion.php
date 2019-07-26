<?php $producto = $publicacion_ml->getProducto(); ?>
<a href="/backend/productos/<?php echo $producto->getIdProducto(); ?>/edit"><?php echo $producto->getDenominacion(); ?></a>