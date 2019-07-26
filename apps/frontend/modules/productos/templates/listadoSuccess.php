<?php if ( $productoCategoria ): ?>
<?php sfContext::getInstance()->getResponse()->setTitle( 'Descubrí todo en ' . $productoCategoria->getDenominacion() . ' de ' . $productoGenero->getDenominacion() ); ?>
<?php sfContext::getInstance()->getResponse()->addMeta('description', 'Comprá ' . $productoCategoria->getDenominacion() . ' de ' . $productoGenero->getDenominacion() .' en DeluxeBuys. La Tienda Online de Moda e Indumentaria hasta un 70% OFF' ); ?>
<?php sfContext::getInstance()->getResponse()->addMeta('keywords', $productoCategoria->getDenominacion() . ', ' . $productoGenero->getDenominacion()  . ', Indumentaria Femenina, Indumentaria Masculina, Ropa, Tienda Online, DeluxeBuys' ); ?>
<?php $itemRemarketing = $productoCategoria->getDenominacion() . ' de ' . $productoGenero->getDenominacion(); ?>
<?php else: ?>
<?php sfContext::getInstance()->getResponse()->setTitle( 'Descubrí todo para ' . $productoGenero->getDenominacion() ); ?>
<?php sfContext::getInstance()->getResponse()->addMeta('description', 'Comprá ropa y accesorios de ' . $productoGenero->getDenominacion() .' en DeluxeBuys. La Tienda Online de Moda e Indumentaria hasta un 70% OFF' ); ?>
<?php sfContext::getInstance()->getResponse()->addMeta('keywords', $productoGenero->getDenominacion()  . ', Indumentaria Femenina, Indumentaria Masculina, Ropa, Tienda Online, DeluxeBuys' ); ?>
<?php $itemRemarketing = $productoGenero->getDenominacion(); ?>
<?php endif; ?>

<div class="listadoProductos listaTags">

	<?php if ( $productoCategoria ): ?>
	<h1 class="fleft">Descubrí todo en <?php echo $productoCategoria->getDenominacion(); ?> de <?php echo $productoGenero->getDenominacion(); ?></h1>
	<?php $idProductoCategoria = $productoCategoria->getIdProductoCategoria(); ?>
	<?php else: ?>
	<h1 class="fleft">Descubrí todo para <?php echo $productoGenero->getDenominacion(); ?></h1>
	<?php $idProductoCategoria = null; ?>
	<?php endif; ?>
    

	<div class="clear"></div>
	
	
    <!--------- INICIO DE FILTRO -------->
    <?php 
    	include_component(
    		'common', 
    		'filter', 
    		array(
    			'filters'  => array('idProductoCategoria' => $idProductoCategoria, 'idProductoGenero' => $productoGenero->getIdProductoGenero(), 'rango' => $rango),
    			'query'    => $query
    		)
    	);
    ?>
    <!--------- FIN DEL FILTRO -------->
    
    <?php if ( !count($productos)): ?>
	<div class="no-results">No hay productos disponibles.</div>
	<?php else: ?>
    
    <div class="listado">
	    <?php $index = 0; ?>
	    <?php foreach ($productos as $producto): ?>
		<div class="item boxContainer listado <?php echo ($index % 3 == 2) ? 'columnRight' : ''; ?> <?php echo ($index % 3 == 0) ? 'columnLeft' : ''; ?>">
		
            <?php if ( $producto->getCurrentStock() < 3 && !$producto->estaAgotado()) : ?>
            <span class="lastUnits">¡ÚLTIMAS UNIDADES!</span>
            <?php endif; ?>
		
			<div class="insideBox">
			
                
                <?php if ( $producto->getProductoSticker() && $producto->getProductoSticker()->exists() ): ?>
                <div>
                    <img class="sticker" src="<?php echo imageHelper::getInstance()->getUrl('producto_sticker_chico', $producto->getProductoSticker() ); ?>" />
                </div>
                <?php endif; ?>
                
				<img src="<?php echo  imageHelper::getInstance()->getUrl('producto_lista_grande', $producto); ?>" width="293" height="443" />
                <?php if ( $producto->estaAgotado() ): ?>
                	<?php echo include_component('productos', 'waitList', array('producto' => $producto)); ?>
                <?php else: ?>
                <a class="link" href="<?php echo $producto->getDetalleUrl(); ?>"></a>
                <?php endif; ?>
				<div class="description">
					<div class="product">
						<h2><?php echo truncate_text( $producto->getMarca()->getNombre(), 25 ) ?></h2>
						<p><?php echo truncate_text( $producto->getDenominacion(), 25 ) ?></p>
					</div>
					<div class="prices">
					    <?php if ( $producto->getMostrarPrecioLista() ): ?>
						<span class="priceList">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioLista() ); ?></span>
						<?php else: ?>
						<span class="priceList no-data">&nbsp;</span>
						<?php endif; ?>
						<span class="offerPrice">$<?php echo formatHelper::getInstance()->formatPrice( $producto->getPrecioDeluxe() ) ?></span>
					</div>
				</div>
                
			</div>
		</div>
		<?php $index ++; ?>
		<?php endforeach; ?>


	</div>
	
                
	<div id="contentPaginator">
		<?php if ($pager->getLastPage() != $pager->getPage()): ?>
		    <a href="<?php echo $paginationBaseUrl . $pager->getNextPage(); ?>" class="next"><span></span> Siguiente</a>
		<?php endif; ?>
    </div>      
    
	<a class="sprite subir"></a>
    
    <?php endif; ?>

    <?php include_partial('global/tagsRemarketing', array('itemId1' => $itemRemarketing, 'pageType' => 'searchresults')); ?>
	
</div>