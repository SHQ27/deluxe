<?php if ( $producto->getPublicacionMl() && $producto->getPublicacionMl()->estaVigente() ) : ?>
<img src="/backend/sfDoctrinePlugin/images/tick.png" title="Tiene Categoria de Mercado Libre" alt="Tiene Categoria de Mercado Libre">
<?php endif; ?>