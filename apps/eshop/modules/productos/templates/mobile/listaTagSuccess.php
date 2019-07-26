<?php sfContext::getInstance()->getResponse()->setTitle('Productos - ' . $queryTag ); ?>

<div class="seccion listado categoria">
    <div class="texto"><?php echo $queryTag; ?></div>
</div>
<div class="arrow-down"></div>

<section class="seccion productos">

    <div class="resultados">
        <?php foreach ($productos as $producto): ?> 
        <div class="producto resultado">
            <div class="detalle">
                <div class="imagen">
                  <img class="image" src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_grande', $producto); ?>" width="100%" />
                </div>
                <div class="nombre"><?php echo truncate_text($producto->getDenominacion(), 20) ; ?></div>
                <div class="row precio">
                    <?php if ( $producto->getMostrarPrecioLista() ): ?>
                    <div class="col31 precioActual">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
                    <div class="col32">&nbsp;</div>
                    <div class="col33 precioViejo">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ) ?></div>
                    <?php else: ?>
                    <div class="col31">&nbsp;</div>
                    <div class="col32 precioActual">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></div>
                    <div class="col33">&nbsp;</div>
                    <?php endif; ?>
                </div>
                <a href="<?php echo $producto->getDetalleUrl(); ?>"></a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div id="contentPaginator">
        <?php if ($pager->getLastPage() != $pager->getPage()): ?>
            <a href="<?php echo $paginationBaseUrl . $pager->getNextPage(); ?>" class="next"><span></span> Siguiente</a>
        <?php endif; ?>
    </div>    
    
</section>